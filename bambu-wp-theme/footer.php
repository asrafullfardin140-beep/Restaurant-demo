<?php
/**
 * footer.php — Footer Template
 *
 * Contains: site footer, booking modal, menu viewer modal,
 * WordPress wp_footer() hook, and closing body/html tags.
 */
$t = get_template_directory_uri();
?>

    <!-- ═══════════════════════════════ SITE FOOTER ═══════════════════════════════ -->
    <footer id="contact" class="site-footer">
 <div class="footer-layout">
  <div class="footer-brand"><a class="logo-container" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Bambu home"><img class="logo-img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/logo.webp" alt="" width="68" height="68" loading="lazy"><span class="logo-title">Bambu</span></a><p class="footer-tagline">Indian &amp; Thai · Limerick</p></div>
  <div class="footer-details"><section><h2>Visit us</h2><address>28 O'Connell Street<br>Limerick City, Ireland</address><a href="tel:+35361217661">+353 61 217 661</a><a href="mailto:info@bamburestaurant.ie">info@bamburestaurant.ie</a><a class="footer-direction" href="https://maps.app.goo.gl/QWcCknw64kSChXoe8" target="_blank" rel="noopener">Get Directions ↗</a></section><section><h2>Opening hours</h2><p>Monday–Saturday<br>17:00–22:45</p><p>Sunday<br>14:00–22:00</p></section></div>
  <div class="footer-about"><p>Indian &amp; Thai cooking on the banks of the Shannon — two great traditions, one quiet dining room in Limerick.</p><a href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">Visit &amp; FAQs →</a></div>
 </div>
 <div class="footer-strip"><div class="footer-social"><a href="https://www.instagram.com/bambu_restaurant_limerick/" target="_blank" rel="noopener">Instagram</a><a href="https://www.facebook.com/bambulimerick" target="_blank" rel="noopener">Facebook</a></div><p>© 2026 Bambu Indian &amp; Thai Restaurant. All rights reserved.</p><p>Designed &amp; Developed by <a href="https://www.cybromarketing.com" target="_blank" rel="noopener">Cybro Marketing</a></p></div>
</footer>
    <!-- ════════════════════════════ END SITE FOOTER ══════════════════════════════ -->


    <!-- ══════════════════════════ BOOKING MODAL ═════════════════════════════════ -->
    <div id="booking-modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="booking-modal-title">
        <div class="modal-overlay"></div>
        <div class="modal-content dark-theme">
            <span class="close-modal" role="button" aria-label="Close booking form">&times;</span>
            <div class="modal-header">
                <div class="modal-logo">
                    <img src="<?php echo esc_url( $t ); ?>/assets/logo.jpg" alt="Bambu Restaurant Logo">
                </div>
                <div class="modal-divider">
                    <span class="ornament"></span>
                </div>
                <h2 id="booking-modal-title">Book Now!</h2>
            </div>

            <form id="premium-booking-form" class="premium-form" novalidate>
                <div class="premium-form-grid">

                    <!-- Date -->
                    <div class="form-group-premium">
                        <label for="booking-date"><span class="label-icon"></span> Date</label>
                        <input type="date" required class="dark-input" id="booking-date" name="booking_date">
                    </div>

                    <!-- Guests -->
                    <div class="form-group-premium">
                        <label for="booking-guests"><span class="label-icon"></span> Guests</label>
                        <select required class="dark-input" id="booking-guests" name="guests">
                            <option value="1">1 Person</option>
                            <option value="2" selected>2 People</option>
                            <option value="3">3 People</option>
                            <option value="4">4 People</option>
                            <option value="5">5 People</option>
                            <option value="6">6 People</option>
                            <option value="7">7 People</option>
                            <option value="8">8 People</option>
                            <option value="9">9 People</option>
                            <option value="10">10 People</option>
                            <option value="11">11 People</option>
                            <option value="12">12 People</option>
                            <option value="13">13 People</option>
                            <option value="14">14 People</option>
                            <option value="15">15 People</option>
                            <option value="16">16 People</option>
                            <option value="17">17 People</option>
                            <option value="18">18 People</option>
                            <option value="19">19 People</option>
                            <option value="20">20 People</option>
                            <option value="20+">20+ People (Large Group)</option>
                        </select>
                    </div>

                    <!-- Time -->
                    <div class="form-group-premium">
                        <label for="booking-time"><span class="label-icon"></span> Time</label>
                        <select required class="dark-input" id="booking-time" name="booking_time">
                            <option value="" disabled selected>Select a Date First</option>
                        </select>
                    </div>

                    <!-- Name -->
                    <div class="form-group-premium">
                        <label for="booking-name"><span class="label-icon"></span> Name</label>
                        <input type="text" id="booking-name" name="guest_name"
                               placeholder="Your Name" required class="dark-input">
                    </div>

                    <!-- Phone -->
                    <div class="form-group-premium">
                        <label for="booking-phone"><span class="label-icon"></span> Phone</label>
                        <input type="tel" id="booking-phone" name="guest_phone"
                               placeholder="Your Phone" required class="dark-input">
                    </div>

                    <!-- Email (full width) -->
                    <div class="form-group-premium full-width">
                        <label for="booking-email"><span class="label-icon"></span> Email</label>
                        <input type="email" id="booking-email" name="guest_email"
                               placeholder="Your Email" required class="dark-input">
                    </div>

                    <!-- Message (full width) -->
                    <div class="form-group-premium full-width">
                        <label for="booking-message"><span class="label-icon"></span> Message</label>
                        <textarea id="booking-message" name="guest_message" rows="2"
                                  placeholder="Special requests or dietary needs..."
                                  class="dark-input"></textarea>
                    </div>

                </div>
                <button type="submit" class="btn-orange" id="booking-submit-btn">Confirm Reservation</button>
            </form>
        </div>
    </div>
    <!-- ═════════════════════════ END BOOKING MODAL ═══════════════════════════════ -->


    <!-- ══════════════════════════ MENU VIEWER MODAL ══════════════════════════════ -->
    <div id="menu-modal" class="menu-modal" role="dialog" aria-modal="true" aria-label="Bambu Restaurant Menu">
        <div class="menu-modal-overlay"></div>
        <div class="menu-modal-container">

            <!-- Menu header -->
            <div class="menu-modal-header">
                <div class="menu-modal-title">
                    <span class="menu-label">BAMBU</span>
                    <span class="menu-subtitle">OUR MENU</span>
                </div>
                <div class="menu-page-counter">
                    <span id="menu-current-page">1</span> / 10
                </div>
                <button class="menu-close-btn" id="menu-close-btn" aria-label="Close menu">&times;</button>
            </div>

            <!-- Menu pages -->
            <div class="menu-pages-wrapper" id="menu-pages-wrapper">
                <?php for ( $p = 1; $p <= 10; $p++ ) : ?>
                <div class="menu-page<?php echo ( $p === 1 ) ? ' active' : ''; ?>"
                     data-page="<?php echo $p; ?>">
                    <img data-src="<?php echo esc_url( $t . '/assets/menu/menu-' . $p . '.webp' ); ?>"
                         alt="Menu Page <?php echo $p; ?>"
                         loading="lazy">
                </div>
                <?php endfor; ?>
            </div>

            <!-- Menu footer navigation -->
            <div class="menu-modal-footer">
                <button class="menu-nav-btn" id="menu-prev" disabled aria-label="Previous page">
                    &#8592; PREV
                </button>
                <div class="menu-thumbnails" role="tablist" aria-label="Menu page navigation">
                    <?php for ( $p = 1; $p <= 10; $p++ ) : ?>
                    <span class="menu-thumb-dot<?php echo ( $p === 1 ) ? ' active' : ''; ?>"
                          data-page="<?php echo $p; ?>"
                          role="tab"
                          aria-label="Page <?php echo $p; ?>"
                          tabindex="0"></span>
                    <?php endfor; ?>
                </div>
                <button class="menu-nav-btn" id="menu-next" aria-label="Next page">
                    NEXT &#8594;
                </button>
            </div>

        </div>
    </div>
    <!-- ════════════════════════ END MENU VIEWER MODAL ════════════════════════════ -->

<?php wp_footer(); ?>
</body>
</html>
