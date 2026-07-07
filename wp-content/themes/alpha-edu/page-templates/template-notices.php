<?php
/**
 * Template Name: Thông báo
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();

$notice_query = new WP_Query([
    'post_type'      => 'alpha_notice',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'orderby'        => [
        'menu_order' => 'ASC',
        'date'       => 'DESC',
    ],
]);
?>
<main class="notice-page section-padding">
    <div class="container notice-layout">
        <h1 class="notice-page-title">[THÔNG TIN ĐÁNG CHÚ Ý]</h1>

        <div class="notice-list">
            <?php if ($notice_query->have_posts()) : ?>
                <?php
                while ($notice_query->have_posts()) :
                    $notice_query->the_post();
                    $notice_images = alpha_edu_get_notice_images(get_the_ID());
                    $notice_excerpt = has_excerpt()
                        ? get_the_excerpt()
                        : wp_trim_words(wp_strip_all_tags(get_the_content()), 38, '...');

                    $notice_body = $notice_excerpt ? wpautop($notice_excerpt) : '';
                    ?>
                    <article <?php post_class('notice-item'); ?>>
                        <div class="notice-copy">
                            <h2>
                                <span class="notice-mark" aria-hidden="true"></span>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <div class="notice-content">
                                <?php echo wp_kses_post($notice_body); ?>
                            </div>
                        </div>

                        <?php if ($notice_images) : ?>
                            <div class="notice-media notice-media-count-<?php echo esc_attr(min(count($notice_images), 4)); ?>">
                                <?php foreach ($notice_images as $notice_image) : ?>
                                    <figure class="notice-thumb">
                                        <img src="<?php echo esc_url($notice_image['url']); ?>" alt="<?php echo esc_attr($notice_image['alt'] ?: get_the_title()); ?>">
                                    </figure>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="notice-empty">Chưa có thông báo nào.</p>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php
get_footer();
