<?php
/**
 * Template Name: Giới thiệu
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();
?>
<main class="about-page section-padding">
    <div class="container about-layout">
        <?php while (have_posts()) : the_post(); ?>
            <?php
            $about_excerpt = has_excerpt() ? get_the_excerpt() : '';
            $about_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            ?>
            <section class="about-hero">
                <div class="about-hero-copy">
                    <h1><?php the_title(); ?></h1>

                    <?php if ($about_excerpt) : ?>
                        <p><?php echo esc_html($about_excerpt); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($about_image) : ?>
                    <figure class="about-hero-image">
                        <img src="<?php echo esc_url($about_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    </figure>
                <?php endif; ?>
            </section>

            <article <?php post_class('about-content'); ?>>
                <?php the_content(); ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();
