<?php
/**
 * Template Name: Trang chủ
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

$hero_title    = alpha_edu_get_home_field('home_hero_title');
$hero_subtitle = alpha_edu_get_home_field('home_hero_subtitle');
$hero_banner   = alpha_edu_get_home_field('home_hero_banner');

$intro_eyebrow = alpha_edu_get_home_field('home_intro_eyebrow');
$intro_title   = alpha_edu_get_home_field('home_intro_title');
$intro_content = alpha_edu_get_home_field('home_intro_content');
$intro_image   = alpha_edu_get_home_field('home_intro_image');
$nowrap_title_phrase = function ($title) {
    $title_html = esc_html($title);

    foreach (['NGOẠI NGỮ - TIN HỌC ALPHA', 'NGOẠI NGỮ - TIN HỌC'] as $phrase) {
        $escaped_phrase = esc_html($phrase);

        if (false !== strpos($title_html, $escaped_phrase)) {
            $title_html = str_replace($escaped_phrase, '<span class="title-nowrap">' . $escaped_phrase . '</span>', $title_html);
            break;
        }
    }

    return $title_html;
};
$hero_title_html  = $nowrap_title_phrase($hero_title);
$intro_title_html = $nowrap_title_phrase($intro_title);

$courses_title = alpha_edu_get_home_field('home_courses_title');
$course_query  = new WP_Query([
    'post_type'      => 'course',
    'posts_per_page' => -1,
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
]);

$stats_title      = alpha_edu_get_home_field('home_stats_title');
$stats_background = alpha_edu_get_home_field('home_stats_background');
$stats            = [];

for ($i = 1; $i <= 3; $i++) {
    $stat = [
        'number' => alpha_edu_get_home_field('home_stat_' . $i . '_number'),
        'label'  => alpha_edu_get_home_field('home_stat_' . $i . '_label'),
    ];

    if ($stat['number'] || $stat['label']) {
        $stats[] = $stat;
    }
}

$testimonials_title = alpha_edu_get_home_field('home_testimonials_title');
$testimonial_query  = new WP_Query([
    'post_type'      => 'testimonial',
    'posts_per_page' => 8,
    'meta_query'     => [
        [
            'key'     => '_thumbnail_id',
            'compare' => 'EXISTS',
        ],
    ],
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
]);

get_header();
?>

<main class="home-page">
    <?php if ($hero_title || $hero_subtitle || $hero_banner) : ?>
    <section class="home-hero">
        <?php if ($hero_title || $hero_subtitle) : ?>
        <div class="container hero-heading">
            <?php if ($hero_title) : ?>
            <h1><?php echo wp_kses($hero_title_html, ['span' => ['class' => true]]); ?></h1>
            <?php endif; ?>

            <?php if ($hero_subtitle) : ?>
            <p><?php echo esc_html($hero_subtitle); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($hero_banner) : ?>
        <div class="hero-banner">
            <img src="<?php echo esc_url($hero_banner); ?>" alt="<?php echo esc_attr($hero_title); ?>">
        </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if ($intro_title || $intro_content || $intro_image) : ?>
    <section class="home-intro section-padding">
        <div class="container">
            <?php if ($intro_eyebrow || $intro_title) : ?>
            <div class="intro-heading">
                <?php if ($intro_eyebrow) : ?>
                <p class="intro-eyebrow"><?php echo esc_html($intro_eyebrow); ?></p>
                <?php endif; ?>

                <?php if ($intro_title) : ?>
                <h2><?php echo wp_kses($intro_title_html, ['span' => ['class' => true]]); ?></h2>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($intro_content || $intro_image) : ?>
            <div class="intro-grid">
                <?php if ($intro_content) : ?>
                <div class="intro-content">
                    <div class="intro-rich-text"><?php echo wp_kses_post(wpautop($intro_content)); ?></div>
                </div>
                <?php endif; ?>

                <?php if ($intro_image) : ?>
                <div class="intro-image">
                    <img src="<?php echo esc_url($intro_image); ?>" alt="<?php echo esc_attr($intro_title); ?>">
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($courses_title || $course_query->have_posts()) : ?>
    <section class="home-courses section-padding">
        <div class="container">
            <?php if ($courses_title) : ?>
            <h2 class="section-title section-title-center section-title-black"><?php echo esc_html($courses_title); ?></h2>
            <?php endif; ?>

            <?php if ($course_query->have_posts()) : ?>
            <div class="course-grid">
                <?php
                while ($course_query->have_posts()) :
                    $course_query->the_post();
                    $color = function_exists('get_field') && get_field('course_color') === 'red' ? 'red' : 'blue';
                    $desc  = function_exists('get_field') ? get_field('course_short_description') : '';
                    $link  = function_exists('get_field') ? get_field('course_link') : '';
                    $url   = is_array($link) && ! empty($link['url']) ? $link['url'] : get_permalink();
                    $label = is_array($link) && ! empty($link['title']) ? $link['title'] : __('Tìm hiểu về khóa học', 'alpha-edu');
                    ?>
                    <article class="course-card course-card-<?php echo esc_attr($color); ?>">
                        <h3><?php the_title(); ?></h3>

                        <?php if ($desc) : ?>
                        <p><?php echo esc_html($desc); ?></p>
                        <?php endif; ?>

                        <?php if ($url && $label) : ?>
                        <a href="<?php echo esc_url($url); ?>"<?php echo is_array($link) && ! empty($link['target']) ? ' target="' . esc_attr($link['target']) . '"' : ''; ?>><?php echo esc_html($label); ?></a>
                        <?php endif; ?>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($stats_title || $stats) : ?>
    <section class="home-stats"<?php echo $stats_background ? ' style="background-image: url(' . esc_url($stats_background) . ');"' : ''; ?>>
        <div class="stats-overlay">
            <div class="container">
                <?php if ($stats_title) : ?>
                <h2 class="stats-title"><?php echo esc_html($stats_title); ?></h2>
                <?php endif; ?>

                <?php if ($stats) : ?>
                <div class="stats-grid">
                    <?php foreach ($stats as $stat) : ?>
                    <div class="stat-card">
                        <?php if ($stat['number']) : ?>
                            <?php
                            $stat_number = trim((string) $stat['number']);
                            preg_match('/^([^0-9]*)([0-9][0-9,.]*)(.*)$/', $stat_number, $stat_matches);
                            $stat_prefix = $stat_matches[1] ?? '';
                            $stat_value  = isset($stat_matches[2]) ? (int) str_replace([',', '.'], '', $stat_matches[2]) : 0;
                            $stat_suffix = $stat_matches[3] ?? '';
                            ?>
                        <strong class="stat-count" data-count="<?php echo esc_attr($stat_value); ?>" data-prefix="<?php echo esc_attr($stat_prefix); ?>" data-suffix="<?php echo esc_attr($stat_suffix); ?>"><?php echo esc_html($stat_number); ?></strong>
                        <?php endif; ?>

                        <?php if ($stat['label']) : ?>
                        <span><?php echo esc_html($stat['label']); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ($testimonial_query->have_posts()) : ?>
    <section class="home-testimonials section-padding">
        <div class="container">
            <?php if ($testimonials_title) : ?>
            <h2 class="section-title section-title-center section-title-red"><?php echo esc_html($testimonials_title); ?></h2>
            <?php endif; ?>

            <?php if ($testimonial_query->have_posts()) : ?>
            <div class="testimonial-slider-wrap">
                <div class="swiper testimonial-swiper">
                    <div class="swiper-wrapper">
                        <?php
                        while ($testimonial_query->have_posts()) :
                            $testimonial_query->the_post();
                            ?>
                            <div class="swiper-slide">
                                <figure class="testimonial-card">
                                    <?php the_post_thumbnail('large', ['class' => 'testimonial-image', 'alt' => get_the_title()]); ?>
                                </figure>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>

                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php
get_footer();
