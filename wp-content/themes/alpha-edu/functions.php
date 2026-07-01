<?php
/**
 * Alpha Edu theme functions.
 *
 * @package Alpha_Edu
 */

if (! defined('ABSPATH')) {
    exit;
}

function alpha_edu_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary'    => __('Menu chính', 'alpha-edu'),
        'header_cta' => __('Nút header', 'alpha-edu'),
        'footer'     => __('Menu footer', 'alpha-edu'),
    ]);
}
add_action('after_setup_theme', 'alpha_edu_setup');

function alpha_edu_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style('alpha-edu-fonts', 'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&display=swap', [], null);
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11');
    wp_enqueue_style('alpha-edu-main', get_template_directory_uri() . '/assets/css/main.css', ['alpha-edu-fonts', 'swiper'], $theme_version);

    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11', true);
    wp_enqueue_script('alpha-edu-main', get_template_directory_uri() . '/assets/js/main.js', ['swiper'], $theme_version, true);
}
add_action('wp_enqueue_scripts', 'alpha_edu_enqueue_assets');

function alpha_edu_register_post_types() {
    register_post_type('course', [
        'labels' => [
            'name' => __('Khóa học', 'alpha-edu'),
            'singular_name' => __('Khóa học', 'alpha-edu'),
            'add_new_item' => __('Thêm khóa học', 'alpha-edu'),
            'edit_item' => __('Sửa khóa học', 'alpha-edu'),
            'new_item' => __('Khóa học mới', 'alpha-edu'),
            'view_item' => __('Xem khóa học', 'alpha-edu'),
            'search_items' => __('Tìm khóa học', 'alpha-edu'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'khoa-hoc'],
        'show_in_rest' => true,
    ]);

    register_post_type('testimonial', [
        'labels' => [
            'name' => __('Đánh giá học viên', 'alpha-edu'),
            'singular_name' => __('Đánh giá học viên', 'alpha-edu'),
            'add_new_item' => __('Thêm đánh giá', 'alpha-edu'),
            'edit_item' => __('Sửa đánh giá', 'alpha-edu'),
            'new_item' => __('Đánh giá mới', 'alpha-edu'),
            'view_item' => __('Xem đánh giá', 'alpha-edu'),
            'search_items' => __('Tìm đánh giá', 'alpha-edu'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'danh-gia-hoc-vien'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'alpha_edu_register_post_types');

function alpha_edu_asset_url($path) {
    return get_template_directory_uri() . '/assets/' . ltrim($path, '/');
}

function alpha_edu_get_home_field($selector, $default = '') {
    if (! function_exists('get_field')) {
        return $default;
    }

    $post_id = get_queried_object_id();

    if (! $post_id) {
        $post_id = get_option('page_on_front');
    }

    $value = get_field($selector, $post_id);

    if ('' === $value || null === $value || false === $value) {
        return $default;
    }

    return $value;
}

function alpha_edu_get_option_field($selector, $default = '') {
    if (! function_exists('get_field')) {
        return $default;
    }

    $value = get_field($selector, 'option');

    if ('' === $value || null === $value || false === $value) {
        return $default;
    }

    return $value;
}

function alpha_edu_register_footer_settings_page() {
    $hook = add_menu_page(
        __('Footer', 'alpha-edu'),
        __('Footer', 'alpha-edu'),
        'manage_options',
        'alpha-edu-footer',
        'alpha_edu_render_footer_settings_page',
        'dashicons-editor-table',
        61
    );

    add_action('load-' . $hook, function () {
        if (function_exists('acf_form_head')) {
            acf_form_head();
        }
    });
}
add_action('admin_menu', 'alpha_edu_register_footer_settings_page');

function alpha_edu_render_footer_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Footer', 'alpha-edu'); ?></h1>
        <?php
        if (function_exists('acf_form')) {
            acf_form([
                'post_id'         => 'option',
                'field_groups'    => ['group_alpha_footer'],
                'form'            => true,
                'submit_value'    => __('Cập nhật Footer', 'alpha-edu'),
                'updated_message' => __('Đã cập nhật Footer.', 'alpha-edu'),
            ]);
        } else {
            echo '<p>' . esc_html__('Vui lòng kích hoạt plugin Advanced Custom Fields.', 'alpha-edu') . '</p>';
        }
        ?>
    </div>
    <?php
}
