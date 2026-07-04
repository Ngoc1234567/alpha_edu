<?php
/**
 * Template Name: Văn bản/Biểu mẫu
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();

$documents = function_exists('alpha_edu_get_documents_data') ? alpha_edu_get_documents_data() : [];
?>
<main class="documents-page section-padding">
    <div class="container documents-layout">
        <?php while (have_posts()) : the_post(); ?>
            <header class="documents-header">
                <h1><?php the_title(); ?></h1>
                <?php if (trim(get_the_content())) : ?>
                    <div class="documents-intro">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>
            </header>
        <?php endwhile; ?>

        <?php if ($documents) : ?>
            <div class="documents-list">
                <?php foreach ($documents as $document_index => $document) : ?>
                    <article class="document-item">
                        <div class="document-info">
                            <h2><?php echo esc_html($document['title']); ?></h2>
                            <?php if ($document['description']) : ?>
                                <p><?php echo esc_html($document['description']); ?></p>
                            <?php endif; ?>
                        </div>
                        <a class="document-download" href="<?php echo esc_url(alpha_edu_get_document_download_url($document_index)); ?>" download>
                            Tải xuống
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="documents-empty">Chưa có văn bản/Biểu mẫu nào.</p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
