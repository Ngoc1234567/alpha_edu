<?php
/**
 * Template Name: Tra cứu điểm
 * Template Post Type: page
 *
 * @package Alpha_Edu
 */

get_header();

$years = function_exists('alpha_edu_get_exam_years') ? alpha_edu_get_exam_years() : [];
$selected_year = isset($_GET['exam_year']) ? sanitize_text_field(wp_unslash($_GET['exam_year'])) : ($years[0] ?? '');
$courses = function_exists('alpha_edu_get_exam_courses') ? alpha_edu_get_exam_courses($selected_year) : [];
$selected_course = isset($_GET['exam_course']) ? sanitize_text_field(wp_unslash($_GET['exam_course'])) : ($courses[0] ?? '');
$courses_by_year = [];

foreach ($years as $year) {
    $courses_by_year[$year] = function_exists('alpha_edu_get_exam_courses') ? alpha_edu_get_exam_courses($year) : [];
}

if ($courses && ! in_array($selected_course, $courses, true)) {
    $selected_course = $courses[0];
}

$cccd = isset($_GET['exam_cccd']) ? sanitize_text_field(wp_unslash($_GET['exam_cccd'])) : '';
$has_searched = isset($_GET['exam_lookup']);
$results = [];

if ($has_searched && function_exists('alpha_edu_lookup_exam_results')) {
    $results = alpha_edu_lookup_exam_results($selected_year, $selected_course, $cccd);
}
?>
<main class="score-page section-padding">
    <div class="container score-layout">
        <h1 class="score-page-title">TRA CỨU KẾT QUẢ THI</h1>

        <form class="score-lookup-form" method="get" action="<?php echo esc_url(get_permalink()); ?>">
            <input type="hidden" name="exam_lookup" value="1">

            <label class="score-field">
                <span>Năm:</span>
                <select name="exam_year" data-score-year>
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
                <select name="exam_course" data-score-course>
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
                <span>Số CCCD:</span>
                <input type="text" name="exam_cccd" value="<?php echo esc_attr($cccd); ?>" inputmode="numeric" placeholder="Nhập số CCCD">
            </label>

            <button class="score-submit" type="submit">Tra cứu</button>
        </form>

        <script>
            (function () {
                var coursesByYear = <?php echo wp_json_encode($courses_by_year); ?>;
                var yearSelect = document.querySelector('[data-score-year]');
                var courseSelect = document.querySelector('[data-score-course]');

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
            <?php if ($has_searched && '' === trim($cccd)) : ?>
                <p class="score-message">Vui lòng nhập số CCCD để tra cứu.</p>
            <?php elseif ($has_searched && ! $results) : ?>
                <p class="score-message">Không tìm thấy kết quả phù hợp. Vui lòng kiểm tra lại năm, khóa thi và số CCCD.</p>
            <?php elseif ($has_searched) : ?>
                <table class="score-result-table">
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
                            <?php
                            $result_text = trim((string) ($row['result'] ?? ''));
                            $result_key = sanitize_title(remove_accents($result_text));
                            $result_class = '';

                            if ('dat' === $result_key) {
                                $result_class = ' is-pass';
                            } elseif ('khong-dat' === $result_key) {
                                $result_class = ' is-fail';
                            }
                            ?>
                            <tr>
                                <td><?php echo esc_html($row['cccd']); ?></td>
                                <td><?php echo esc_html(('' !== ($row['student_name'] ?? '')) ? $row['student_name'] : '-'); ?></td>
                                <td>
                                    <span>- Điểm lý thuyết: <strong><?php echo esc_html($row['theory'] ?: '-'); ?></strong></span>
                                    <span>- Điểm thực hành: <strong><?php echo esc_html($row['practice'] ?: '-'); ?></strong></span>
                                    <span>- Kết quả thi: <strong class="score-result-status<?php echo esc_attr($result_class); ?>"><?php echo esc_html($result_text ?: '-'); ?></strong></span>
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
