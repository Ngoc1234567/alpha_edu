<?php
/**
 * Single notice template.
 *
 * @package Alpha_Edu
 */

get_header();

$notice_page_ids = get_posts([
    'post_type'      => 'page',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'fields'         => 'ids',
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'page-templates/template-notices.php',
]);
$notice_page_url = ! empty($notice_page_ids) ? get_permalink((int) $notice_page_ids[0]) : home_url('/');
?>
<main class="notice-detail-page section-padding">
    <?php
    while (have_posts()) :
        the_post();

        $notice_images = function_exists('alpha_edu_get_notice_images') ? alpha_edu_get_notice_images(get_the_ID(), 'large') : [];
        ?>
        <article <?php post_class('notice-detail'); ?>>
            <div class="container notice-detail-inner">
                <a class="notice-back-link" href="<?php echo esc_url($notice_page_url); ?>"><?php esc_html_e('Quay lại danh sách thông báo', 'alpha-edu'); ?></a>

                <header class="notice-detail-header">
                    <h1><?php the_title(); ?></h1>
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">[<?php echo esc_html(get_the_date('d/m/Y')); ?>]</time>
                </header>

                <div class="notice-detail-content">
                    <?php the_content(); ?>
                </div>

                <?php if ($notice_images) : ?>
                    <div class="notice-detail-media">
                        <?php foreach ($notice_images as $notice_image) : ?>
                            <figure class="notice-detail-image">
                                <img src="<?php echo esc_url($notice_image['url']); ?>" alt="<?php echo esc_attr($notice_image['alt'] ?: get_the_title()); ?>">
                            </figure>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>
<?php
get_footer();
