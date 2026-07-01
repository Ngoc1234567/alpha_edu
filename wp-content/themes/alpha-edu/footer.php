<?php
/**
 * Site footer.
 *
 * @package Alpha_Edu
 */
?>
<footer class="site-footer">
    <div class="container footer-inner">
        <p>&copy; <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?></p>
        <?php
        if (has_nav_menu('footer')) {
            wp_nav_menu([
                'theme_location' => 'footer',
                'container'      => 'nav',
                'container_class'=> 'footer-nav',
                'menu_class'     => 'footer-menu',
                'fallback_cb'    => false,
            ]);
        }
        ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

