<?php
/**
 * front-page.php — Homepage Template
 *
 * WordPress automatically uses this file for the static front page.
 * Set it via: Settings → Reading → "A static page" → Front page
 */
get_header();

$t = get_template_directory_uri();

// Desktop & Mobile hero slideshow images (shared set)
$slides = [
    [ 'file' => 'anim-1.webp',   'ext' => 'webp'  ],
    [ 'file' => 'anim-2.webp',   'ext' => 'webp'  ],
    [ 'file' => 'anim-3.webp',   'ext' => 'webp'  ],
    [ 'file' => 'anim-4.webp',   'ext' => 'webp'  ],
    [ 'file' => 'anim-5.webp',   'ext' => 'webp'  ],
    [ 'file' => 'anim-6.webp',   'ext' => 'webp'  ],
    [ 'file' => 'anim-7.webp',   'ext' => 'webp'  ],
    [ 'file' => 'anim-8.webp',   'ext' => 'webp'  ],
    [ 'file' => 'anim-9.webp',   'ext' => 'webp'  ],
    [ 'file' => 'anim-10.webp',  'ext' => 'webp'  ],
    [ 'file' => 'anim-11.webp',  'ext' => 'webp'  ],
];
?>

    <!-- ═══════════════════════════════ HERO SECTION ══════════════════════════════ -->
    <main>
        <section id="home" class="hero">

            <!-- Desktop Slideshow -->
            <div class="hero-bg desktop-bg">
                <?php foreach ( $slides as $i => $slide ) :
                    $num = $i + 1;
                    $url = esc_url( $t . '/assets/' . $slide['file'] );
                ?>
                <div class="hero-slide slide-<?php echo $num; ?>"
                     <?php if ( $i === 0 ) : ?>
                         style="background-image: url('<?php echo $url; ?>');"
                     <?php else : ?>
                         data-bg="<?php echo $url; ?>"
                     <?php endif; ?>
                     aria-hidden="true"></div>
                <?php endforeach; ?>
            </div>

            <!-- Mobile Slideshow -->
            <div class="hero-bg mobile-bg">
                <?php foreach ( $slides as $i => $slide ) :
                    $num = $i + 1;
                    $url = esc_url( $t . '/assets/' . $slide['file'] );
                ?>
                <div class="hero-slide m-slide-<?php echo $num; ?>"
                     <?php if ( $i === 0 ) : ?>
                         style="background-image: url('<?php echo $url; ?>');"
                     <?php else : ?>
                         data-bg="<?php echo $url; ?>"
                     <?php endif; ?>
                     aria-hidden="true"></div>
                <?php endforeach; ?>
            </div>

            <div class="hero-overlay"></div>

            <!-- Hero Text & Buttons -->
            <div class="hero-content">
                <h1 class="typewriter-text" id="typewriter-heading"></h1>
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

<?php get_footer(); ?>
