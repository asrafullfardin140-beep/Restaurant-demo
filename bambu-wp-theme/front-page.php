<?php
/**
 * front-page.php — Homepage Template
 *
 * WordPress automatically uses this file for the static front page.
 * Set it via: Settings → Reading → "A static page" → Front page
 */
get_header();

$t = get_template_directory_uri();

?>

    <!-- ═══════════════════════════════ HERO SECTION ══════════════════════════════ -->
    <main>
        <section id="home" class="hero">

            <div class="hero-bg hero-video-bg" aria-hidden="true">
                <picture>
                    <source media="(max-width: 768px)" srcset="<?php echo esc_url( $t ); ?>/assets/video/hero-mobile.webp">
                    <img class="hero-video-poster" src="<?php echo esc_url( $t ); ?>/assets/video/hero-desktop.webp" alt="" fetchpriority="high">
                </picture>
                <video class="hero-video" muted loop playsinline preload="none" tabindex="-1"
                    data-mobile="<?php echo esc_url( $t ); ?>/assets/video/hero-mobile.mp4"
                    data-desktop="<?php echo esc_url( $t ); ?>/assets/video/hero-desktop.mp4"></video>
            </div>
            <button class="hero-video-toggle" type="button" hidden>Play background video</button>

            <div class="hero-overlay"></div>

            <!-- Hero Text & Buttons -->
            <div class="hero-content">
                <h1 class="home-location-heading">Indian &amp; Thai Restaurant<br><em>in Limerick</em></h1><p class="typewriter-text home-tagline" id="typewriter-heading"></p>
                <div class="hero-buttons">
                    <a href="#" class="btn-solid btn-book">BOOK A TABLE</a>
                    <a href="https://bambulimerick.ie/order-now"
                       target="_blank" rel="noopener"
                       class="btn-solid light">ORDER ONLINE</a>
                    <a href="tel:+35361217661" class="btn-solid">CALL NOW</a>
                </div>
            </div>

            <!-- Scroll Indicator -->
            <div class="scroll-indicator" aria-hidden="true">
                <div class="scroll-line"></div>
                <span>SCROLL</span>
            </div>

        </section>
    </main>
    <!-- ════════════════════════════ END HERO SECTION ═════════════════════════════ -->

<section class="home-introduction"><p class="section-label">Welcome to Bambu</p><h2>Two great cuisines.<br><em>One warm welcome.</em></h2><p>Indian and Thai dining at 28 O'Connell Street, Limerick. Settle in for a favourite curry, fragrant noodles and an evening around the table.</p><a class="btn-text" href="<?php echo esc_url( home_url( '/our-story/' ) ); ?>">Our Story &rarr;</a></section><section class="home-cuisine"><a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/dish-img-1.webp" alt="Indian curry served in a black dish" width="1024" height="683" loading="lazy"><h2>Indian <em>favourites.</em></h2><p>Rich curries, tandoori starters and aromatic biryani.</p><span class="btn-text">Explore Menu &rarr;</span></a><a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/story-img.webp" alt="Pad Thai with prawns and vegetables" width="1024" height="683" loading="lazy"><h2>Thai <em>flavours.</em></h2><p>Bright noodles and fragrant curries, ready to share.</p><span class="btn-text">Explore Menu &rarr;</span></a></section><section class="home-gallery"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/anim-4.webp" alt="The Bambu dining room" width="1535" height="1024" loading="lazy"><div><p class="section-label">Inside Bambu</p><h2>A glimpse of<br><em>your evening.</em></h2><a class="btn-text" href="<?php echo esc_url( home_url( '/gallery/' ) ); ?>">View Gallery &rarr;</a></div></section><section class="home-introduction"><h2>Your table <em>is waiting.</em></h2><div class="page-actions"><a href="#" class="btn-text btn-book">Book a table &rarr;</a><a class="btn-text" href="https://maps.app.goo.gl/QWcCknw64kSChXoe8" target="_blank" rel="noopener">Get Directions &rarr;</a><a class="btn-text" href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">Plan your visit &rarr;</a></div></section>

<?php get_footer(); ?>
