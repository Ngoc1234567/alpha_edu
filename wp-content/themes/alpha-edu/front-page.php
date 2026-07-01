<?php
/**
 * Front page template.
 *
 * @package Alpha_Edu
 */

get_header();
?>

<main class="home-page">
    <?php
    get_template_part('template-parts/home/hero');
    get_template_part('template-parts/home/intro');
    get_template_part('template-parts/home/courses');
    get_template_part('template-parts/home/stats');
    get_template_part('template-parts/home/testimonials');
    ?>
</main>

<?php
get_footer();

