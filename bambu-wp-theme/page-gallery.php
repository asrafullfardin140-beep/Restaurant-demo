<?php
/**
 * Template Name: Bambu Gallery
 * Template Post Type: page
 */
add_filter( 'body_class', function( $classes ) {
    $classes[] = 'gallery-page';
    return $classes;
} );

get_header();
$t = get_template_directory_uri();
?>

    <main>
        <header class="gallery-hero">
            <img src="<?php echo esc_url( $t ); ?>/assets/anim-11.webp" alt="A colourful Bambu dish served with rice" width="2048" height="1366" fetchpriority="high">
            <div class="gallery-hero-shade" aria-hidden="true"></div>
            <div class="gallery-hero-content">
                <p class="gallery-kicker">Indian &amp; Thai dining in Limerick</p>
                <h1>The Bambu<br><em>Experience</em></h1>
                <p>From our kitchen to your table.</p>
            </div>
            <a href="#gallery" class="gallery-scroll-cue" aria-label="Explore the gallery">
                <span>EXPLORE</span><span class="gallery-scroll-line"></span>
            </a>
        </header>

        <section class="gallery-experience" id="gallery" aria-labelledby="gallery-title">
            <div class="gallery-heading-row">
                <div>
                    <div class="section-label-container">
                        <span class="section-line"></span>
                        <span class="section-label">Inside Bambu</span>
                    </div>
                    <h2 id="gallery-title">A glimpse of the<br><em>flavours and atmosphere.</em></h2>
                </div>
                <p class="gallery-intro">Discover dishes from both sides of our menu, the details of our dining room, and the moments that make an evening at Bambu memorable.</p>
            </div>

            <div class="gallery-toolbar">
                <div class="gallery-filters" role="group" aria-label="Filter gallery">
                    <button type="button" class="gallery-filter is-active" data-filter="all" aria-pressed="true">All</button>
                    <button type="button" class="gallery-filter" data-filter="food" aria-pressed="false">Food</button>
                    <button type="button" class="gallery-filter" data-filter="restaurant" aria-pressed="false">Restaurant</button>
                </div>
                <p class="gallery-swipe-hint"><span aria-hidden="true">&larr;</span> Drag or swipe to explore <span aria-hidden="true">&rarr;</span></p>
            </div>

            <div class="gallery-carousel" role="region" aria-roledescription="carousel" aria-label="Bambu restaurant gallery">
                <div class="gallery-track" id="gallery-track" tabindex="0">
                    <article class="gallery-panel" data-category="food" aria-label="Food gallery panel 1 of 4">
                        <button class="gallery-card gallery-card-main" type="button" data-caption="A rich curry served at Bambu">
                            <img src="<?php echo esc_url( $t ); ?>/assets/dish-img-1.webp" alt="Rich curry served in a traditional black dish" width="1024" height="683" loading="eager" decoding="async">
                            <span>Indian favourites</span>
                        </button>
                        <button class="gallery-card" type="button" data-caption="A selection from our Indian and Thai menu">
                            <img src="<?php echo esc_url( $t ); ?>/assets/dish-img-2.webp" alt="A table filled with Indian and Thai dishes" width="1024" height="683" loading="lazy" decoding="async">
                            <span>Made for sharing</span>
                        </button>
                        <button class="gallery-card" type="button" data-caption="Starters prepared for the table">
                            <img src="<?php echo esc_url( $t ); ?>/assets/food4.webp" alt="A selection of Bambu starters with dipping sauces" width="1024" height="683" loading="lazy" decoding="async">
                            <span>Start the evening</span>
                        </button>
                    </article>

                    <article class="gallery-panel gallery-panel-reverse" data-category="food" aria-label="Food gallery panel 2 of 4">
                        <button class="gallery-card gallery-card-main" type="button" data-caption="A colourful Thai dish served with rice">
                            <img src="<?php echo esc_url( $t ); ?>/assets/anim-11.webp" alt="Colourful Thai dish with vegetables and rice" width="2048" height="1366" loading="lazy" decoding="async">
                            <span>Thai flavours</span>
                        </button>
                        <button class="gallery-card" type="button" data-caption="Pad Thai prepared at Bambu">
                            <img src="<?php echo esc_url( $t ); ?>/assets/story-img.webp" alt="Pad Thai with prawns, vegetables, peanuts, and lemon" width="1024" height="683" loading="lazy" decoding="async">
                            <span>Bright &amp; aromatic</span>
                        </button>
                        <button class="gallery-card" type="button" data-caption="Dinner for the whole table">
                            <img src="<?php echo esc_url( $t ); ?>/assets/food2.webp" alt="A generous table of curries, noodles, starters, and wine" width="1024" height="683" loading="lazy" decoding="async">
                            <span>Two cuisines, one table</span>
                        </button>
                    </article>

                    <article class="gallery-panel" data-category="restaurant" aria-label="Restaurant gallery panel 3 of 4">
                        <button class="gallery-card gallery-card-main" type="button" data-caption="The warm Bambu dining room">
                            <img src="<?php echo esc_url( $t ); ?>/assets/food1.webp" alt="Bambu dining room with warm lighting and decorative wall art" width="640" height="427" loading="lazy" decoding="async">
                            <span>The dining room</span>
                        </button>
                        <button class="gallery-card" type="button" data-caption="A quiet table ready for dinner">
                            <img src="<?php echo esc_url( $t ); ?>/assets/hero-7.webp" alt="A table set for two inside Bambu" width="1024" height="768" loading="lazy" decoding="async">
                            <span>Ready for your evening</span>
                        </button>
                        <button class="gallery-card" type="button" data-caption="Bambu on O'Connell Street, Limerick">
                            <img src="<?php echo esc_url( $t ); ?>/assets/hero-5.webp" alt="Bambu Restaurant entrance on O'Connell Street" width="1024" height="1024" loading="lazy" decoding="async">
                            <span>In the heart of Limerick</span>
                        </button>
                    </article>

                    <article class="gallery-panel gallery-panel-reverse" data-category="food restaurant" aria-label="Bambu moments gallery panel 4 of 4">
                        <button class="gallery-card gallery-card-main" type="button" data-caption="A memorable evening at Bambu">
                            <img src="<?php echo esc_url( $t ); ?>/assets/anim-7.webp" alt="A Bambu dish presented for dinner" width="2048" height="1366" loading="lazy" decoding="async">
                            <span>Evenings at Bambu</span>
                        </button>
                        <button class="gallery-card" type="button" data-caption="Tables ready for an evening at Bambu">
                            <img src="<?php echo esc_url( $t ); ?>/assets/hero-3.webp" alt="Bambu dining room with set tables and warm pendant lighting" width="1024" height="768" loading="lazy" decoding="async">
                            <span>Set for the evening</span>
                        </button>
                        <button class="gallery-card" type="button" data-caption="A warm welcome from the moment you arrive">
                            <img src="<?php echo esc_url( $t ); ?>/assets/hero-6.webp" alt="Bambu reception area with patterned seating and plants" width="1024" height="738" loading="lazy" decoding="async">
                            <span>A warm welcome</span>
                        </button>
                    </article>
                </div>

                <div class="gallery-controls">
                    <div class="gallery-arrows">
                        <button class="gallery-arrow" id="gallery-prev" type="button" aria-label="Previous gallery panel" disabled>&larr;</button>
                        <button class="gallery-arrow" id="gallery-next" type="button" aria-label="Next gallery panel">&rarr;</button>
                    </div>
                    <div class="gallery-progress" aria-hidden="true"><span id="gallery-progress-bar"></span></div>
                    <p class="gallery-counter" aria-live="polite"><span id="gallery-current">01</span> / <span id="gallery-total">04</span></p>
                </div>
            </div>
        </section>

        <section class="gallery-cta" aria-labelledby="gallery-cta-title">
            <p class="section-label">Your table is waiting</p>
            <h2 id="gallery-cta-title">Come and experience<br><em>Bambu for yourself.</em></h2>
            <div class="gallery-cta-actions">
                <a href="#" class="btn-solid btn-plain btn-book">BOOK A TABLE</a>
                <a href="https://bambulimerick.ie/order-now" target="_blank" rel="noopener" class="btn-text">Order online &rarr;</a>
            </div>
        </section>
    </main>

    <div class="gallery-lightbox" id="gallery-lightbox" role="dialog" aria-modal="true" aria-labelledby="lightbox-caption" hidden>
        <div class="gallery-lightbox-backdrop" data-lightbox-close></div>
        <div class="gallery-lightbox-shell">
            <button class="gallery-lightbox-close" type="button" aria-label="Close image viewer" data-lightbox-close>&times;</button>
            <button class="gallery-lightbox-nav gallery-lightbox-prev" type="button" aria-label="Previous image">&larr;</button>
            <figure>
                <img id="lightbox-image" src="<?php echo esc_url( $t ); ?>/assets/dish-img-1.webp" alt="">
                <figcaption id="lightbox-caption"></figcaption>
            </figure>
            <button class="gallery-lightbox-nav gallery-lightbox-next" type="button" aria-label="Next image">&rarr;</button>
        </div>
    </div>



<?php get_footer(); ?>
