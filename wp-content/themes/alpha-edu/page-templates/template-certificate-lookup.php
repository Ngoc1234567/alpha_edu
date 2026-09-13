<?php
/**
 * Template Name: Tra cứu thông tin chứng chỉ
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();

$years = function_exists('alpha_edu_get_certificate_years') ? alpha_edu_get_certificate_years() : [];
$selected_year = isset($_GET['certificate_year']) ? sanitize_text_field(wp_unslash($_GET['certificate_year'])) : ($years[0] ?? '');
$courses = function_exists('alpha_edu_get_certificate_courses') ? alpha_edu_get_certificate_courses($selected_year) : [];
$selected_course = isset($_GET['certificate_course']) ? sanitize_text_field(wp_unslash($_GET['certificate_course'])) : ($courses[0] ?? '');
$courses_by_year = [];

foreach ($years as $year) {
    $courses_by_year[$year] = function_exists('alpha_edu_get_certificate_courses') ? alpha_edu_get_certificate_courses($year) : [];
}

if ($courses && ! in_array($selected_course, $courses, true)) {
    $selected_course = $courses[0];
}

$keyword = isset($_GET['certificate_keyword']) ? sanitize_text_field(wp_unslash($_GET['certificate_keyword'])) : '';
$has_searched = isset($_GET['certificate_lookup']);
$results = [];

if ($has_searched && function_exists('alpha_edu_lookup_certificate_results')) {
    $results = alpha_edu_lookup_certificate_results($selected_year, $selected_course, $keyword);
}
?>
<main class="score-page section-padding">
    <div class="container score-layout">
        <h1 class="score-page-title">TRA CỨU THÔNG TIN CHỨNG CHỈ</h1>

        <form class="score-lookup-form" method="get" action="<?php echo esc_url(get_permalink()); ?>">
            <input type="hidden" name="certificate_lookup" value="1">

            <label class="score-field">
                <span>Năm:</span>
                <select name="certificate_year" data-certificate-year>
                    <?php if ($years) : ?>
                        <?php foreach ($years as $year) : ?>
                            <option value="<?php echo esc_attr($year); ?>" <?php selected($selected_year, $year); ?>>
                                <?php echo esc_html($year); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value=""><?php esc_html_e('Chưa có dữ liệu', 'alpha-edu'); ?></option>
                    <?php endif; ?>
                </select>
            </label>

            <label class="score-field">
                <span>Khóa thi:</span>
                <select name="certificate_course" data-certificate-course>
                    <?php if ($courses) : ?>
                        <?php foreach ($courses as $course) : ?>
                            <option value="<?php echo esc_attr($course); ?>" <?php selected($selected_course, $course); ?>>
                                <?php echo esc_html($course); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value=""><?php esc_html_e('Chưa có dữ liệu', 'alpha-edu'); ?></option>
                    <?php endif; ?>
                </select>
            </label>

            <label class="score-field">
                <span>Số hiệu chứng chỉ / CCCD:</span>
                <input type="text" name="certificate_keyword" value="<?php echo esc_attr($keyword); ?>" placeholder="Nhập số hiệu chứng chỉ hoặc CCCD">
            </label>

            <button class="score-submit" type="submit">Tra cứu</button>
        </form>

        <script>
            (function () {
                var coursesByYear = <?php echo wp_json_encode($courses_by_year); ?>;
                var yearSelect = document.querySelector('[data-certificate-year]');
                var courseSelect = document.querySelector('[data-certificate-course]');

                if (!yearSelect || !courseSelect) {
                    return;
                }

                yearSelect.addEventListener('change', function () {
                    var courses = coursesByYear[yearSelect.value] || [];
                    courseSelect.innerHTML = '';

                    if (!courses.length) {
                        var emptyOption = document.createElement('option');
                        emptyOption.value = '';
                        emptyOption.textContent = 'Chưa có dữ liệu';
                        courseSelect.appendChild(emptyOption);
                        return;
                    }

                    courses.forEach(function (course) {
                        var option = document.createElement('option');
                        option.value = course;
                        option.textContent = course;
                        courseSelect.appendChild(option);
                    });
                });
            }());
        </script>

        <div class="score-result-wrap">
            <?php if ($has_searched && '' === trim($keyword)) : ?>
                <p class="score-message">Vui lòng nhập số hiệu chứng chỉ hoặc CCCD để tra cứu.</p>
            <?php elseif ($has_searched && ! $results) : ?>
                <p class="score-message">Không tìm thấy thông tin chứng chỉ phù hợp. Vui lòng kiểm tra lại năm, khóa thi và thông tin tra cứu.</p>
            <?php elseif ($has_searched) : ?>
                <table class="score-result-table certificate-result-table">
                    <thead>
                        <tr>
                            <th>CCCD</th>
                            <th>Học viên</th>
                            <th>Kết quả tra cứu</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row) : ?>
                            <tr>
                                <td><?php echo esc_html($row['cccd'] ?: '-'); ?></td>
                                <td><?php echo esc_html(('' !== ($row['student_name'] ?? '')) ? $row['student_name'] : '-'); ?></td>
                                <td>
                                    <span>- Tên chứng chỉ: <strong><?php echo esc_html($row['certificate_name'] ?: '-'); ?></strong></span>
                                    <span>- Số hiệu chứng chỉ: <strong><?php echo esc_html($row['certificate_number'] ?: '-'); ?></strong></span>
                                    <span>- Ngày sinh: <strong><?php echo esc_html(($row['birth_date'] ?? '') ?: '-'); ?></strong></span>
                                    <span>- Ngày cấp: <strong><?php echo esc_html($row['issue_date'] ?: '-'); ?></strong></span>
                                    <span>- Hội đồng cấp: <strong><?php echo esc_html(($row['council'] ?? '') ?: '-'); ?></strong></span>
                                    <span>- Trạng thái: <strong><?php echo esc_html($row['status'] ?: '-'); ?></strong></span>
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
