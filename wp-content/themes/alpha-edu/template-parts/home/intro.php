<?php
/**
 * Home intro section.
 *
 * @package Alpha_Edu
 */
?>
<section class="home-intro section-padding">
    <div class="container intro-grid">
        <div class="intro-content">
            <h2><?php esc_html_e('GIỚI THIỆU', 'alpha-edu'); ?></h2>
            <p>
                <?php esc_html_e('Trung tâm Ngoại ngữ - Tin học ALPHA', 'alpha-edu'); ?><br>
                <?php echo wp_kses_post(__('(thành lập 08/08/2019 theo QĐ 1814/QĐ-SGD&amp;ĐT - Sở GD&amp;ĐT TT Huế) chuyên đào tạo tiếng Anh, Trung và ôn luyện, thi chứng chỉ tin học CNTT theo quy định.', 'alpha-edu')); ?><br>
                <?php esc_html_e('Cam kết Chất lượng - Uy tín - Hiệu Quả', 'alpha-edu'); ?>
            </p>
        </div>
        <div class="intro-image">
            <img src="<?php echo esc_url(alpha_edu_asset_url('images/intro-photo.jpg')); ?>" alt="<?php esc_attr_e('Học viên tại Trung tâm Alpha', 'alpha-edu'); ?>">
        </div>
    </div>
</section>

