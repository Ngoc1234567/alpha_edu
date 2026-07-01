<?php
/**
 * Template Name: Tra cứu điểm
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
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();
