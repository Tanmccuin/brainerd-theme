<?php
/**
 * Single portfolio entry — Brainerd theme.
 *
 * Layout: project header (role, title, description, CTA) → staggered image grid.
 * Uses get_header()/get_footer() for WP hooks + renders site chrome via PHP.
 */

get_header();

$site_name = get_bloginfo( 'name' );
$nav_items = wp_get_nav_menu_items( 'primary' );
?>
<header class="brainerd-header" role="banner">
	<div class="brainerd-header__inner">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brainerd-header__logo" aria-label="<?php echo esc_attr( $site_name ); ?> — home">
			<?php if ( has_custom_logo() ) : ?>
				<?php
				$logo_id  = get_theme_mod( 'custom_logo' );
				$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
				?>
				<img src="<?php echo esc_url( $logo_url ); ?>"
					alt="<?php echo esc_attr( $site_name ); ?>" width="240" height="36" decoding="async">
			<?php else : ?>
				<span class="brainerd-header__site-name"><?php echo esc_html( $site_name ); ?></span>
			<?php endif; ?>
		</a>
		<nav class="brainerd-header__nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'brainerd' ); ?>">
			<?php
			if ( $nav_items ) {
				foreach ( $nav_items as $item ) {
					printf( '<a href="%s">%s</a>', esc_url( $item->url ), esc_html( $item->title ) );
				}
			}
			?>
		</nav>
		<a class="brainerd-header__cta" href="/contact/"><?php esc_html_e( 'GET IN TOUCH', 'brainerd' ); ?></a>
		<button class="brainerd-header__toggle" aria-expanded="false" aria-controls="brainerd-mobile-nav" aria-label="<?php esc_attr_e( 'Open menu', 'brainerd' ); ?>">
			<svg class="brainerd-header__toggle-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
			<svg class="brainerd-header__toggle-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12"/></svg>
		</button>
	</div>
</header>

<div class="brainerd-mobile-nav" id="brainerd-mobile-nav" role="dialog" aria-label="<?php esc_attr_e( 'Navigation menu', 'brainerd' ); ?>" aria-modal="true" data-open="false">
	<nav class="brainerd-mobile-nav__links" aria-label="<?php esc_attr_e( 'Mobile navigation', 'brainerd' ); ?>">
		<?php
		if ( $nav_items ) {
			foreach ( $nav_items as $item ) {
				printf( '<a href="%s">%s</a>', esc_url( $item->url ), esc_html( $item->title ) );
			}
		}
		?>
	</nav>
	<a class="brainerd-mobile-nav__cta" href="/contact/"><?php esc_html_e( 'GET IN TOUCH', 'brainerd' ); ?></a>
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
						<?php esc_html_e( 'View live site', 'brainerd' ); ?>
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

<?php get_footer(); ?>
