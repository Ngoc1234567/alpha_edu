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
        'primary' => __('Menu chính', 'alpha-edu'),
        'footer'  => __('Menu footer', 'alpha-edu'),
    ]);
}
add_action('after_setup_theme', 'alpha_edu_setup');

function alpha_edu_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11');
    wp_enqueue_style('alpha-edu-main', get_template_directory_uri() . '/assets/css/main.css', ['swiper'], $theme_version);

    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11', true);
    wp_enqueue_script('alpha-edu-main', get_template_directory_uri() . '/assets/js/main.js', ['swiper'], $theme_version, true);
}
add_action('wp_enqueue_scripts', 'alpha_edu_enqueue_assets');

function alpha_edu_register_post_types() {
    register_post_type('course', [
        'labels' => [
            'name'          => __('Khóa học', 'alpha-edu'),
            'singular_name' => __('Khóa học', 'alpha-edu'),
            'add_new_item'  => __('Thêm khóa học', 'alpha-edu'),
            'edit_item'     => __('Sửa khóa học', 'alpha-edu'),
        ],
        'public'       => true,
        'menu_icon'    => 'dashicons-welcome-learn-more',
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'khoa-hoc'],
        'show_in_rest' => true,
    ]);

    register_post_type('testimonial', [
        'labels' => [
            'name'          => __('Đánh giá học viên', 'alpha-edu'),
            'singular_name' => __('Đánh giá', 'alpha-edu'),
            'add_new_item'  => __('Thêm đánh giá', 'alpha-edu'),
            'edit_item'     => __('Sửa đánh giá', 'alpha-edu'),
        ],
        'public'       => true,
        'menu_icon'    => 'dashicons-testimonial',
        'supports'     => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'has_archive'  => false,
        'show_in_rest' => true,
    ]);
}
add_action('init', 'alpha_edu_register_post_types');

function alpha_edu_default_menu_items() {
    return [
        ['label' => 'Trang chủ', 'url' => home_url('/')],
        ['label' => 'Thông báo', 'url' => home_url('/thong-bao')],
        ['label' => 'Tra cứu điểm', 'url' => home_url('/tra-cuu-diem')],
        ['label' => 'Đăng ký thi', 'url' => home_url('/dang-ky-thi')],
        ['label' => 'Văn bản/Biểu mẫu', 'url' => home_url('/van-ban-bieu-mau')],
        ['label' => 'Liên hệ', 'url' => home_url('/lien-he')],
    ];
}

function alpha_edu_asset_url($path) {
    return get_template_directory_uri() . '/assets/' . ltrim($path, '/');
}

