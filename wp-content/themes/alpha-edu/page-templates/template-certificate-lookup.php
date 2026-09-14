<?php
/**
 * Template Name: Tra cứu thông tin chứng chỉ
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();

$keyword = isset($_GET['certificate_keyword']) ? sanitize_text_field(wp_unslash($_GET['certificate_keyword'])) : '';
$has_searched = isset($_GET['certificate_lookup']);
$results = [];

if ($has_searched && function_exists('alpha_edu_lookup_certificate_results')) {
    $results = alpha_edu_lookup_certificate_results($keyword);
}
?>
<main class="score-page certificate-lookup-page section-padding">
    <div class="container score-layout">
        <h1 class="score-page-title">TRA CỨU THÔNG TIN CHỨNG CHỈ</h1>

        <form class="score-lookup-form" method="get" action="<?php echo esc_url(get_permalink()); ?>">
            <input type="hidden" name="certificate_lookup" value="1">

            <label class="score-field">
                <span>Số hiệu:</span>
                <input type="text" name="certificate_keyword" value="<?php echo esc_attr($keyword); ?>" placeholder="Nhập số hiệu chứng chỉ">
            </label>

            <button class="score-submit" type="submit">Tra cứu</button>
        </form>

        <div class="score-result-wrap">
            <?php if ($has_searched && '' === trim($keyword)) : ?>
                <p class="score-message">Vui lòng nhập số hiệu chứng chỉ để tra cứu.</p>
            <?php elseif ($has_searched && ! $results) : ?>
                <p class="score-message">Không tìm thấy thông tin chứng chỉ phù hợp. Vui lòng kiểm tra lại số hiệu chứng chỉ.</p>
            <?php elseif ($has_searched) : ?>
                <table class="score-result-table certificate-result-table">
                    <thead>
                        <tr>
                            <th>Số hiệu</th>
                            <th>Thông tin</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row) : ?>
                            <tr>
                                <td class="certificate-number"><?php echo esc_html($row['certificate_number'] ?: '-'); ?></td>
                                <td class="certificate-information">
                                    <dl>
                                        <div><dt>Họ và tên:</dt><dd class="certificate-student-name"><?php echo esc_html(($row['student_name'] ?? '') ?: '-'); ?></dd></div>
                                        <div><dt>Ngày sinh:</dt><dd><?php echo esc_html(($row['birth_date'] ?? '') ?: '-'); ?></dd></div>
                                        <div><dt>Hội đồng cấp chứng chỉ:</dt><dd><?php echo esc_html(($row['council'] ?? '') ?: '-'); ?></dd></div>
                                        <div><dt>Loại chứng chỉ:</dt><dd><?php echo esc_html(($row['certificate_name'] ?? '') ?: '-'); ?></dd></div>
                                        <div><dt>Ngày thi:</dt><dd><?php echo esc_html(($row['course'] ?? '') ?: '-'); ?></dd></div>
                                        <div><dt>Ngày cấp chứng chỉ:</dt><dd><?php echo esc_html(($row['issue_date'] ?? '') ?: '-'); ?></dd></div>
                                    </dl>
                                </td>
                                <td><?php echo esc_html($row['note'] ?: '-'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php
get_footer();
