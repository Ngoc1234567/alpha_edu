<?php
/**
 * Site header.
 *
 * @package Alpha_Edu
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="container header-inner">
        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <img src="<?php echo esc_url(alpha_edu_asset_url('images/logo.png')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
        </a>

        <nav class="main-nav" id="primary-navigation" aria-label="<?php esc_attr_e('Primary navigation', 'alpha-edu'); ?>">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'main-menu',
                    'fallback_cb'    => false,
                ]);
            } else {
                echo '<ul class="main-menu">';
                foreach (alpha_edu_default_menu_items() as $index => $item) {
                    $class = 0 === $index ? ' class="current-menu-item"' : '';
                    printf(
                        '<li%s><a href="%s">%s</a></li>',
                        $class,
                        esc_url($item['url']),
                        esc_html($item['label'])
                    );
                }
                echo '</ul>';
            }
            ?>
        </nav>

        <a class="header-cta" href="<?php echo esc_url(home_url('/dang-ky-hoc')); ?>"><?php esc_html_e('Đăng ký học', 'alpha-edu'); ?></a>

        <button class="mobile-menu-toggle" type="button" aria-label="<?php esc_attr_e('Mở menu', 'alpha-edu'); ?>" aria-controls="primary-navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

