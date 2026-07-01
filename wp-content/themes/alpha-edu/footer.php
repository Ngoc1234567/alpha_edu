<?php
/**
 * Site footer.
 *
 * @package Alpha_Edu
 */

$training_title = alpha_edu_get_option_field('footer_training_title');
$training_items = [];

for ($i = 1; $i <= 8; $i++) {
    $item = alpha_edu_get_option_field('footer_training_item_' . $i);

    if ($item) {
        $training_items[] = $item;
    }
}

$contact_title = alpha_edu_get_option_field('footer_contact_title');
$contact_items = [
    [
        'icon'  => 'home',
        'value' => alpha_edu_get_option_field('footer_address_1'),
    ],
    [
        'icon'  => 'home',
        'value' => alpha_edu_get_option_field('footer_address_2'),
    ],
    [
        'icon'  => 'phone',
        'value' => alpha_edu_get_option_field('footer_hotline'),
    ],
    [
        'icon'  => 'mail',
        'value' => alpha_edu_get_option_field('footer_email'),
    ],
    [
        'icon'  => 'web',
        'value' => alpha_edu_get_option_field('footer_website'),
    ],
];

$contact_items = array_values(array_filter($contact_items, function ($item) {
    return ! empty($item['value']);
}));
?>
<footer class="site-footer">
    <div class="container footer-inner">
        <?php if ($training_title || $training_items) : ?>
        <section class="footer-column footer-training" aria-labelledby="footer-training-title">
            <?php if ($training_title) : ?>
            <h2 id="footer-training-title"><?php echo esc_html($training_title); ?></h2>
            <?php endif; ?>

            <?php if ($training_items) : ?>
            <ul class="footer-training-list">
                <?php foreach ($training_items as $item) : ?>
                <li><?php echo esc_html($item); ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <?php if ($contact_title || $contact_items) : ?>
        <section class="footer-column footer-contact" aria-labelledby="footer-contact-title">
            <?php if ($contact_title) : ?>
            <h2 id="footer-contact-title"><?php echo esc_html($contact_title); ?></h2>
            <?php endif; ?>

            <?php if ($contact_items) : ?>
            <ul class="footer-contact-list">
                <?php foreach ($contact_items as $item) : ?>
                <li>
                    <span class="footer-contact-icon footer-contact-icon-<?php echo esc_attr($item['icon']); ?>" aria-hidden="true"></span>
                    <span><?php echo esc_html($item['value']); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </section>
        <?php endif; ?>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
