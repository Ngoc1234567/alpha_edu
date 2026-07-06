<?php
/**
 * Template Name: Liên hệ
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();
?>
<main class="contact-page section-padding">
    <div class="container contact-layout">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('contact-content'); ?>>
                <div class="contact-info">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();
