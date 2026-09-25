<?php
/**
 * index.php — WordPress Fallback Template
 *
 * WordPress requires this file. For this theme the homepage is handled by
 * front-page.php. This file is a fallback for any other page/post.
 *
 * To add blog/page content later, edit this file.
 */
get_header();
?>

    <main style="padding-top: 120px; min-height: 60vh; max-width: 900px; margin: 0 auto; padding: 120px 2rem 4rem;">

        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 1.5rem; color: #f9f6ef;">
                        <?php the_title(); ?>
                    </h1>
                    <div style="color: #9e958d; font-weight: 300; line-height: 1.8;">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>

        <?php else : ?>

            <div style="text-align: center; padding: 4rem 0;">
                <h1 style="font-family: 'Playfair Display', serif; color: #f9f6ef;">Nothing Found</h1>
                <p style="color: #9e958d; margin-top: 1rem;">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                       style="color: #ceaa7b;">Return to Homepage &rarr;</a>
                </p>
            </div>

        <?php endif; ?>

    </main>

<?php get_footer(); ?>
