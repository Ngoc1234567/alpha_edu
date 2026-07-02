<?php
/**
 * Template Name: Thông báo
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();

if (! function_exists('alpha_edu_get_notice_images')) {
    function alpha_edu_get_notice_images($post_id) {
        $image_ids = function_exists('alpha_edu_get_notice_image_ids') ? alpha_edu_get_notice_image_ids($post_id) : [];
        $images = [];

        foreach ($image_ids as $image_id) {
            $image = wp_get_attachment_image_src($image_id, 'medium_large');

            if (! $image) {
                continue;
            }

            $images[] = [
                'url' => $image[0],
                'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true),
            ];
        }

        return $images;
    }
}

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
                    $notice_content = get_the_content();
                    $notice_images = alpha_edu_get_notice_images(get_the_ID());
                    $notice_body = apply_filters('the_content', $notice_content);

                    if ('' === trim(wp_strip_all_tags($notice_body)) && has_excerpt()) {
                        $notice_body = wpautop(get_the_excerpt());
                    }
                    ?>
                    <article <?php post_class('notice-item'); ?>>
                        <div class="notice-copy">
                            <h2><span class="notice-mark" aria-hidden="true"></span><?php the_title(); ?></h2>
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">[<?php echo esc_html(get_the_date('d/m/Y')); ?>]</time>
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
