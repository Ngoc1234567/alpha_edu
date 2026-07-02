<?php
/**
 * Single course template.
 *
 * @package Alpha_Edu
 */

get_header();
?>
<main class="course-detail-page">
    <?php
    while (have_posts()) :
        the_post();

        $post_id     = get_the_ID();
        $intro       = alpha_edu_get_course_field($post_id, 'course_detail_intro');
        $fees        = alpha_edu_parse_course_fee_rows(alpha_edu_get_course_field($post_id, 'course_fee_rows'));
        $guide_title = alpha_edu_get_course_field($post_id, 'course_registration_title', __('HƯỚNG DẪN ĐĂNG KÝ:', 'alpha-edu'));
        $guide_items = alpha_edu_get_course_registration_items(alpha_edu_get_course_field($post_id, 'course_registration_items'));
        $button_text = alpha_edu_get_course_field($post_id, 'course_register_button_text', __('ĐĂNG KÝ TẠI ĐÂY', 'alpha-edu'));
        ?>
        <article <?php post_class('course-detail section-padding'); ?>>
            <div class="container course-detail-inner">
                <header class="course-detail-header">
                    <h1><?php esc_html_e('GIỚI THIỆU VỀ KHÓA HỌC', 'alpha-edu'); ?></h1>
                </header>

                <div class="course-detail-intro">
                    <?php if ($intro) : ?>
                        <?php echo wpautop(wp_kses_post($intro)); ?>
                    <?php else : ?>
                        <?php the_content(); ?>
                    <?php endif; ?>
                </div>

                <?php if ($fees) : ?>
                <div class="course-fee-table-wrap">
                    <table class="course-fee-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e('KHÓA HỌC', 'alpha-edu'); ?></th>
                                <th><?php esc_html_e('HỌC PHÍ', 'alpha-edu'); ?></th>
                                <th><?php esc_html_e('LỆ PHÍ THI', 'alpha-edu'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fees as $row) : ?>
                            <tr>
                                <td>
                                    <strong><?php echo esc_html($row['name']); ?></strong>
                                    <?php if (! empty($row['note'])) : ?>
                                    <small><?php echo esc_html($row['note']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo esc_html($row['tuition']); ?></td>
                                <td><?php echo esc_html($row['exam_fee']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>

                <?php if ($guide_title || $guide_items || $button_text) : ?>
                <section class="course-registration-guide" aria-labelledby="course-registration-title">
                    <?php if ($guide_title) : ?>
                    <h2 id="course-registration-title"><?php echo esc_html($guide_title); ?></h2>
                    <?php endif; ?>

                    <?php if ($guide_items) : ?>
                    <div class="course-registration-list">
                        <?php foreach ($guide_items as $item) : ?>
                            <?php $is_sub_item = '-' === substr($item, 0, 1); ?>
                            <p class="<?php echo $is_sub_item ? 'is-sub-item' : 'is-main-item'; ?>">
                                <?php if (! $is_sub_item) : ?>
                                <span class="course-registration-icon" aria-hidden="true"></span>
                                <?php endif; ?>
                                <span><?php echo esc_html($item); ?></span>
                            </p>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($button_text) : ?>
                    <a class="course-register-button" href="#course-registration-form" data-registration-toggle aria-expanded="false" aria-controls="course-registration-form">
                        <?php echo esc_html($button_text); ?>
                    </a>
                    <?php endif; ?>
                </section>
                <?php endif; ?>

                <?php
                if (function_exists('alpha_edu_render_registration_form')) {
                    alpha_edu_render_registration_form($post_id);
                }
                ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</main>
<?php
get_footer();
