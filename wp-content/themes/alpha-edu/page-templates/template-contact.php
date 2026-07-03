<?php
/**
 * Template Name: Liên hệ
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();
?>
<main class="contact-page section-padding">
    <div class="container contact-layout">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('contact-content'); ?>>
                <h1>[THÔNG TIN LIÊN HỆ VÀ HỖ TRỢ HỌC VIÊN]</h1>

                <section class="contact-info" aria-labelledby="alpha-contact-info-title">
                    <h2 id="alpha-contact-info-title">ĐỊA CHỈ VÀ THÔNG TIN LIÊN HỆ TRUNG TÂM ALPHA</h2>
                    <p>Giải đáp thắc mắc hoặc cần hỗ trợ</p>
                    <ul>
                        <li>Số điện thoại:&nbsp; 0796 670 717 - 0766 508 169</li>
                    </ul>
                </section>

                <?php
                $content = trim(get_the_content());

                if (! empty($content)) :
                    ?>
                    <div class="contact-extra">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();
