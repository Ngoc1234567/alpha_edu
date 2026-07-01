<?php
/**
 * Primary header menu.
 *
 * @package Alpha_Edu
 */
?>
<nav class="main-nav" id="primary-navigation" aria-label="<?php esc_attr_e('Primary navigation', 'alpha-edu'); ?>">
    <?php
    wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'main-menu',
        'fallback_cb'    => false,
    ]);
    ?>
</nav>
