<?php
/**
 * Single portfolio entry — Brainerd theme.
 *
 * Layout: project header (role, title, description, CTA) → staggered image grid.
 */

get_header();

// Render the site header (same markup as parts/header.html).
?>
<header class="brainerd-header" role="banner">
	<div class="brainerd-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brainerd-header__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — home">
			<img src="/wp-content/uploads/2021/07/tannermooredesign-dark-1024x152-1.png"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="240" height="36" decoding="async">
		</a>
		<nav class="brainerd-header__nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'brainerd' ); ?>">
			<a href="/portfolio/">Portfolio</a>
			<a href="/services/">Services &amp; Hosting</a>
			<a href="/accessibility-and-why-it-matters/">Accessibility</a>
			<a href="/about/">About</a>
			<a href="/contact/">Contact</a>
		</nav>
		<a class="brainerd-header__cta" href="/contact/">LET&#8217;S TALK</a>
		<button class="brainerd-header__toggle" aria-expanded="false" aria-controls="brainerd-mobile-nav" aria-label="<?php esc_attr_e( 'Open menu', 'brainerd' ); ?>">
			<svg class="brainerd-header__toggle-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
			<svg class="brainerd-header__toggle-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
		</button>
	</div>
</header>

<div class="brainerd-mobile-nav" id="brainerd-mobile-nav" role="dialog" aria-label="<?php esc_attr_e( 'Navigation menu', 'brainerd' ); ?>" aria-modal="true" data-open="false">
	<nav class="brainerd-mobile-nav__links" aria-label="<?php esc_attr_e( 'Mobile navigation', 'brainerd' ); ?>">
		<a href="/portfolio/">Portfolio</a>
		<a href="/services/">Services &amp; Hosting</a>
		<a href="/accessibility-and-why-it-matters/">Accessibility</a>
		<a href="/about/">About</a>
		<a href="/contact/">Contact</a>
	</nav>
	<a class="brainerd-mobile-nav__cta" href="/contact/">LET&#8217;S TALK</a>
	<div class="brainerd-mobile-nav__contact">
		<a href="tel:+18023554520">802.355.4520</a>
		<a href="mailto:tanner@tannermooredesign.com">tanner@tannermooredesign.com</a>
	</div>
</div>

<?php while ( have_posts() ) : the_post(); ?>

<article class="cb-portfolio-single" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="cb-portfolio-single__header">
		<div class="cb-portfolio-single__info">
			<?php $role = get_field( 'role' ); ?>
			<?php if ( $role ) : ?>
				<p class="cb-portfolio-single__role"><?php echo esc_html( $role ); ?></p>
			<?php endif; ?>

			<h1 class="cb-portfolio-single__title"><?php the_title(); ?></h1>

			<?php $description = get_field( 'description' ); ?>
			<?php if ( $description ) : ?>
				<div class="cb-portfolio-single__description">
					<p><?php echo esc_html( $description ); ?></p>
				</div>
			<?php endif; ?>

			<div class="cb-portfolio-single__actions">
				<?php $url = get_field( 'project_url' ); ?>
				<?php if ( $url ) : ?>
					<a class="cb-portfolio-single__cta" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
						View live site
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
					</a>
				<?php endif; ?>
				<a class="cb-portfolio-single__back" href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>">
					← <?php esc_html_e( 'Back to portfolio', 'brainerd' ); ?>
				</a>
			</div>
		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="cb-portfolio-single__featured">
				<?php the_post_thumbnail( 'full', [ 'loading' => 'eager', 'alt' => get_the_title() ] ); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php
	$thumb_id   = get_post_thumbnail_id();
	$all_images = get_posts( [
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'posts_per_page' => -1,
		'post_parent'    => get_the_ID(),
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'exclude'        => $thumb_id ? [ $thumb_id ] : [],
	] );

	if ( $all_images ) :
	?>
		<div class="cb-portfolio-single__gallery" aria-label="<?php esc_attr_e( 'Project screenshots', 'brainerd' ); ?>">
			<?php foreach ( $all_images as $index => $img ) :
				$src    = wp_get_attachment_image_src( $img->ID, 'large' );
				$alt    = get_post_meta( $img->ID, '_wp_attachment_image_alt', true ) ?: get_the_title() . ' — screenshot ' . ( $index + 1 );
				$meta   = wp_get_attachment_metadata( $img->ID );
				$w      = $meta['width'] ?? 1;
				$h      = $meta['height'] ?? 1;
				$is_tall = ( $h / $w ) > 1.2;
			?>
				<figure class="cb-portfolio-single__gallery-item<?php echo $is_tall ? ' cb-portfolio-single__gallery-item--tall' : ''; ?>">
					<img
						src="<?php echo esc_url( $src[0] ); ?>"
						alt="<?php echo esc_attr( $alt ); ?>"
						width="<?php echo esc_attr( $src[1] ); ?>"
						height="<?php echo esc_attr( $src[2] ); ?>"
						loading="lazy"
						decoding="async">
				</figure>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="cb-portfolio-single__closing">
		<a class="cb-portfolio-single__closing-back" href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
			<?php esc_html_e( 'Back to portfolio', 'brainerd' ); ?>
		</a>
		<a class="cb-portfolio-single__closing-cta" href="/contact/">
			<?php esc_html_e( 'Start a project like this', 'brainerd' ); ?>
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
		</a>
	</div>

</article>

<?php endwhile; ?>

<footer class="tmd-site-footer" role="contentinfo">
	<div class="tmd-site-footer__accent" aria-hidden="true"></div>
	<div class="tmd-site-footer__inner">
		<div class="tmd-site-footer__brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tmd-site-footer__logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — home">
				<img src="/wp-content/uploads/2021/07/tannermooredesign-dark-1024x152-1.png"
					alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="200" height="30" decoding="async" loading="lazy">
			</a>
			<p class="tmd-site-footer__tagline">Vermont WordPress Design, Development &amp; Consulting</p>
			<p class="tmd-site-footer__copy">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Tannermooredesign // A Brainerd Street Picture Co.</p>
		</div>
		<div class="tmd-site-footer__col">
			<p class="tmd-site-footer__col-label"><?php esc_html_e( 'Navigation', 'brainerd' ); ?></p>
			<nav class="tmd-site-footer__nav" aria-label="<?php esc_attr_e( 'Footer navigation', 'brainerd' ); ?>">
				<a href="/portfolio/">Portfolio</a>
				<a href="/services/">Services &amp; Hosting</a>
				<a href="/accessibility-and-why-it-matters/">Accessibility</a>
				<a href="/about/">About</a>
				<a href="/contact/">Contact</a>
			</nav>
		</div>
		<div class="tmd-site-footer__col">
			<p class="tmd-site-footer__col-label"><?php esc_html_e( 'Get in touch', 'brainerd' ); ?></p>
			<div class="tmd-site-footer__contact">
				<a href="tel:+18023554520" class="tmd-site-footer__contact-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
					802.355.4520
				</a>
				<a href="mailto:tanner@tannermooredesign.com" class="tmd-site-footer__contact-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
					tanner@tannermooredesign.com
				</a>
			</div>
		</div>
	</div>
</footer>

<?php get_footer(); ?>
