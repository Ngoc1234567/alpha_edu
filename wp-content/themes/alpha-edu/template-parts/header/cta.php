<?php
/**
 * Header call-to-action menu item.
 *
 * @package Alpha_Edu
 */

$locations = get_nav_menu_locations();

if (empty($locations['header_cta'])) {
    return;
}

$items = wp_get_nav_menu_items($locations['header_cta']);

if (empty($items)) {
    return;
}

$item   = reset($items);
$target = ! empty($item->target) ? $item->target : '';
$rel    = '_blank' === $target ? 'noopener noreferrer' : '';
$title  = $item->title;

if (function_exists('alpha_edu_normalize_menu_label') && 'dang ky hoc' === alpha_edu_normalize_menu_label($title)) {
    $title = __('Đăng ký', 'alpha-edu');
}
?>
<a class="header-cta" href="<?php echo esc_url($item->url); ?>"<?php echo $target ? ' target="' . esc_attr($target) . '"' : ''; ?><?php echo $rel ? ' rel="' . esc_attr($rel) . '"' : ''; ?>>
    <?php echo esc_html($title); ?>
</a>
