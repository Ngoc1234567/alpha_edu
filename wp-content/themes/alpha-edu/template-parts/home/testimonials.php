<?php
/**
 * Home testimonials section.
 *
 * @package Alpha_Edu
 */

$fallback_testimonials = [
    [
        'content' => 'Đăng ký ôn thi CNTT Cơ bản tại Alpha và đội ngũ làm hồ sơ hướng dẫn rất chi tiết, các kiến thức Word, Excel, PowerPoint đều được thực hành nên đi thi khá tự tin.',
        'name'    => 'Tên học viên',
    ],
    [
        'content' => 'Lúc đầu mình không biết gì về Excel nhưng sau khóa học đã làm được hầu hết các dạng bài thi. Trung tâm hỗ trợ rất nhiệt tình từ lúc đăng ký đến khi nhận chứng chỉ.',
        'name'    => 'Tên học viên',
    ],
    [
        'content' => 'Điều mình thích nhất là lịch phù hợp với người vừa đi làm. Nhân viên hỗ trợ nhanh, giải đáp thắc mắc rất nhiệt tình.',
        'name'    => 'Tên học viên',
    ],
    [
        'content' => 'Giáo viên hướng dẫn dễ hiểu, tài liệu ôn tập sát đề và có nhiều bài thực hành.',
        'name'    => 'Tên học viên',
    ],
];

$testimonial_query = new WP_Query([
    'post_type'      => 'testimonial',
    'posts_per_page' => 8,
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
]);
?>
<section class="home-testimonials section-padding">
    <div class="container">
        <h2 class="section-title section-title-center section-title-red"><?php esc_html_e('ĐÁNH GIÁ CỦA HỌC VIÊN', 'alpha-edu'); ?></h2>

        <div class="testimonial-slider-wrap">
            <div class="swiper testimonial-swiper">
                <div class="swiper-wrapper">
                    <?php
                    if ($testimonial_query->have_posts()) :
                        while ($testimonial_query->have_posts()) :
                            $testimonial_query->the_post();
                            ?>
                            <div class="swiper-slide">
                                <article class="testimonial-card">
                                    <p>“<?php echo esc_html(wp_strip_all_tags(get_the_content())); ?>”</p>
                                    <h3><?php the_title(); ?></h3>
                                    <div class="stars" aria-label="<?php esc_attr_e('5 sao', 'alpha-edu'); ?>">★★★★★</div>
                                </article>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        foreach ($fallback_testimonials as $item) :
                            ?>
                            <div class="swiper-slide">
                                <article class="testimonial-card">
                                    <p>“<?php echo esc_html($item['content']); ?>”</p>
                                    <h3><?php echo esc_html($item['name']); ?></h3>
                                    <div class="stars" aria-label="<?php esc_attr_e('5 sao', 'alpha-edu'); ?>">★★★★★</div>
                                </article>
                            </div>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>

