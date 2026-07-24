<?php
/**
 * Template Name: Giới thiệu
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();
?>
<main class="about-page">
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $post_id = get_the_ID();

        $hero_title      = alpha_edu_get_page_field('about_hero_title', $post_id, 'GIỚI THIỆU');
        $hero_image      = alpha_edu_get_page_field('about_hero_image', $post_id, get_the_post_thumbnail_url($post_id, 'full'));
        $intro_eyebrow   = alpha_edu_get_page_field('about_intro_eyebrow', $post_id, 'VỀ CHÚNG TÔI');
        $intro_title     = alpha_edu_get_page_field('about_intro_title', $post_id, 'TRUNG TÂM NGOẠI NGỮ - TIN HỌC ALPHA');
        $intro_content   = alpha_edu_get_page_field('about_intro_content', $post_id, "Trung tâm Ngoại ngữ - Tin học ALPHA được thành lập theo Quyết định số 1814/QĐ-SGDĐT ngày 08/8/2019 của Giám đốc Sở Giáo dục và Đào tạo tỉnh Thừa Thiên Huế. Trải qua quá trình xây dựng và phát triển, Trung tâm đã khẳng định được vai trò quan trọng trong việc tổ chức đào tạo, bồi dưỡng, thi và cấp chứng chỉ tin học cơ bản cũng như ngoại ngữ theo quy định của Bộ Giáo dục và Đào tạo.\n\nHằng năm, Trung tâm mở nhiều khóa đào tạo tin học và ngoại ngữ từ cơ bản đến nâng cao, giúp sinh viên và học viên không chỉ hoàn thiện kiến thức mà còn phát triển toàn diện các kỹ năng. Trung tâm đã tổ chức thi và cấp hàng nghìn chứng chỉ công nghệ thông tin và ngoại ngữ tiếng Anh cho sinh viên các trường đại học, cao đẳng cùng các học viên trong và ngoài tỉnh Thừa Thiên Huế.");
        $intro_image     = alpha_edu_get_page_field('about_intro_image', $post_id, $hero_image);
        $intro_documents = function_exists('alpha_edu_get_about_documents')
            ? alpha_edu_get_about_documents($post_id)
            : [];
        $mission_title   = alpha_edu_get_page_field('about_mission_title', $post_id, 'SỨ MỆNH');
        $mission_content = alpha_edu_get_page_field('about_mission_content', $post_id, 'Ra đời với sứ mệnh nâng cao trình độ ngoại ngữ và tin học, ALPHA luôn nỗ lực mang đến một môi trường học tập hiện đại, gần gũi và hiệu quả. Chúng tôi tự hào với đội ngũ giảng viên giàu kinh nghiệm, đầy nhiệt huyết, luôn sẵn sàng đồng hành cùng học viên trên hành trình trau dồi kiến thức.');
        $slogan_title    = alpha_edu_get_page_field('about_slogan_title', $post_id, 'KHẨU HIỆU');
        $slogan_content  = alpha_edu_get_page_field('about_slogan_content', $post_id, 'ALPHA - Uy tín dẫn đầu, tri thức vươn xa, nơi mỗi học viên được truyền cảm hứng, đam mê và sự tự tin để bước ra hành trình của mình với những bước chân vững chắc.');
        $achievement_title   = alpha_edu_get_page_field('about_achievement_title', $post_id, 'THÀNH TỰU');
        $achievement_content = alpha_edu_get_page_field('about_achievement_content', $post_id, 'Nhờ những nỗ lực không ngừng, năm 2023, Trung tâm Ngoại ngữ - Tin học ALPHA vinh dự được Sở Giáo dục và Đào tạo tỉnh Thừa Thiên Huế trao tặng bằng khen cho những đóng góp xuất sắc trong lĩnh vực đào tạo ngoại ngữ và tin học');
        $stats_title      = alpha_edu_get_page_field('about_stats_title', $post_id, 'THÔNG TIN NỔI BẬT');
        $stats_background = alpha_edu_get_page_field('about_stats_background', $post_id, $hero_image);
        $stats            = [];
        $testimonials_title = alpha_edu_get_home_field('home_testimonials_title');
        $testimonial_query  = new WP_Query([
            'post_type'      => 'testimonial',
            'posts_per_page' => -1,
            'meta_query'     => [
                [
                    'key'     => '_thumbnail_id',
                    'compare' => 'EXISTS',
                ],
            ],
            'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
        ]);
        $intro_title_html = esc_html($intro_title);

        foreach (['NGOẠI NGỮ - TIN HỌC ALPHA', 'NGOẠI NGỮ - TIN HỌC'] as $intro_title_phrase) {
            $escaped_phrase = esc_html($intro_title_phrase);

            if (false !== strpos($intro_title_html, $escaped_phrase)) {
                $intro_title_html = str_replace($escaped_phrase, '<span class="about-title-nowrap">' . $escaped_phrase . '</span>', $intro_title_html);
                break;
            }
        }

        for ($i = 1; $i <= 3; $i++) {
            $default_numbers = ['5+', '2000+', '300+'];
            $default_labels  = ['NĂM THÀNH LẬP', 'HỌC VIÊN', 'KHÓA HỌC'];
            $number = alpha_edu_get_page_field('about_stat_' . $i . '_number', $post_id, $default_numbers[$i - 1]);
            $label  = alpha_edu_get_page_field('about_stat_' . $i . '_label', $post_id, $default_labels[$i - 1]);

            if ($number || $label) {
                $stats[] = [
                    'number' => $number,
                    'label'  => $label,
                ];
            }
        }
        ?>

        <section class="about-hero"<?php echo $hero_image ? ' style="background-image: url(' . esc_url($hero_image) . ');"' : ''; ?>>
            <div class="about-hero-overlay">
                <h1><?php echo esc_html($hero_title); ?></h1>
            </div>
        </section>

        <section class="about-intro section-padding">
            <div class="container about-layout">
                <div class="about-intro-copy">
                    <?php if ($intro_eyebrow) : ?>
                        <p class="about-eyebrow"><?php echo esc_html($intro_eyebrow); ?></p>
                    <?php endif; ?>

                    <?php if ($intro_title) : ?>
                        <h2><?php echo wp_kses($intro_title_html, ['span' => ['class' => true]]); ?></h2>
                    <?php endif; ?>

                    <?php if ($intro_content) : ?>
                        <div class="about-rich-text"><?php echo wp_kses_post(wpautop($intro_content)); ?></div>
                    <?php endif; ?>

                    <?php if ($intro_documents) : ?>
                        <div class="about-document-grid">
                            <?php foreach ($intro_documents as $document) : ?>
                                <a class="about-document-card" href="<?php echo esc_url($document['file']); ?>" target="_blank" rel="noopener">
                                    <span class="about-document-cover">
                                        <?php if ($document['cover']) : ?>
                                            <img src="<?php echo esc_url($document['cover']); ?>" alt="<?php echo esc_attr($document['title']); ?>">
                                        <?php else : ?>
                                            <span class="about-document-pdf">PDF</span>
                                        <?php endif; ?>
                                    </span>
                                    <strong><?php echo esc_html($document['title']); ?></strong>
                                    <span class="about-document-action"><?php esc_html_e('Xem tài liệu', 'alpha-edu'); ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($intro_image) : ?>
                    <figure class="about-wide-image">
                        <img src="<?php echo esc_url($intro_image); ?>" alt="<?php echo esc_attr($intro_title ?: get_the_title()); ?>">
                    </figure>
                <?php endif; ?>
            </div>
        </section>

        <section class="about-values">
            <div class="container about-layout">
                <div class="about-value about-value-right">
                    <h2><?php echo esc_html($mission_title); ?></h2>
                    <div class="about-rich-text"><?php echo wp_kses_post(wpautop($mission_content)); ?></div>
                </div>

                <div class="about-value about-value-left">
                    <h2><?php echo esc_html($slogan_title); ?></h2>
                    <div class="about-rich-text"><?php echo wp_kses_post(wpautop($slogan_content)); ?></div>
                </div>

                <div class="about-value about-value-right">
                    <h2><?php echo esc_html($achievement_title); ?></h2>
                    <div class="about-rich-text"><?php echo wp_kses_post(wpautop($achievement_content)); ?></div>
                </div>
            </div>
        </section>

        <?php if ($stats_title || $stats) : ?>
            <section class="about-stats"<?php echo $stats_background ? ' style="background-image: url(' . esc_url($stats_background) . ');"' : ''; ?>>
                <div class="about-stats-overlay">
                    <div class="container about-layout">
                        <?php if ($stats_title) : ?>
                            <h2><?php echo esc_html($stats_title); ?></h2>
                        <?php endif; ?>

                        <?php if ($stats) : ?>
                            <div class="about-stats-grid">
                                <?php foreach ($stats as $stat) : ?>
                                    <div class="about-stat-card">
                                        <?php if ($stat['number']) : ?>
                                            <?php
                                            $stat_number = trim((string) $stat['number']);
                                            preg_match('/^([^0-9]*)([0-9][0-9,.]*)(.*)$/', $stat_number, $stat_matches);
                                            $stat_prefix = $stat_matches[1] ?? '';
                                            $stat_value  = isset($stat_matches[2]) ? (int) str_replace([',', '.'], '', $stat_matches[2]) : 0;
                                            $stat_suffix = $stat_matches[3] ?? '';
                                            ?>
                                            <strong class="stat-count" data-count="<?php echo esc_attr($stat_value); ?>" data-prefix="<?php echo esc_attr($stat_prefix); ?>" data-suffix="<?php echo esc_attr($stat_suffix); ?>"><?php echo esc_html($stat_number); ?></strong>
                                        <?php endif; ?>

                                        <?php if ($stat['label']) : ?>
                                            <span><?php echo esc_html($stat['label']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($testimonial_query->have_posts()) : ?>
            <section class="home-testimonials about-testimonials section-padding">
                <div class="container">
                    <?php if ($testimonials_title) : ?>
                        <h2 class="section-title section-title-center section-title-red"><?php echo esc_html($testimonials_title); ?></h2>
                    <?php endif; ?>

                    <div class="testimonial-slider-wrap">
                        <div class="swiper testimonial-swiper">
                            <div class="swiper-wrapper">
                                <?php
                                while ($testimonial_query->have_posts()) :
                                    $testimonial_query->the_post();
                                    ?>
                                    <div class="swiper-slide">
                                        <figure class="testimonial-card">
                                            <?php the_post_thumbnail('large', ['class' => 'testimonial-image', 'alt' => get_the_title()]); ?>
                                        </figure>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>

                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>
</main>
<?php
get_footer();
