<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bambu Indian & Thai Restaurant, Limerick — Award-winning Indian and Thai cuisine in the heart of Limerick City. Book a table online or call +353 61 217 661.">
    <meta name="theme-color" content="#0f0d0c">
    <?php
    $bambu_preload_image = ( is_page_template( 'page-gallery.php' ) || is_page( 'gallery' ) )
        ? '/assets/anim-11.webp'
        : '/assets/anim-1.webp';
    ?>
    <link rel="preload" href="<?php echo esc_url( get_template_directory_uri() . $bambu_preload_image ); ?>" as="image" type="image/webp" fetchpriority="high">
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/css/site-pages.css">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/js/site-pages.js"></script>

<?php
// Preload frequently used URI
$t = get_template_directory_uri();
?>

    <!-- ═══════════════════════════════════ NAVBAR ═══════════════════════════════════ -->
    <nav class="navbar" id="main-navbar">
        <div class="nav-container">

            <!-- Mobile: Left actions -->
            <div class="mobile-actions left">
                <button class="mobile-icon-btn menu-toggle" aria-label="Open navigation menu">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12h18M3 6h18M3 18h18"/>
                    </svg>
                </button>
                <button class="mobile-icon-btn btn-book calendar-btn" aria-label="Book a table">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </button>
            </div>

            <!-- Logo -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-container">
                <img src="<?php echo esc_url( $t ); ?>/assets/logo.jpg" alt="Bambu Restaurant Logo" class="logo-img">
                <div class="logo-text">
                    <span class="logo-title">Bambu</span>
                    <span class="logo-subtitle">INDIAN &amp; THAI &middot; LIMERICK</span>
                </div>
            </a>

            <!-- Mobile: Right actions -->
            <div class="mobile-actions right">
                <a href="tel:+35361217661" class="mobile-icon-btn phone-btn" aria-label="Call us">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </a>
                <a href="https://bambulimerick.ie/order-now" target="_blank" rel="noopener" class="mobile-icon-btn order-btn" aria-label="Order online">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                </a>
            </div>

            <!-- Desktop navigation links -->
            <div class="nav-links">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>#home">HOME</a>
<a href="<?php echo esc_url( home_url( '/our-story/' ) ); ?>">OUR STORY</a>
<a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">VISIT &amp; FAQs</a>
                <a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>"<?php echo ( is_page_template( 'page-gallery.php' ) || is_page( 'gallery' ) ) ? ' aria-current="page"' : ''; ?>>GALLERY</a>
                <a href="https://maps.app.goo.gl/QWcCknw64kSChXoe8" target="_blank" rel="noopener">GET DIRECTIONS</a>
                <span class="nav-separator"></span>
                <a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>" class="btn-nav">MENU</a>
                <a href="https://bambulimerick.ie/order-now" target="_blank" rel="noopener" class="btn-nav">ORDER ONLINE</a>
                <a href="#" class="btn-nav btn-book">BOOK A TABLE</a>
            </div>

            <!-- Mobile dropdown navigation -->
            <div class="mobile-nav-menu" id="mobile-nav-menu">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>#home">HOME</a>
<a href="<?php echo esc_url( home_url( '/our-story/' ) ); ?>">OUR STORY</a>
<a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">VISIT &amp; FAQs</a>
                <a href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>"<?php echo ( is_page_template( 'page-gallery.php' ) || is_page( 'gallery' ) ) ? ' aria-current="page"' : ''; ?>>GALLERY</a>
                <a href="https://maps.app.goo.gl/QWcCknw64kSChXoe8" target="_blank" rel="noopener">GET DIRECTIONS</a>
                <a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>">MENU</a>
            </div>

        </div>
    </nav>
    <!-- ════════════════════════════════ END NAVBAR ═════════════════════════════════ -->
