# Bambu page structure

- Home: short local introduction, cuisine highlights, gallery link and visit actions.
- Our Story: restaurant background and cuisine information.
- Menu: the existing ten-page menu viewer, with direct links to the unchanged assets/menu.pdf and cuisine descriptions below.
- Visit & FAQs: address, opening hours, contact and practical questions.
- Gallery: existing sliding gallery.

The original homepage is preserved verbatim in reference/homepage-before-content-reorganisation.html.txt. No image or PDF was deleted or replaced. Existing awards, halal certification and review totals could not be independently verified; the new copy asks visitors to confirm dietary requirements and the homepage schema omits unverified ratings.

Static hosting: publish the HTML pages and sitemap.xml together. The sitemap assumes bambulimerick.ie as used by the existing site.

WordPress: create pages with slugs our-story, menu, visit and gallery (or assign the matching Bambu templates). Templates alone do not create database pages. Use WordPress's sitemap and canonical URLs rather than the static sitemap. A running WordPress installation is needed for end-to-end theme validation.

The logo intro runs once per browser session, skips reduced motion and unavailable session storage, and dismisses automatically within 1.2 seconds. The content remains in the HTML underneath.
