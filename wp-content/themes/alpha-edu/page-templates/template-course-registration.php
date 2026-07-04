<?php
/**
 * Template Name: Đăng ký học
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();
?>
<main class="content-page section-padding">
    <div class="container content-layout">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('entry-content'); ?>>
                <?php the_content(); ?>

                <?php
                if (function_exists('alpha_edu_render_registration_form')) {
                    alpha_edu_render_registration_form(0, true, false);
                }
                ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();
