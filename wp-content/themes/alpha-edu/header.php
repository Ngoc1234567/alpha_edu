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

        <?php get_template_part('template-parts/header/menu'); ?>

        <?php get_template_part('template-parts/header/cta'); ?>

        <button class="mobile-menu-toggle" type="button" aria-label="<?php esc_attr_e('Mở menu', 'alpha-edu'); ?>" aria-controls="primary-navigation" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>
