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
<main class="score-page section-padding">
    <div class="container score-layout">
        <h1 class="score-page-title">TRA CỨU THÔNG TIN CHỨNG CHỈ</h1>

        <form class="score-lookup-form" method="get" action="<?php echo esc_url(get_permalink()); ?>">
            <input type="hidden" name="certificate_lookup" value="1">

            <label class="score-field">
                <span>Số hiệu chứng chỉ:</span>
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
                            <th>Học viên</th>
                            <th>Kết quả tra cứu</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row) : ?>
                            <?php
                            $status_text = trim((string) ($row['status'] ?? ''));
                            $status_key = sanitize_title(remove_accents($status_text));
                            $status_class = '';

                            if ('dat' === $status_key) {
                                $status_class = ' is-pass';
                            } elseif ('khong-dat' === $status_key) {
                                $status_class = ' is-fail';
                            }
                            ?>
                            <tr>
                                <td><?php echo esc_html(('' !== ($row['student_name'] ?? '')) ? $row['student_name'] : '-'); ?></td>
                                <td>
                                    <span>- Tên chứng chỉ: <strong><?php echo esc_html($row['certificate_name'] ?: '-'); ?></strong></span>
                                    <span>- Số hiệu chứng chỉ: <strong><?php echo esc_html($row['certificate_number'] ?: '-'); ?></strong></span>
                                    <span>- Ngày sinh: <strong><?php echo esc_html(($row['birth_date'] ?? '') ?: '-'); ?></strong></span>
                                    <span>- Ngày cấp: <strong><?php echo esc_html($row['issue_date'] ?: '-'); ?></strong></span>
                                    <span>- Hội đồng cấp: <strong><?php echo esc_html(($row['council'] ?? '') ?: '-'); ?></strong></span>
                                    <span>- Kết quả thi: <strong class="score-result-status<?php echo esc_attr($status_class); ?>"><?php echo esc_html($status_text ?: '-'); ?></strong></span>
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
