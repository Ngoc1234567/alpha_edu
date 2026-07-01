<?php
/**
 * Home courses section.
 *
 * @package Alpha_Edu
 */

$fallback_courses = [
    [
        'title' => 'CNTT CƠ BẢN',
        'desc'  => 'Trang bị kỹ năng tin học văn phòng và đạt chứng chỉ theo chuẩn quy định.',
        'color' => 'blue',
        'url'   => '#',
    ],
    [
        'title' => 'TIN HỌC MOS',
        'desc'  => 'Chinh phục chứng chỉ MOS quốc tế, nâng cao kỹ năng Microsoft Office.',
        'color' => 'red',
        'url'   => '#',
    ],
    [
        'title' => 'TIẾNG ANH VSTEP',
        'desc'  => 'Luyện thi VSTEP bài bản, bám sát cấu trúc đề và tiêu chí chấm điểm.',
        'color' => 'blue',
        'url'   => '#',
    ],
    [
        'title' => 'TIẾNG ANH APTIS',
        'desc'  => 'Ôn luyện hiệu quả, tự tin chinh phục kỳ thi Aptis.',
        'color' => 'red',
        'url'   => '#',
    ],
    [
        'title' => 'TIẾNG ANH VEPT',
        'desc'  => 'Lộ trình học rõ ràng, giúp đạt chuẩn đầu ra tiếng Anh.',
        'color' => 'blue',
        'url'   => '#',
    ],
    [
        'title' => 'TIẾNG TRUNG HSK',
        'desc'  => 'Lộ trình học rõ ràng, giúp đạt chuẩn đầu ra tiếng Trung.',
        'color' => 'red',
        'url'   => '#',
    ],
];

$course_query = new WP_Query([
    'post_type'      => 'course',
    'posts_per_page' => 6,
    'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
]);
?>
<section class="home-courses section-padding">
    <div class="container">
        <h2 class="section-title section-title-center section-title-black"><?php esc_html_e('CÁC KHÓA HỌC TẠI ALPHA', 'alpha-edu'); ?></h2>

        <div class="course-grid">
            <?php
            if ($course_query->have_posts()) :
                $index = 0;
                while ($course_query->have_posts()) :
                    $course_query->the_post();
                    $color = 0 === $index % 2 ? 'blue' : 'red';
                    $desc  = has_excerpt() ? get_the_excerpt() : wp_trim_words(get_the_content(), 22);
                    ?>
                    <article class="course-card course-card-<?php echo esc_attr($color); ?>">
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo esc_html($desc); ?></p>
                        <a href="<?php the_permalink(); ?>"><?php esc_html_e('Tìm hiểu về khóa học', 'alpha-edu'); ?></a>
                    </article>
                    <?php
                    $index++;
                endwhile;
                wp_reset_postdata();
            else :
                foreach ($fallback_courses as $course) :
                    ?>
                    <article class="course-card course-card-<?php echo esc_attr($course['color']); ?>">
                        <h3><?php echo esc_html($course['title']); ?></h3>
                        <p><?php echo esc_html($course['desc']); ?></p>
                        <a href="<?php echo esc_url($course['url']); ?>"><?php esc_html_e('Tìm hiểu về khóa học', 'alpha-edu'); ?></a>
                    </article>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

