<?php
/**
 * Main template.
 *
 * @package Alpha_Edu
 */

get_header();
?>
<main class="content-page section-padding">
    <div class="container content-layout">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article <?php post_class('entry-content'); ?>>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <p><?php esc_html_e('Chưa có nội dung.', 'alpha-edu'); ?></p>
            <?php
        endif;
        ?>
    </div>
</main>
<?php
get_footer();

