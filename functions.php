<?php
/**
 * Brainerd — FSE theme functions.
 *
 * Minimal: font loading, dark mode, nav registration.
 * All block code lives in the brainerd-blocks companion plugin.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

add_action( 'wp_enqueue_scripts', function (): void {
	wp_enqueue_style(
		'brainerd-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_style(
		'brainerd-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,700;9..144,900&family=Inter:wght@400;500&display=swap',
		[],
		null
	);
} );

add_action( 'after_setup_theme', function (): void {
	register_nav_menus( [
		'primary' => __( 'Primary Navigation', 'brainerd' ),
	] );
	add_theme_support( 'wp-block-template-part' );
} );

// Dark mode: apply class before first paint.
add_action( 'wp_head', function (): void {
	?>
	<script>
	(function(){
		try {
			if ( localStorage.getItem('tmd-dark') === '1' ) {
				document.documentElement.classList.add('tmd-dark');
			}
		} catch(e){}
	})();
	</script>
	<?php
}, 1 );

// Dark mode toggle — floating button.
add_action( 'wp_body_open', function (): void {
	?>
	<button
		class="tmd-dark-toggle"
		data-dark-toggle
		type="button"
		aria-label="<?php esc_attr_e( 'Toggle dark mode', 'brainerd' ); ?>"
		aria-pressed="false">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
			stroke="currentColor" stroke-width="1.75" stroke-linecap="round"
			stroke-linejoin="round" aria-hidden="true" class="tmd-dark-toggle__icon-moon">
			<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
		</svg>
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
			stroke="currentColor" stroke-width="1.75" stroke-linecap="round"
			stroke-linejoin="round" aria-hidden="true" class="tmd-dark-toggle__icon-sun">
			<circle cx="12" cy="12" r="5"/>
			<path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
		</svg>
	</button>
	<?php
} );

// Mobile nav — toggle, focus trap, Escape key, scroll lock.
// Disabled if brainerd_companion_disabled_mobile_nav option is set (allows 3rd-party replacement).
add_action( 'wp_footer', function (): void {
	if ( get_option( 'brainerd_companion_disabled_mobile_nav' ) ) {
		return;
	}
	?>
	<script>
	(function(){
		var toggle = document.querySelector('.brainerd-header__toggle');
		var overlay = document.getElementById('brainerd-mobile-nav');
		if (!toggle || !overlay) return;

		var focusable = overlay.querySelectorAll('a, button');
		var firstFocus = focusable[0];
		var lastFocus = focusable[focusable.length - 1];
		var returnFocus = null;

		function open() {
			returnFocus = document.activeElement;
			overlay.setAttribute('data-open', 'true');
			toggle.setAttribute('aria-expanded', 'true');
			document.body.style.overflow = 'hidden';
			if (firstFocus) firstFocus.focus();
		}

		function close() {
			overlay.setAttribute('data-open', 'false');
			toggle.setAttribute('aria-expanded', 'false');
			document.body.style.overflow = '';
			if (returnFocus) returnFocus.focus();
		}

		function isOpen() {
			return overlay.getAttribute('data-open') === 'true';
		}

		toggle.addEventListener('click', function() {
			isOpen() ? close() : open();
		});

		overlay.querySelectorAll('a').forEach(function(link) {
			link.addEventListener('click', close);
		});

		document.addEventListener('keydown', function(e) {
			if (!isOpen()) return;
			if (e.key === 'Escape') { close(); return; }
			if (e.key === 'Tab') {
				if (e.shiftKey) {
					if (document.activeElement === firstFocus) { e.preventDefault(); lastFocus.focus(); }
				} else {
					if (document.activeElement === lastFocus) { e.preventDefault(); firstFocus.focus(); }
				}
			}
		});
	})();
	</script>
	<?php
}, 99 );
