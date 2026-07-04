<?php
/**
 * Alpha Edu theme functions.
 *
 * @package Alpha_Edu
 */

if (! defined('ABSPATH')) {
    exit;
}

function alpha_edu_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary'    => __('Menu chính', 'alpha-edu'),
        'header_cta' => __('Nút header', 'alpha-edu'),
        'footer'     => __('Menu footer', 'alpha-edu'),
    ]);
}
add_action('after_setup_theme', 'alpha_edu_setup');

function alpha_edu_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');
    $main_css_path = get_template_directory() . '/assets/css/main.css';
    $main_js_path  = get_template_directory() . '/assets/js/main.js';
    $main_css_ver  = file_exists($main_css_path) ? (string) filemtime($main_css_path) : $theme_version;
    $main_js_ver   = file_exists($main_js_path) ? (string) filemtime($main_js_path) : $theme_version;

    wp_enqueue_style('alpha-edu-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap', [], null);
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11');
    wp_enqueue_style('alpha-edu-main', get_template_directory_uri() . '/assets/css/main.css', ['alpha-edu-fonts', 'swiper'], $main_css_ver);

    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11', true);
    wp_enqueue_script('alpha-edu-main', get_template_directory_uri() . '/assets/js/main.js', ['swiper'], $main_js_ver, true);

    if (function_exists('alpha_edu_registration_options')) {
        wp_localize_script('alpha-edu-main', 'alphaEduRegistration', alpha_edu_registration_options());
    }
}
add_action('wp_enqueue_scripts', 'alpha_edu_enqueue_assets');

function alpha_edu_normalize_menu_label($label) {
    $label = remove_accents(wp_strip_all_tags((string) $label));
    $label = strtolower(trim($label));

    return preg_replace('/\s+/', ' ', $label);
}

function alpha_edu_hide_exam_registration_menu_item($classes, $item, $args) {
    if (! empty($args->theme_location) && 'primary' === $args->theme_location && 'dang ky thi' === alpha_edu_normalize_menu_label($item->title ?? '')) {
        $classes[] = 'is-hidden-menu-item';
    }

    return $classes;
}
add_filter('nav_menu_css_class', 'alpha_edu_hide_exam_registration_menu_item', 10, 3);

function alpha_edu_register_post_types() {
    register_post_type('course', [
        'labels' => [
            'name' => __('Khóa học', 'alpha-edu'),
            'singular_name' => __('Khóa học', 'alpha-edu'),
            'add_new_item' => __('Thêm khóa học', 'alpha-edu'),
            'edit_item' => __('Sửa khóa học', 'alpha-edu'),
            'new_item' => __('Khóa học mới', 'alpha-edu'),
            'view_item' => __('Xem khóa học', 'alpha-edu'),
            'search_items' => __('Tìm khóa học', 'alpha-edu'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'khoa-hoc'],
        'show_in_rest' => true,
    ]);

    register_post_type('testimonial', [
        'labels' => [
            'name' => __('Ảnh đánh giá học viên', 'alpha-edu'),
            'singular_name' => __('Ảnh đánh giá học viên', 'alpha-edu'),
            'add_new_item' => __('Thêm ảnh đánh giá', 'alpha-edu'),
            'edit_item' => __('Sửa ảnh đánh giá', 'alpha-edu'),
            'new_item' => __('Ảnh đánh giá mới', 'alpha-edu'),
            'view_item' => __('Xem ảnh đánh giá', 'alpha-edu'),
            'search_items' => __('Tìm ảnh đánh giá', 'alpha-edu'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-format-image',
        'supports' => ['title', 'thumbnail', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'danh-gia-hoc-vien'],
        'show_in_rest' => true,
    ]);

    register_post_type('alpha_notice', [
        'labels' => [
            'name' => __('Thông báo', 'alpha-edu'),
            'singular_name' => __('Thông báo', 'alpha-edu'),
            'add_new_item' => __('Thêm thông báo', 'alpha-edu'),
            'edit_item' => __('Sửa thông báo', 'alpha-edu'),
            'new_item' => __('Thông báo mới', 'alpha-edu'),
            'view_item' => __('Xem thông báo', 'alpha-edu'),
            'search_items' => __('Tìm thông báo', 'alpha-edu'),
        ],
        'public' => true,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'thong-bao'],
        'show_in_rest' => true,
    ]);

}
add_action('init', 'alpha_edu_register_post_types');

function alpha_edu_testimonial_image_labels($labels) {
    $labels->name                  = __('Ảnh đánh giá học viên', 'alpha-edu');
    $labels->singular_name         = __('Ảnh đánh giá học viên', 'alpha-edu');
    $labels->add_new_item          = __('Thêm ảnh đánh giá', 'alpha-edu');
    $labels->edit_item             = __('Sửa ảnh đánh giá', 'alpha-edu');
    $labels->new_item              = __('Ảnh đánh giá mới', 'alpha-edu');
    $labels->view_item             = __('Xem ảnh đánh giá', 'alpha-edu');
    $labels->search_items          = __('Tìm ảnh đánh giá', 'alpha-edu');
    $labels->featured_image        = __('Ảnh đánh giá', 'alpha-edu');
    $labels->set_featured_image    = __('Chọn ảnh đánh giá', 'alpha-edu');
    $labels->remove_featured_image = __('Xóa ảnh đánh giá', 'alpha-edu');
    $labels->use_featured_image    = __('Dùng làm ảnh đánh giá', 'alpha-edu');

    return $labels;
}
add_filter('post_type_labels_testimonial', 'alpha_edu_testimonial_image_labels');

function alpha_edu_testimonial_admin_columns($columns) {
    $new_columns = [];

    foreach ($columns as $key => $label) {
        if ('title' === $key) {
            $new_columns['alpha_testimonial_image'] = __('Ảnh', 'alpha-edu');
        }

        $new_columns[$key] = $label;
    }

    return $new_columns;
}
add_filter('manage_testimonial_posts_columns', 'alpha_edu_testimonial_admin_columns');

function alpha_edu_testimonial_admin_column_content($column, $post_id) {
    if ('alpha_testimonial_image' !== $column) {
        return;
    }

    if (has_post_thumbnail($post_id)) {
        echo get_the_post_thumbnail($post_id, 'thumbnail', ['style' => 'width:88px;height:64px;object-fit:cover;border:1px solid #dcdcde;background:#fff;']);
    } else {
        echo '<span aria-hidden="true">-</span>';
    }
}
add_action('manage_testimonial_posts_custom_column', 'alpha_edu_testimonial_admin_column_content', 10, 2);

function alpha_edu_testimonial_title_placeholder($title, $post) {
    if ('testimonial' === $post->post_type) {
        return __('Tên ảnh/ghi chú (không hiển thị ngoài trang)', 'alpha-edu');
    }

    return $title;
}
add_filter('enter_title_here', 'alpha_edu_testimonial_title_placeholder', 10, 2);

function alpha_edu_register_testimonial_image_help_box() {
    add_meta_box(
        'alpha-testimonial-image-help',
        __('Hướng dẫn', 'alpha-edu'),
        'alpha_edu_render_testimonial_image_help_box',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_testimonial', 'alpha_edu_register_testimonial_image_help_box');

function alpha_edu_render_testimonial_image_help_box() {
    echo '<p>' . esc_html__('Mỗi mục đánh giá học viên là một hình ảnh. Hãy chọn ảnh ở khung “Ảnh đánh giá”; phần tên chỉ dùng để quản lý trong admin và không hiển thị ngoài trang.', 'alpha-edu') . '</p>';
}

function alpha_edu_hide_testimonial_rating_field($field) {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    if ($screen && 'testimonial' === $screen->post_type) {
        return false;
    }

    return $field;
}
add_filter('acf/prepare_field/name=testimonial_rating', 'alpha_edu_hide_testimonial_rating_field');

function alpha_edu_register_notice_images_meta_box() {
    add_meta_box(
        'alpha-notice-images',
        __('Ảnh thông báo', 'alpha-edu'),
        'alpha_edu_render_notice_images_meta_box',
        'alpha_notice',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'alpha_edu_register_notice_images_meta_box');

function alpha_edu_get_notice_image_ids($post_id) {
    $image_ids = get_post_meta($post_id, '_alpha_notice_images', true);

    if (! is_array($image_ids)) {
        return [];
    }

    return array_values(array_filter(array_map('absint', $image_ids)));
}

function alpha_edu_get_notice_images($post_id, $size = 'medium_large') {
    $images = [];

    foreach (alpha_edu_get_notice_image_ids($post_id) as $image_id) {
        $image = wp_get_attachment_image_src($image_id, $size);

        if (! $image) {
            continue;
        }

        $images[] = [
            'url' => $image[0],
            'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true),
        ];
    }

    return $images;
}

function alpha_edu_render_notice_images_meta_box($post) {
    $image_ids = alpha_edu_get_notice_image_ids($post->ID);

    wp_nonce_field('alpha_notice_images', 'alpha_notice_images_nonce');
    ?>
    <div class="alpha-notice-images" data-alpha-notice-images>
        <input type="hidden" name="alpha_notice_images" value="<?php echo esc_attr(implode(',', $image_ids)); ?>" data-alpha-notice-images-input>

        <div class="alpha-notice-images-preview" data-alpha-notice-images-preview>
            <?php foreach ($image_ids as $image_id) : ?>
                <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
            <?php endforeach; ?>
        </div>

        <p>
            <button type="button" class="button" data-alpha-notice-images-select><?php esc_html_e('Chọn ảnh', 'alpha-edu'); ?></button>
            <button type="button" class="button-link-delete" data-alpha-notice-images-clear><?php esc_html_e('Xóa ảnh', 'alpha-edu'); ?></button>
        </p>
    </div>
    <?php
}

function alpha_edu_save_notice_images($post_id) {
    if (
        ! isset($_POST['alpha_notice_images_nonce'])
        || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alpha_notice_images_nonce'])), 'alpha_notice_images')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $raw_image_ids = isset($_POST['alpha_notice_images']) ? sanitize_text_field(wp_unslash($_POST['alpha_notice_images'])) : '';
    $image_ids = array_values(array_filter(array_map('absint', explode(',', $raw_image_ids))));

    if ($image_ids) {
        update_post_meta($post_id, '_alpha_notice_images', $image_ids);
    } else {
        delete_post_meta($post_id, '_alpha_notice_images');
    }
}
add_action('save_post_alpha_notice', 'alpha_edu_save_notice_images');

function alpha_edu_enqueue_notice_images_admin_assets($hook_suffix) {
    if (! in_array($hook_suffix, ['post.php', 'post-new.php'], true)) {
        return;
    }

    $screen = get_current_screen();

    if (! $screen || 'alpha_notice' !== $screen->post_type) {
        return;
    }

    wp_enqueue_media();

    wp_add_inline_style(
        'wp-admin',
        '.alpha-notice-images-preview{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;margin:10px 0}.alpha-notice-images-preview img{width:100%;height:78px;object-fit:cover;border:1px solid #dcdcde;background:#f6f7f7}.alpha-notice-images .button-link-delete{margin-left:8px;color:#b32d2e}'
    );

    wp_add_inline_script(
        'jquery-core',
        "jQuery(function($){var frame;$('[data-alpha-notice-images-select]').on('click',function(e){e.preventDefault();var box=$(this).closest('[data-alpha-notice-images]');var input=box.find('[data-alpha-notice-images-input]');var preview=box.find('[data-alpha-notice-images-preview]');frame=wp.media({title:'Chọn ảnh thông báo',button:{text:'Dùng ảnh này'},library:{type:'image'},multiple:true});frame.on('select',function(){var ids=[];preview.empty();frame.state().get('selection').each(function(attachment){var data=attachment.toJSON();ids.push(data.id);var src=(data.sizes&&data.sizes.thumbnail)?data.sizes.thumbnail.url:data.url;preview.append($('<img>',{src:src,alt:data.alt||data.title||''}));});input.val(ids.join(','));});frame.open();});$('[data-alpha-notice-images-clear]').on('click',function(e){e.preventDefault();var box=$(this).closest('[data-alpha-notice-images]');box.find('[data-alpha-notice-images-input]').val('');box.find('[data-alpha-notice-images-preview]').empty();});});"
    );
}
add_action('admin_enqueue_scripts', 'alpha_edu_enqueue_notice_images_admin_assets');

function alpha_edu_get_course_field($post_id, $key, $default = '') {
    if (function_exists('get_field')) {
        $acf_value = get_field($key, $post_id);

        if ('' !== $acf_value && null !== $acf_value && false !== $acf_value) {
            return $acf_value;
        }
    }

    $value = get_post_meta($post_id, '_' . $key, true);

    if ('' === $value || null === $value || false === $value) {
        return $default;
    }

    return $value;
}

function alpha_edu_parse_course_fee_rows($value) {
    $rows = [];
    $lines = preg_split('/\r\n|\r|\n/', (string) $value);

    foreach ($lines as $line) {
        $line = trim($line);

        if ('' === $line) {
            continue;
        }

        $parts = array_map('trim', explode('|', $line));
        $rows[] = [
            'name'     => $parts[0] ?? '',
            'tuition'  => $parts[1] ?? '',
            'exam_fee' => $parts[2] ?? '',
            'note'     => $parts[3] ?? '',
        ];
    }

    return $rows;
}

function alpha_edu_get_course_registration_items($value) {
    $items = [];
    $lines = preg_split('/\r\n|\r|\n/', (string) $value);

    foreach ($lines as $line) {
        $line = trim($line);

        if ('' !== $line) {
            $items[] = $line;
        }
    }

    return $items;
}

function alpha_edu_register_course_details_meta_box() {
    add_meta_box(
        'alpha-course-details',
        __('Chi tiết khóa học', 'alpha-edu'),
        'alpha_edu_render_course_details_meta_box',
        'course',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_course', 'alpha_edu_register_course_details_meta_box');

function alpha_edu_render_course_details_meta_box($post) {
    wp_nonce_field('alpha_edu_save_course_details', 'alpha_edu_course_details_nonce');

    $intro         = alpha_edu_get_course_field($post->ID, 'course_detail_intro');
    $fees          = alpha_edu_get_course_field($post->ID, 'course_fee_rows');
    $guide_title   = alpha_edu_get_course_field($post->ID, 'course_registration_title', 'HƯỚNG DẪN ĐĂNG KÝ:');
    $guide         = alpha_edu_get_course_field($post->ID, 'course_registration_items');
    $button_text   = alpha_edu_get_course_field($post->ID, 'course_register_button_text', 'ĐĂNG KÝ TẠI ĐÂY');
    $button_url    = alpha_edu_get_course_field($post->ID, 'course_register_button_url');
    $cf7_shortcode = alpha_edu_get_course_field($post->ID, 'course_cf7_shortcode');
    ?>
    <style>
        .alpha-course-fields{display:grid;gap:18px}
        .alpha-course-fields label{display:block;font-weight:700;margin-bottom:6px}
        .alpha-course-fields input[type="text"],
        .alpha-course-fields input[type="url"],
        .alpha-course-fields textarea{width:100%}
        .alpha-course-fields textarea{min-height:118px}
        .alpha-course-help{margin:6px 0 0;color:#646970}
    </style>
    <div class="alpha-course-fields">
        <div>
            <label for="alpha-course-detail-intro"><?php esc_html_e('Giới thiệu khóa học', 'alpha-edu'); ?></label>
            <textarea id="alpha-course-detail-intro" name="alpha_course_details[course_detail_intro]"><?php echo esc_textarea($intro); ?></textarea>
            <p class="alpha-course-help"><?php esc_html_e('Nếu bỏ trống, trang chi tiết sẽ dùng nội dung trong trình soạn thảo chính.', 'alpha-edu'); ?></p>
        </div>
        <div>
            <label for="alpha-course-fee-rows"><?php esc_html_e('Bảng học phí', 'alpha-edu'); ?></label>
            <textarea id="alpha-course-fee-rows" name="alpha_course_details[course_fee_rows]" placeholder="Khóa CNTT cơ bản | 1.150.000 VND | 750.000 VND&#10;Khóa CNTT nâng cao | 1.800.000 VND | 1.500.000 VND | Phải có chứng chỉ CNTT cơ bản"><?php echo esc_textarea($fees); ?></textarea>
            <p class="alpha-course-help"><?php esc_html_e('Mỗi dòng: Tên khóa | Học phí | Lệ phí thi | Ghi chú.', 'alpha-edu'); ?></p>
        </div>
        <div>
            <label for="alpha-course-registration-title"><?php esc_html_e('Tiêu đề hướng dẫn đăng ký', 'alpha-edu'); ?></label>
            <input id="alpha-course-registration-title" type="text" name="alpha_course_details[course_registration_title]" value="<?php echo esc_attr($guide_title); ?>">
        </div>
        <div>
            <label for="alpha-course-registration-items"><?php esc_html_e('Nội dung hướng dẫn đăng ký', 'alpha-edu'); ?></label>
            <textarea id="alpha-course-registration-items" name="alpha_course_details[course_registration_items]" placeholder="Đăng ký trực tiếp&#10;- Cơ sở 1: Số 04/56 Đường Đặng Huy Trứ, Thành Phố Huế&#10;Đăng ký qua Hotline - Zalo 0796 670 717 (Alpha Center)"><?php echo esc_textarea($guide); ?></textarea>
            <p class="alpha-course-help"><?php esc_html_e('Mỗi dòng sẽ hiển thị thành một dòng hướng dẫn. Dòng bắt đầu bằng dấu - sẽ là dòng phụ.', 'alpha-edu'); ?></p>
        </div>
        <div>
            <label for="alpha-course-register-button-text"><?php esc_html_e('Chữ trên nút đăng ký', 'alpha-edu'); ?></label>
            <input id="alpha-course-register-button-text" type="text" name="alpha_course_details[course_register_button_text]" value="<?php echo esc_attr($button_text); ?>">
        </div>
        <div>
            <label for="alpha-course-register-button-url"><?php esc_html_e('Link nút đăng ký', 'alpha-edu'); ?></label>
            <input id="alpha-course-register-button-url" type="url" name="alpha_course_details[course_register_button_url]" value="<?php echo esc_url($button_url); ?>" placeholder="<?php echo esc_attr(home_url('/dang-ky-hoc/')); ?>">
        </div>
        <div>
            <label for="alpha-course-cf7-shortcode"><?php esc_html_e('Shortcode Contact Form 7', 'alpha-edu'); ?></label>
            <input id="alpha-course-cf7-shortcode" type="text" name="alpha_course_details[course_cf7_shortcode]" value="<?php echo esc_attr($cf7_shortcode); ?>" placeholder='[contact-form-7 id="123" title="Form đăng ký học/thi"]'>
            <p class="alpha-course-help"><?php esc_html_e('Nếu bỏ trống, hệ thống sẽ tự tìm form Contact Form 7 có chữ “đăng ký”, hoặc lấy form đầu tiên.', 'alpha-edu'); ?></p>
        </div>
    </div>
    <?php
}
function alpha_edu_save_course_details($post_id) {
    if (
        ! isset($_POST['alpha_edu_course_details_nonce'])
        || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['alpha_edu_course_details_nonce'])), 'alpha_edu_save_course_details')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = isset($_POST['alpha_course_details']) && is_array($_POST['alpha_course_details'])
        ? wp_unslash($_POST['alpha_course_details'])
        : [];

    $textareas = ['course_detail_intro', 'course_fee_rows', 'course_registration_items'];
    $texts     = ['course_registration_title', 'course_register_button_text', 'course_cf7_shortcode'];
    $urls      = ['course_register_button_url'];

    foreach ($textareas as $key) {
        update_post_meta($post_id, '_' . $key, sanitize_textarea_field($fields[$key] ?? ''));
    }

    foreach ($texts as $key) {
        update_post_meta($post_id, '_' . $key, sanitize_text_field($fields[$key] ?? ''));
    }

    foreach ($urls as $key) {
        update_post_meta($post_id, '_' . $key, esc_url_raw($fields[$key] ?? ''));
    }
}
add_action('save_post_course', 'alpha_edu_save_course_details');

function alpha_edu_registration_fields() {
    return [
        'last_name'     => 'Họ và tên đệm',
        'first_name'    => 'Tên',
        'birthday'      => 'Ngày sinh',
        'birthplace'    => 'Nơi sinh',
        'phone'         => 'Số điện thoại',
        'email'         => 'Email',
        'cccd'          => 'Số CCCD',
        'cccd_date'     => 'Ngày cấp CCCD',
        'address'       => 'Địa chỉ thường trú',
        'organization'  => 'Đơn vị công tác/ Đào tạo',
        'type'          => 'Hình thức',
        'program'       => 'Chương trình',
        'course'        => 'Khóa đăng ký',
        'schedule'      => 'Lịch học/ lịch thi',
        'supporter'     => 'Nhân viên hướng dẫn/ hỗ trợ',
        'note'          => 'Ghi chú',
        'source_course' => 'Khóa học nguồn',
    ];
}

function alpha_edu_get_registration_exam_schedules() {
    $value = get_option('alpha_registration_exam_schedules', '');
    $lines = preg_split('/\r\n|\r|\n/', (string) $value);
    $items = [];

    foreach ($lines as $line) {
        $line = trim($line);

        if ('' !== $line) {
            $items[] = $line;
        }
    }

    return $items;
}

function alpha_edu_registration_options() {
    return [
        'programs' => [
            'Đăng ký học' => ['Tiếng Anh', 'Tin học', 'Tiếng Trung'],
            'Đăng ký thi' => ['Tin học'],
        ],
        'courses' => [
            'Đăng ký học' => [
                'Tiếng Anh' => [
                    'B1 VSTEP',
                    'B1 VSTEP (Tự do)',
                    'A2 - B1 Aptis (Đào tạo)',
                    'B2 Aptis (Đào tạo)',
                    'B1 Aptis (Cấp tốc)',
                    'B2 Aptis (Cấp tốc)',
                    'A2 - B1 VEPT (Đào tạo)',
                    'A2 VEPT (Cấp tốc)',
                    'B1 VEPT (Cấp tốc)',
                    'Học Viên An Ninh',
                    'B1 Chứng nhận ĐHNN Huế (Cấp tốc)',
                    'B2 Chứng nhận ĐHNN Huế (Cấp tốc)',
                    'B1 Chứng nhận ĐHNN Huế (Dài hạn)',
                ],
                'Tin học' => ['CNTT Cơ Bản', 'CNTT Nâng Cao'],
                'Tiếng Trung' => ['HSK 1', 'HSK 2', 'HSK 3'],
            ],
            'Đăng ký thi' => [
                'Tin học' => ['CNTT Cơ Bản', 'CNTT Nâng Cao'],
            ],
        ],
        'schedules' => [
            'Đăng ký học' => [
                'Thứ 2,4,6 17h30',
                'Thứ 3,5,7, 17h30',
                'Thứ 2,4,6 19h00',
                'Thứ 3,5,7 19H00',
                'Khác (Vui lòng liên hệ trực tiếp ở fanpage để được hỗ trợ)',
            ],
            'Đăng ký thi' => alpha_edu_get_registration_exam_schedules(),
        ],
        'placeholders' => [
            'program' => '(Chọn chương trình)',
            'course' => '(Chọn khóa đăng ký)',
            'schedule' => '(Chọn lịch học/ lịch thi)',
        ],
    ];
}

function alpha_edu_flatten_registration_options($items) {
    $values = [];

    foreach ((array) $items as $item) {
        if (is_array($item)) {
            $values = array_merge($values, alpha_edu_flatten_registration_options($item));
        } elseif ('' !== trim((string) $item)) {
            $values[] = trim((string) $item);
        }
    }

    return array_values(array_unique($values));
}

function alpha_edu_extend_registration_cf7_select_values($tag, $replace) {
    if (empty($tag['name']) || ! in_array($tag['name'], ['registration-program', 'registration-course', 'registration-schedule'], true)) {
        return $tag;
    }

    $options = alpha_edu_registration_options();
    $extra_values = [];

    if ('registration-program' === $tag['name']) {
        $extra_values = alpha_edu_flatten_registration_options($options['programs'] ?? []);
    } elseif ('registration-course' === $tag['name']) {
        $extra_values = alpha_edu_flatten_registration_options($options['courses'] ?? []);
    } elseif ('registration-schedule' === $tag['name']) {
        $extra_values = alpha_edu_flatten_registration_options($options['schedules'] ?? []);
    }

    foreach ($extra_values as $value) {
        if (! in_array($value, (array) ($tag['values'] ?? []), true)) {
            $tag['raw_values'][] = $value;
            $tag['values'][] = $value;
            $tag['labels'][] = $value;
        }
    }

    return $tag;
}
add_filter('wpcf7_form_tag', 'alpha_edu_extend_registration_cf7_select_values', 10, 2);

function alpha_edu_get_registration_cf7_shortcode($post_id = 0) {
    $shortcode = $post_id ? alpha_edu_get_course_field($post_id, 'course_cf7_shortcode') : '';

    if (! $shortcode) {
        $shortcode = get_option('alpha_registration_cf7_shortcode', '');
    }

    if ($shortcode) {
        return $shortcode;
    }

    if (! post_type_exists('wpcf7_contact_form')) {
        return '';
    }

    $forms = get_posts([
        'post_type'      => 'wpcf7_contact_form',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'orderby'        => 'date',
        'order'          => 'ASC',
    ]);

    if (! $forms) {
        return '';
    }

    $selected = $forms[0];

    foreach ($forms as $form) {
        if (false !== stripos(remove_accents($form->post_title), 'dang ky')) {
            $selected = $form;
            break;
        }
    }

    return sprintf('[contact-form-7 id="%d" title="%s"]', (int) $selected->ID, esc_attr($selected->post_title));
}

function alpha_edu_registration_cf7_form_template() {
    return trim(<<<'CF7'
<label> Họ và tên đệm (*)
    [text* registration-last-name] </label>

<label> Tên (*)
    [text* registration-first-name] </label>

<label> Ngày sinh (*)
    [text* registration-birthday] </label>

<label> Nơi sinh (*)
    [text* registration-birthplace] </label>

<label> Số điện thoại (*)
    [tel* registration-phone] </label>

<label> Email (*)
    [email* registration-email] </label>

<label> Số CCCD (*)
    [text* registration-cccd] </label>

<label> Ngày cấp CCCD (*)
    [text* registration-cccd-date] </label>

<label> Địa chỉ thường trú (*)
    [text* registration-address] </label>

<label> Đơn vị công tác/ Đào tạo (Nếu không có điền "Không có") (*)
    [text* registration-organization] </label>

<label> Hình thức (*)
    [select* registration-type first_as_label "(Chọn hình thức)" "Đăng ký học" "Đăng ký thi"] </label>

<label> Chương trình (*)
    [select* registration-program first_as_label "(Chọn chương trình)" "Tiếng Anh" "Tin học" "Tiếng Trung"] </label>

<label> Khóa đăng ký (*)
    [select* registration-course first_as_label "(Chọn khóa đăng ký)" "CNTT Cơ Bản" "CNTT Nâng Cao"] </label>

<label> Lịch học/ lịch thi (*)
    [select* registration-schedule first_as_label "(Chọn lịch học/ lịch thi)" "Thứ 2,4,6 17h30" "Thứ 3,5,7, 17h30" "Thứ 2,4,6 19h00" "Thứ 3,5,7 19H00" "Khác (Vui lòng liên hệ trực tiếp ở fanpage để được hỗ trợ)"] </label>

<label> Nhân viên hướng dẫn/ hỗ trợ (*)
    [text* registration-supporter] </label>

<label> Ghi chú (*)
    [textarea* registration-note] </label>

[submit "ĐĂNG KÝ NGAY"]
CF7);
}

function alpha_edu_registration_cf7_mail_template() {
    return [
        'subject' => 'Đăng ký mới từ [registration-last-name] [registration-first-name]',
        'sender' => '[_site_title] <wordpress@[_site_domain]>',
        'body' => trim(<<<'MAIL'
Thông tin đăng ký mới:

Họ và tên đệm: [registration-last-name]
Tên: [registration-first-name]
Ngày sinh: [registration-birthday]
Nơi sinh: [registration-birthplace]
Số điện thoại: [registration-phone]
Email: [registration-email]
Số CCCD: [registration-cccd]
Ngày cấp CCCD: [registration-cccd-date]
Địa chỉ thường trú: [registration-address]
Đơn vị công tác/ Đào tạo: [registration-organization]
Hình thức: [registration-type]
Chương trình: [registration-program]
Khóa đăng ký: [registration-course]
Lịch học/ lịch thi: [registration-schedule]
Nhân viên hướng dẫn/ hỗ trợ: [registration-supporter]
Ghi chú:
[registration-note]

--
Gửi từ website [_site_title] - [_site_url]
MAIL),
        'recipient' => '[_site_admin_email]',
        'additional_headers' => 'Reply-To: [registration-email]',
        'attachments' => '',
        'use_html' => 0,
        'exclude_blank' => 0,
    ];
}

function alpha_edu_registration_cf7_messages_template() {
    return [
        'mail_sent_ok' => 'Cảm ơn bạn. Thông tin đăng ký đã được gửi thành công.',
        'mail_sent_ng' => 'Có lỗi khi gửi thông tin. Vui lòng thử lại sau.',
        'validation_error' => 'Có một hoặc nhiều trường chưa đúng. Vui lòng kiểm tra lại.',
        'spam' => 'Có lỗi khi gửi thông tin. Vui lòng thử lại sau.',
        'accept_terms' => 'Vui lòng chấp nhận điều khoản trước khi gửi.',
        'invalid_required' => 'Vui lòng nhập thông tin bắt buộc.',
        'invalid_too_long' => 'Nội dung nhập quá dài.',
        'invalid_too_short' => 'Nội dung nhập quá ngắn.',
        'upload_failed' => 'Không thể tải file lên.',
        'upload_file_type_invalid' => 'Định dạng file không được hỗ trợ.',
        'upload_file_too_large' => 'File tải lên quá lớn.',
        'upload_failed_php_error' => 'Có lỗi khi tải file lên.',
        'invalid_date' => 'Vui lòng nhập ngày hợp lệ.',
        'date_too_early' => 'Ngày nhập quá sớm.',
        'date_too_late' => 'Ngày nhập quá muộn.',
        'invalid_number' => 'Vui lòng nhập số hợp lệ.',
        'number_too_small' => 'Số nhập quá nhỏ.',
        'number_too_large' => 'Số nhập quá lớn.',
        'quiz_answer_not_correct' => 'Câu trả lời chưa chính xác.',
        'captcha_not_match' => 'Mã xác nhận chưa chính xác.',
        'invalid_email' => 'Vui lòng nhập email hợp lệ.',
        'invalid_url' => 'Vui lòng nhập đường dẫn hợp lệ.',
        'invalid_tel' => 'Vui lòng nhập số điện thoại hợp lệ.',
    ];
}

function alpha_edu_ensure_registration_cf7_form() {
    if (! current_user_can('manage_options') || ! function_exists('wpcf7_save_contact_form')) {
        return;
    }

    $template_version = '2026-07-03-3';
    $title = 'Alpha - Form đăng ký học/thi';
    $form_id = (int) get_option('alpha_registration_cf7_form_id', 0);
    $form_post = $form_id ? get_post($form_id) : null;

    if (! $form_post || 'wpcf7_contact_form' !== $form_post->post_type) {
        $existing = get_page_by_title($title, OBJECT, 'wpcf7_contact_form');
        $form_id = $existing ? (int) $existing->ID : -1;
        $form_post = $form_id > 0 ? get_post($form_id) : null;
    }

    if ($form_post && $template_version === get_option('alpha_registration_cf7_template_version')) {
        update_option('alpha_registration_cf7_shortcode', sprintf('[contact-form-7 id="%d" title="%s"]', (int) $form_post->ID, $title));
        return;
    }

    $contact_form = wpcf7_save_contact_form([
        'id' => $form_id ?: -1,
        'title' => $title,
        'locale' => get_locale(),
        'form' => alpha_edu_registration_cf7_form_template(),
        'mail' => alpha_edu_registration_cf7_mail_template(),
        'messages' => alpha_edu_registration_cf7_messages_template(),
        'additional_settings' => '',
    ]);

    if ($contact_form && method_exists($contact_form, 'id')) {
        $new_id = (int) $contact_form->id();
        update_option('alpha_registration_cf7_form_id', $new_id);
        update_option('alpha_registration_cf7_shortcode', sprintf('[contact-form-7 id="%d" title="%s"]', $new_id, $title));
        update_option('alpha_registration_cf7_template_version', $template_version);
    }
}
add_action('admin_init', 'alpha_edu_ensure_registration_cf7_form');

function alpha_edu_render_registration_form($source_course_id = 0, $is_open = false, $show_arrow = true) {
    $shortcode = alpha_edu_get_registration_cf7_shortcode($source_course_id);
    $section_classes = 'alpha-registration-section';

    if ($is_open) {
        $section_classes .= ' is-open';
    }
    ?>
    <section id="course-registration-form" class="<?php echo esc_attr($section_classes); ?>" aria-labelledby="alpha-registration-title">
        <?php if ($show_arrow) : ?>
        <div class="alpha-registration-arrow" aria-hidden="true"></div>
        <?php endif; ?>

        <div class="alpha-registration-form alpha-registration-form-cf7">
            <header class="alpha-registration-header">
                <h2 id="alpha-registration-title"><?php esc_html_e('FORM ĐĂNG KÝ HỌC/ ĐĂNG KÝ THI', 'alpha-edu'); ?></h2>
                <p><?php esc_html_e('Hãy để lại thông tin để Alpha hỗ trợ cho bạn nhé.', 'alpha-edu'); ?></p>
            </header>

            <?php if ($shortcode && shortcode_exists('contact-form-7')) : ?>
                <?php echo do_shortcode($shortcode); ?>
            <?php else : ?>
                <p class="alpha-registration-success"><?php esc_html_e('Vui lòng tạo form Contact Form 7 hoặc nhập shortcode CF7 trong phần Chi tiết khóa học.', 'alpha-edu'); ?></p>
            <?php endif; ?>
        </div>
    </section>
    <?php
}
function alpha_edu_register_registration_settings() {
    register_setting('alpha_registration_settings', 'alpha_registration_cf7_shortcode', [
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    ]);

    register_setting('alpha_registration_settings', 'alpha_registration_exam_schedules', [
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_textarea_field',
        'default'           => '',
    ]);
}
add_action('admin_init', 'alpha_edu_register_registration_settings');

function alpha_edu_register_registration_settings_page() {
    $parent_slug = menu_page_url('wpcf7', false) ? 'wpcf7' : 'options-general.php';

    add_submenu_page(
        $parent_slug,
        __('Cài đặt form đăng ký', 'alpha-edu'),
        __('Cài đặt form đăng ký', 'alpha-edu'),
        'manage_options',
        'alpha-registration-settings',
        'alpha_edu_render_registration_settings_page'
    );
}
add_action('admin_menu', 'alpha_edu_register_registration_settings_page', 20);

function alpha_edu_render_registration_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Cài đặt form đăng ký', 'alpha-edu'); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('alpha_registration_settings'); ?>

            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">
                        <label for="alpha-registration-cf7-shortcode"><?php esc_html_e('Shortcode Contact Form 7 mặc định', 'alpha-edu'); ?></label>
                    </th>
                    <td>
                        <input id="alpha-registration-cf7-shortcode" class="regular-text" type="text" name="alpha_registration_cf7_shortcode" value="<?php echo esc_attr(get_option('alpha_registration_cf7_shortcode', '')); ?>" placeholder='[contact-form-7 id="123" title="Form đăng ký học/thi"]'>
                        <p class="description"><?php esc_html_e('Có thể nhập riêng shortcode trong từng khóa học. Nếu cả hai nơi đều trống, hệ thống tự lấy form CF7 có chữ “đăng ký” hoặc form đầu tiên.', 'alpha-edu'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="alpha-registration-exam-schedules"><?php esc_html_e('Lịch thi dự kiến', 'alpha-edu'); ?></label>
                    </th>
                    <td>
                        <textarea id="alpha-registration-exam-schedules" class="large-text" rows="8" name="alpha_registration_exam_schedules"><?php echo esc_textarea(get_option('alpha_registration_exam_schedules', '')); ?></textarea>
                        <p class="description"><?php esc_html_e('Mỗi dòng là một lịch thi để học viên chọn khi chọn Hình thức = Đăng ký thi.', 'alpha-edu'); ?></p>
                    </td>
                </tr>
            </table>

            <?php submit_button(__('Lưu cài đặt', 'alpha-edu')); ?>
        </form>
    </div>
    <?php
}

function alpha_edu_asset_url($path) {
    return get_template_directory_uri() . '/assets/' . ltrim($path, '/');
}

function alpha_edu_get_home_field($selector, $default = '') {
    if (! function_exists('get_field')) {
        return $default;
    }

    $post_id = get_queried_object_id();

    if (! $post_id) {
        $post_id = get_option('page_on_front');
    }

    $value = get_field($selector, $post_id);

    if ('' === $value || null === $value || false === $value) {
        return $default;
    }

    return $value;
}

function alpha_edu_get_page_field($selector, $post_id = 0, $default = '') {
    if (! function_exists('get_field')) {
        return $default;
    }

    $post_id = $post_id ? absint($post_id) : get_queried_object_id();
    $value = get_field($selector, $post_id);

    if ('' === $value || null === $value || false === $value) {
        return $default;
    }

    if (is_array($value) && isset($value['url'])) {
        return $value['url'];
    }

    return $value;
}

function alpha_edu_get_option_field($selector, $default = '') {
    if (! function_exists('get_field')) {
        return $default;
    }

    $value = get_field($selector, 'option');

    if ('' === $value || null === $value || false === $value) {
        return $default;
    }

    return $value;
}

function alpha_edu_render_footer_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Footer', 'alpha-edu'); ?></h1>
        <?php
        if (function_exists('acf_form')) {
            acf_form([
                'post_id'         => 'option',
                'field_groups'    => ['group_alpha_footer'],
                'form'            => true,
                'submit_value'    => __('Cập nhật Footer', 'alpha-edu'),
                'updated_message' => __('Đã cập nhật Footer.', 'alpha-edu'),
            ]);
        } else {
            echo '<p>' . esc_html__('Vui lòng kích hoạt plugin Advanced Custom Fields.', 'alpha-edu') . '</p>';
        }
        ?>
    </div>
    <?php
}

function alpha_edu_normalize_exam_header($value) {
    $value = remove_accents((string) $value);
    $value = strtolower(trim($value));
    $value = preg_replace('/[^a-z0-9]+/', '_', $value);

    return trim($value, '_');
}

function alpha_edu_match_exam_column($header) {
    $header = alpha_edu_normalize_exam_header($header);
    $columns = [
        'year'     => ['nam', 'year'],
        'course'   => ['khoa_thi', 'khoa', 'dot_thi', 'ky_thi', 'course', 'exam'],
        'cccd'     => ['cccd', 'so_cccd', 'cmnd', 'so_cmnd', 'can_cuoc', 'can_cuoc_cong_dan'],
        'sbd'      => ['sbd', 'so_bao_danh', 'ma_du_thi'],
        'theory'   => ['diem_ly_thuyet', 'ly_thuyet', 'diem_lt', 'lt'],
        'practice' => ['diem_thuc_hanh', 'thuc_hanh', 'diem_th', 'th'],
        'result'   => ['ket_qua_thi', 'ket_qua', 'kq'],
        'note'     => ['ghi_chu', 'note'],
    ];

    foreach ($columns as $key => $aliases) {
        if (in_array($header, $aliases, true)) {
            return $key;
        }
    }

    return '';
}

function alpha_edu_format_exam_score($value) {
    $value = alpha_edu_clean_exam_cell($value);

    if ('' === $value || ! is_numeric($value)) {
        return $value;
    }

    return number_format((float) $value, 2, '.', '');
}

function alpha_edu_clean_exam_cell($value) {
    $value = wp_strip_all_tags((string) $value);
    $value = html_entity_decode($value, ENT_QUOTES, get_bloginfo('charset'));
    $value = preg_replace('/\s+/', ' ', $value);
    $value = trim($value);

    if (preg_match('/^\d+(?:\.\d+)?e[+-]?\d+$/i', $value)) {
        $value = sprintf('%.0F', (float) $value);
    }

    return $value;
}

function alpha_edu_extract_exam_meta_from_rows($rows) {
    $meta = [
        'year'   => '',
        'course' => '',
    ];

    foreach (array_slice($rows, 0, 12) as $row) {
        $line = alpha_edu_clean_exam_cell(implode(' ', array_filter($row, 'strlen')));

        if ('' === $line) {
            continue;
        }

        if ('' === $meta['year'] && preg_match('/\b(20\d{2})\b/', $line, $matches)) {
            $meta['year'] = $matches[1];
        }

        if ('' === $meta['course'] && false !== stripos(remove_accents($line), 'KHOA THI')) {
            $course = preg_replace('/^KẾT QUẢ THI\s+/iu', '', $line);
            $course = preg_replace('/\s+KHÓA THI NGÀY\s+/iu', ' - Khóa ', $course);
            $course = preg_replace('/\s+/', ' ', $course);
            $meta['course'] = trim($course);
        }
    }

    return $meta;
}

function alpha_edu_find_exam_header_index($rows) {
    foreach ($rows as $index => $row) {
        $normalized = array_map('alpha_edu_normalize_exam_header', $row);

        if (in_array('cccd', $normalized, true) || in_array('so_cccd', $normalized, true)) {
            return $index;
        }
    }

    return 0;
}

function alpha_edu_build_exam_column_map($header_row, $subheader_row = []) {
    $column_map = [];

    foreach ($header_row as $index => $header) {
        $subheader = $subheader_row[$index] ?? '';
        $combined = trim($header . ' ' . $subheader);
        $column_key = alpha_edu_match_exam_column($combined);

        if (! $column_key) {
            $column_key = alpha_edu_match_exam_column($header);
        }

        if (! $column_key) {
            $column_key = alpha_edu_match_exam_column($subheader);
        }

        if ($column_key) {
            $column_map[$column_key] = $index;
        }
    }

    return $column_map;
}

function alpha_edu_build_exam_results_from_rows($rows) {
    if (count($rows) < 2) {
        return new WP_Error('alpha_exam_empty', __('File không có dữ liệu.', 'alpha-edu'));
    }

    $rows = array_map(function ($row) {
        return array_map('alpha_edu_clean_exam_cell', $row);
    }, $rows);
    $meta = alpha_edu_extract_exam_meta_from_rows($rows);
    $header_index = alpha_edu_find_exam_header_index($rows);
    $headers = $rows[$header_index] ?? [];
    $subheaders = $rows[$header_index + 1] ?? [];
    $column_map = alpha_edu_build_exam_column_map($headers, $subheaders);

    foreach (['cccd', 'theory', 'practice', 'result'] as $required_key) {
        if (! isset($column_map[$required_key])) {
            return new WP_Error('alpha_exam_missing_column', sprintf(__('Thiếu cột bắt buộc: %s.', 'alpha-edu'), esc_html($required_key)));
        }
    }

    $items = [];

    foreach (array_slice($rows, $header_index + 1) as $row) {
        $year = isset($column_map['year']) ? alpha_edu_clean_exam_cell($row[$column_map['year']] ?? '') : $meta['year'];
        $course = isset($column_map['course']) ? alpha_edu_clean_exam_cell($row[$column_map['course']] ?? '') : $meta['course'];
        $item = [
            'year'     => $year,
            'course'   => $course,
            'cccd'     => alpha_edu_clean_exam_cell($row[$column_map['cccd']] ?? ''),
            'sbd'      => isset($column_map['sbd']) ? alpha_edu_clean_exam_cell($row[$column_map['sbd']] ?? '') : '',
            'theory'   => alpha_edu_format_exam_score($row[$column_map['theory']] ?? ''),
            'practice' => alpha_edu_format_exam_score($row[$column_map['practice']] ?? ''),
            'result'   => alpha_edu_clean_exam_cell($row[$column_map['result']] ?? ''),
            'note'     => isset($column_map['note']) ? alpha_edu_clean_exam_cell($row[$column_map['note']] ?? '') : '',
        ];

        if ('' === $item['year'] || '' === $item['course'] || '' === $item['cccd']) {
            continue;
        }

        $items[] = $item;
    }

    if (! $items) {
        return new WP_Error('alpha_exam_no_valid_rows', __('Không tìm thấy dòng dữ liệu hợp lệ.', 'alpha-edu'));
    }

    return $items;
}

function alpha_edu_parse_exam_csv($file_path) {
    $handle = fopen($file_path, 'r');

    if (! $handle) {
        return new WP_Error('alpha_exam_csv_open', __('Không đọc được file CSV.', 'alpha-edu'));
    }

    $rows = [];

    while (false !== ($row = fgetcsv($handle))) {
        if ($row && isset($row[0])) {
            $row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $row[0]);
        }

        $rows[] = $row;
    }

    fclose($handle);

    return alpha_edu_build_exam_results_from_rows($rows);
}

function alpha_edu_xlsx_text_from_node($node) {
    $text = '';

    foreach ($node->children() as $child) {
        if ('t' === $child->getName()) {
            $text .= (string) $child;
        } else {
            $text .= alpha_edu_xlsx_text_from_node($child);
        }
    }

    return $text;
}

function alpha_edu_xlsx_column_index($cell_ref) {
    $letters = preg_replace('/[^A-Z]/', '', strtoupper($cell_ref));
    $index = 0;

    for ($i = 0, $length = strlen($letters); $i < $length; $i++) {
        $index = ($index * 26) + (ord($letters[$i]) - 64);
    }

    return max(0, $index - 1);
}

function alpha_edu_parse_exam_xlsx($file_path) {
    if (! class_exists('ZipArchive')) {
        return new WP_Error('alpha_exam_zip_missing', __('Máy chủ chưa bật ZipArchive nên chưa đọc được file XLSX. Vui lòng dùng CSV hoặc bật ZipArchive.', 'alpha-edu'));
    }

    $zip = new ZipArchive();

    if (true !== $zip->open($file_path)) {
        return new WP_Error('alpha_exam_xlsx_open', __('Không mở được file XLSX.', 'alpha-edu'));
    }

    $shared_strings = [];
    $shared_xml = $zip->getFromName('xl/sharedStrings.xml');

    if ($shared_xml) {
        $shared = simplexml_load_string($shared_xml);

        if ($shared) {
            foreach ($shared->si as $string_node) {
                $shared_strings[] = alpha_edu_xlsx_text_from_node($string_node);
            }
        }
    }

    $sheet_xml = $zip->getFromName('xl/worksheets/sheet1.xml');
    $zip->close();

    if (! $sheet_xml) {
        return new WP_Error('alpha_exam_xlsx_sheet', __('File XLSX không có sheet đầu tiên.', 'alpha-edu'));
    }

    $sheet = simplexml_load_string($sheet_xml);

    if (! $sheet || ! isset($sheet->sheetData->row)) {
        return new WP_Error('alpha_exam_xlsx_data', __('File XLSX không có dữ liệu.', 'alpha-edu'));
    }

    $rows = [];

    foreach ($sheet->sheetData->row as $row_node) {
        $row = [];

        foreach ($row_node->c as $cell) {
            $attrs = $cell->attributes();
            $index = alpha_edu_xlsx_column_index((string) ($attrs['r'] ?? 'A1'));
            $type = (string) ($attrs['t'] ?? '');
            $value = '';

            if ('s' === $type) {
                $shared_index = absint((string) $cell->v);
                $value = $shared_strings[$shared_index] ?? '';
            } elseif ('inlineStr' === $type && isset($cell->is)) {
                $value = alpha_edu_xlsx_text_from_node($cell->is);
            } elseif (isset($cell->v)) {
                $value = (string) $cell->v;
            }

            $row[$index] = $value;
        }

        if ($row) {
            $normalized_row = [];
            $max_index = max(array_keys($row));

            for ($i = 0; $i <= $max_index; $i++) {
                $normalized_row[$i] = $row[$i] ?? '';
            }

            $rows[] = $normalized_row;
        }
    }

    return alpha_edu_build_exam_results_from_rows($rows);
}

function alpha_edu_get_exam_results_data() {
    $data = get_option('alpha_edu_exam_results_data', []);

    if (! is_array($data)) {
        return [
            'rows'        => [],
            'filename'    => '',
            'imported_at' => '',
        ];
    }

    $data['rows'] = isset($data['rows']) && is_array($data['rows']) ? $data['rows'] : [];
    $data['filename'] = isset($data['filename']) ? (string) $data['filename'] : '';
    $data['imported_at'] = isset($data['imported_at']) ? (string) $data['imported_at'] : '';

    return $data;
}

function alpha_edu_get_exam_years() {
    $data = alpha_edu_get_exam_results_data();
    $years = array_unique(array_filter(wp_list_pluck($data['rows'], 'year')));
    rsort($years, SORT_NATURAL);

    return $years;
}

function alpha_edu_get_exam_courses($year = '') {
    $data = alpha_edu_get_exam_results_data();
    $courses = [];

    foreach ($data['rows'] as $row) {
        if ($year && $year !== $row['year']) {
            continue;
        }

        if (! empty($row['course'])) {
            $courses[] = $row['course'];
        }
    }

    return array_values(array_unique($courses));
}

function alpha_edu_lookup_exam_results($year, $course, $cccd) {
    $data = alpha_edu_get_exam_results_data();
    $cccd = preg_replace('/\D+/', '', (string) $cccd);
    $results = [];

    if ('' === $cccd) {
        return [];
    }

    foreach ($data['rows'] as $row) {
        $row_cccd = preg_replace('/\D+/', '', (string) ($row['cccd'] ?? ''));

        if ($year && $year !== ($row['year'] ?? '')) {
            continue;
        }

        if ($course && $course !== ($row['course'] ?? '')) {
            continue;
        }

        if ($cccd !== $row_cccd) {
            continue;
        }

        $results[] = $row;
    }

    return $results;
}

function alpha_edu_register_exam_results_admin_page() {
    add_menu_page(
        __('Kết quả thi', 'alpha-edu'),
        __('Kết quả thi', 'alpha-edu'),
        'manage_options',
        'alpha-edu-exam-results',
        'alpha_edu_render_exam_results_admin_page',
        'dashicons-welcome-write-blog',
        62
    );
}
add_action('admin_menu', 'alpha_edu_register_exam_results_admin_page');

function alpha_edu_handle_exam_results_upload() {
    if (! current_user_can('manage_options')) {
        wp_die(esc_html__('Bạn không có quyền thực hiện thao tác này.', 'alpha-edu'));
    }

    check_admin_referer('alpha_edu_exam_results_upload');

    if (empty($_FILES['alpha_exam_results_file']['tmp_name'])) {
        wp_safe_redirect(add_query_arg('alpha_exam_status', 'missing', wp_get_referer()));
        exit;
    }

    $file = $_FILES['alpha_exam_results_file'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (! in_array($extension, ['xlsx', 'csv'], true)) {
        wp_safe_redirect(add_query_arg('alpha_exam_status', 'invalid', wp_get_referer()));
        exit;
    }

    $rows = 'csv' === $extension
        ? alpha_edu_parse_exam_csv($file['tmp_name'])
        : alpha_edu_parse_exam_xlsx($file['tmp_name']);

    if (is_wp_error($rows)) {
        set_transient('alpha_edu_exam_results_error', $rows->get_error_message(), 60);
        wp_safe_redirect(add_query_arg('alpha_exam_status', 'error', wp_get_referer()));
        exit;
    }

    update_option('alpha_edu_exam_results_data', [
        'rows'        => $rows,
        'filename'    => sanitize_file_name($file['name']),
        'imported_at' => current_time('mysql'),
    ], false);

    wp_safe_redirect(add_query_arg('alpha_exam_status', 'success', wp_get_referer()));
    exit;
}
add_action('admin_post_alpha_edu_upload_exam_results', 'alpha_edu_handle_exam_results_upload');

function alpha_edu_handle_exam_results_save_rows() {
    if (! current_user_can('manage_options')) {
        wp_die(esc_html__('Bạn không có quyền thực hiện thao tác này.', 'alpha-edu'));
    }

    check_admin_referer('alpha_edu_exam_results_save_rows');

    $rows = isset($_POST['alpha_exam_rows']) && is_array($_POST['alpha_exam_rows'])
        ? wp_unslash($_POST['alpha_exam_rows'])
        : [];
    $data = alpha_edu_get_exam_results_data();
    $clean_rows = $data['rows'];

    foreach ($rows as $index => $row) {
        if (! is_array($row)) {
            continue;
        }

        $item = [
            'year'     => alpha_edu_clean_exam_cell($row['year'] ?? ''),
            'course'   => alpha_edu_clean_exam_cell($row['course'] ?? ''),
            'cccd'     => alpha_edu_clean_exam_cell($row['cccd'] ?? ''),
            'sbd'      => alpha_edu_clean_exam_cell($row['sbd'] ?? ''),
            'theory'   => alpha_edu_format_exam_score($row['theory'] ?? ''),
            'practice' => alpha_edu_format_exam_score($row['practice'] ?? ''),
            'result'   => alpha_edu_clean_exam_cell($row['result'] ?? ''),
            'note'     => alpha_edu_clean_exam_cell($row['note'] ?? ''),
        ];

        if ('' === $item['year'] || '' === $item['course'] || '' === $item['cccd']) {
            unset($clean_rows[$index]);
            continue;
        }

        $clean_rows[$index] = $item;
    }

    $data['rows'] = array_values($clean_rows);
    $data['imported_at'] = current_time('mysql');

    update_option('alpha_edu_exam_results_data', $data, false);

    wp_safe_redirect(add_query_arg('alpha_exam_status', 'saved', wp_get_referer()));
    exit;
}
add_action('admin_post_alpha_edu_save_exam_results_rows', 'alpha_edu_handle_exam_results_save_rows');

function alpha_edu_render_exam_results_admin_page() {
    $data = alpha_edu_get_exam_results_data();
    $status = isset($_GET['alpha_exam_status']) ? sanitize_key(wp_unslash($_GET['alpha_exam_status'])) : '';
    $search = isset($_GET['alpha_exam_search']) ? alpha_edu_clean_exam_cell(wp_unslash($_GET['alpha_exam_search'])) : '';
    $current_page = max(1, isset($_GET['exam_paged']) ? absint(wp_unslash($_GET['exam_paged'])) : 1);
    $per_page = 15;
    $error = get_transient('alpha_edu_exam_results_error');
    $filtered_rows = [];

    foreach ($data['rows'] as $index => $row) {
        $haystack = implode(' ', [
            $row['year'] ?? '',
            $row['course'] ?? '',
            $row['cccd'] ?? '',
            $row['sbd'] ?? '',
            $row['theory'] ?? '',
            $row['practice'] ?? '',
            $row['result'] ?? '',
            $row['note'] ?? '',
        ]);

        if ('' === $search || false !== stripos(remove_accents($haystack), remove_accents($search))) {
            $filtered_rows[$index] = $row;
        }
    }

    $total_rows = count($data['rows']);
    $filtered_total = count($filtered_rows);
    $total_pages = max(1, (int) ceil($filtered_total / $per_page));
    $current_page = min($current_page, $total_pages);
    $paged_rows = array_slice($filtered_rows, ($current_page - 1) * $per_page, $per_page, true);
    $pagination_args = ['page' => 'alpha-edu-exam-results'];

    if ('' !== $search) {
        $pagination_args['alpha_exam_search'] = $search;
    }

    $pagination_base = add_query_arg($pagination_args, admin_url('admin.php'));
    $pagination_links = $total_pages > 1
        ? paginate_links([
            'base'      => add_query_arg('exam_paged', '%#%', $pagination_base),
            'format'    => '',
            'current'   => $current_page,
            'total'     => $total_pages,
            'prev_text' => __('‹ Trước', 'alpha-edu'),
            'next_text' => __('Sau ›', 'alpha-edu'),
        ])
        : '';

    if ($error) {
        delete_transient('alpha_edu_exam_results_error');
    }
    ?>
    <div class="wrap">
        <style>
            .alpha-exam-panel {
                max-width: 100%;
                margin: 18px 0;
                padding: 18px;
                border: 1px solid #dcdcde;
                border-radius: 8px;
                background: #fff;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            }

            .alpha-exam-toolbar {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                align-items: center;
                justify-content: space-between;
                margin: 18px 0 12px;
                padding: 14px;
                border: 1px solid #dbe7fb;
                border-radius: 8px;
                background: #f6f9ff;
            }

            .alpha-exam-search {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                align-items: center;
                margin: 0;
            }

            .alpha-exam-search input[type="search"] {
                width: min(460px, 72vw);
                min-height: 36px;
            }

            .alpha-exam-count {
                margin: 0;
                color: #1d2327;
                font-weight: 600;
            }

            .alpha-exam-pagination {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                align-items: center;
                justify-content: flex-end;
                margin: 12px 0;
            }

            .alpha-exam-pagination .page-numbers {
                display: inline-flex;
                min-width: 34px;
                min-height: 34px;
                align-items: center;
                justify-content: center;
                padding: 0 10px;
                border: 1px solid #c3c4c7;
                border-radius: 6px;
                background: #fff;
                color: #1d2327;
                text-decoration: none;
                font-weight: 600;
            }

            .alpha-exam-pagination .page-numbers.current {
                border-color: #2271b1;
                background: #2271b1;
                color: #fff;
            }

            .alpha-exam-pagination a.page-numbers:hover,
            .alpha-exam-pagination a.page-numbers:focus {
                border-color: #2271b1;
                color: #135e96;
            }
        </style>
        <h1><?php esc_html_e('Quản lý kết quả thi', 'alpha-edu'); ?></h1>

        <?php if ('success' === $status) : ?>
            <div class="notice notice-success is-dismissible"><p><?php esc_html_e('Đã cập nhật dữ liệu kết quả thi.', 'alpha-edu'); ?></p></div>
        <?php elseif ('saved' === $status) : ?>
            <div class="notice notice-success is-dismissible"><p><?php esc_html_e('Đã lưu các dòng kết quả thi.', 'alpha-edu'); ?></p></div>
        <?php elseif ('missing' === $status) : ?>
            <div class="notice notice-error is-dismissible"><p><?php esc_html_e('Vui lòng chọn file để upload.', 'alpha-edu'); ?></p></div>
        <?php elseif ('invalid' === $status) : ?>
            <div class="notice notice-error is-dismissible"><p><?php esc_html_e('Chỉ hỗ trợ file .xlsx hoặc .csv.', 'alpha-edu'); ?></p></div>
        <?php elseif ('error' === $status) : ?>
            <div class="notice notice-error is-dismissible"><p><?php echo esc_html($error ?: __('Không nhập được dữ liệu.', 'alpha-edu')); ?></p></div>
        <?php endif; ?>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" enctype="multipart/form-data" style="max-width:760px;background:#fff;border:1px solid #dcdcde;padding:20px;margin-top:18px;">
            <?php wp_nonce_field('alpha_edu_exam_results_upload'); ?>
            <input type="hidden" name="action" value="alpha_edu_upload_exam_results">

            <h2 style="margin-top:0;"><?php esc_html_e('Upload file điểm', 'alpha-edu'); ?></h2>
            <p><?php esc_html_e('Hỗ trợ file mẫu có tiêu đề khóa thi ở đầu file và bảng gồm CCCD, LT, TH, Kết quả. Nếu file có thêm Năm, Khóa thi, SBD, Ghi chú thì hệ thống cũng tự nhận.', 'alpha-edu'); ?></p>
            <p><input type="file" name="alpha_exam_results_file" accept=".xlsx,.csv" required></p>
            <?php submit_button(__('Cập nhật kết quả thi', 'alpha-edu')); ?>
        </form>

        <h2><?php esc_html_e('Dữ liệu hiện tại', 'alpha-edu'); ?></h2>
        <p>
            <strong><?php esc_html_e('File:', 'alpha-edu'); ?></strong>
            <?php echo esc_html($data['filename'] ?: __('Chưa có dữ liệu', 'alpha-edu')); ?>
            <?php if ($data['imported_at']) : ?>
                <br><strong><?php esc_html_e('Cập nhật:', 'alpha-edu'); ?></strong>
                <?php echo esc_html($data['imported_at']); ?>
            <?php endif; ?>
            <br><strong><?php esc_html_e('Số dòng:', 'alpha-edu'); ?></strong>
            <?php echo esc_html(number_format_i18n($total_rows)); ?>
        </p>

        <?php if (! empty($data['rows'])) : ?>
            <div class="alpha-exam-toolbar">
                <form class="alpha-exam-search" method="get" action="<?php echo esc_url(admin_url('admin.php')); ?>">
                    <input type="hidden" name="page" value="alpha-edu-exam-results">
                    <label for="alpha-exam-search" class="screen-reader-text"><?php esc_html_e('Tìm kiếm kết quả thi', 'alpha-edu'); ?></label>
                    <input id="alpha-exam-search" type="search" name="alpha_exam_search" value="<?php echo esc_attr($search); ?>" placeholder="<?php echo esc_attr__('Tìm theo năm, khóa thi, CCCD, SBD, kết quả...', 'alpha-edu'); ?>">
                    <?php submit_button(__('Tìm kiếm', 'alpha-edu'), 'secondary', '', false); ?>
                    <?php if ('' !== $search) : ?>
                        <a class="button" href="<?php echo esc_url(admin_url('admin.php?page=alpha-edu-exam-results')); ?>"><?php esc_html_e('Xóa tìm kiếm', 'alpha-edu'); ?></a>
                    <?php endif; ?>
                </form>

                <p class="alpha-exam-count">
                    <?php
                    printf(
                        esc_html__('Hiển thị %1$s/%2$s dòng · %3$s dòng/trang', 'alpha-edu'),
                        esc_html(number_format_i18n($filtered_total)),
                        esc_html(number_format_i18n($total_rows)),
                        esc_html(number_format_i18n($per_page))
                    );
                    ?>
                </p>
            </div>

            <?php if ($pagination_links) : ?>
                <nav class="alpha-exam-pagination" aria-label="<?php echo esc_attr__('Phân trang kết quả thi', 'alpha-edu'); ?>">
                    <?php echo wp_kses_post($pagination_links); ?>
                </nav>
            <?php endif; ?>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('alpha_edu_exam_results_save_rows'); ?>
                <input type="hidden" name="action" value="alpha_edu_save_exam_results_rows">

                <div class="alpha-exam-panel" style="overflow:auto;">
                    <table class="widefat striped" style="min-width:1320px;border:0;">
                        <thead>
                            <tr>
                                <th style="width:84px;"><?php esc_html_e('Năm', 'alpha-edu'); ?></th>
                                <th style="width:360px;"><?php esc_html_e('Khóa thi', 'alpha-edu'); ?></th>
                                <th style="width:170px;"><?php esc_html_e('CCCD', 'alpha-edu'); ?></th>
                                <th style="width:160px;"><?php esc_html_e('SBD', 'alpha-edu'); ?></th>
                                <th style="width:120px;"><?php esc_html_e('Lý thuyết', 'alpha-edu'); ?></th>
                                <th style="width:120px;"><?php esc_html_e('Thực hành', 'alpha-edu'); ?></th>
                                <th style="width:140px;"><?php esc_html_e('Kết quả', 'alpha-edu'); ?></th>
                                <th style="width:240px;"><?php esc_html_e('Ghi chú', 'alpha-edu'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paged_rows as $index => $row) : ?>
                                <tr>
                                    <td><input type="text" name="alpha_exam_rows[<?php echo esc_attr($index); ?>][year]" value="<?php echo esc_attr($row['year']); ?>" style="width:100%;"></td>
                                    <td><input type="text" name="alpha_exam_rows[<?php echo esc_attr($index); ?>][course]" value="<?php echo esc_attr($row['course']); ?>" style="width:100%;"></td>
                                    <td><input type="text" name="alpha_exam_rows[<?php echo esc_attr($index); ?>][cccd]" value="<?php echo esc_attr($row['cccd']); ?>" style="width:100%;"></td>
                                    <td><input type="text" name="alpha_exam_rows[<?php echo esc_attr($index); ?>][sbd]" value="<?php echo esc_attr($row['sbd']); ?>" style="width:100%;"></td>
                                    <td><input type="text" name="alpha_exam_rows[<?php echo esc_attr($index); ?>][theory]" value="<?php echo esc_attr($row['theory']); ?>" style="width:100%;"></td>
                                    <td><input type="text" name="alpha_exam_rows[<?php echo esc_attr($index); ?>][practice]" value="<?php echo esc_attr($row['practice']); ?>" style="width:100%;"></td>
                                    <td><input type="text" name="alpha_exam_rows[<?php echo esc_attr($index); ?>][result]" value="<?php echo esc_attr($row['result']); ?>" style="width:100%;"></td>
                                    <td><input type="text" name="alpha_exam_rows[<?php echo esc_attr($index); ?>][note]" value="<?php echo esc_attr($row['note']); ?>" style="width:100%;"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (! $paged_rows) : ?>
                    <p><?php esc_html_e('Không tìm thấy dòng kết quả thi phù hợp.', 'alpha-edu'); ?></p>
                <?php endif; ?>

                <?php submit_button(__('Lưu chỉnh sửa kết quả thi', 'alpha-edu')); ?>
                <p class="description"><?php esc_html_e('Dòng thiếu Năm, Khóa thi hoặc CCCD sẽ không được lưu.', 'alpha-edu'); ?></p>
            </form>

            <?php if ($pagination_links) : ?>
                <nav class="alpha-exam-pagination" aria-label="<?php echo esc_attr__('Phân trang kết quả thi', 'alpha-edu'); ?>">
                    <?php echo wp_kses_post($pagination_links); ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php
}

function alpha_edu_get_documents_data() {
    $documents = get_option('alpha_edu_documents_data', []);

    if (! is_array($documents)) {
        return [];
    }

    return array_values(array_filter(array_map(function ($document) {
        if (! is_array($document)) {
            return null;
        }

        return [
            'title'       => alpha_edu_clean_exam_cell($document['title'] ?? ''),
            'description' => alpha_edu_clean_exam_cell($document['description'] ?? ''),
            'file_id'     => absint($document['file_id'] ?? 0),
            'file_url'    => esc_url_raw($document['file_url'] ?? ''),
        ];
    }, $documents)));
}

function alpha_edu_get_document_download_url($document_index) {
    return add_query_arg(
        [
            'action' => 'alpha_edu_download_document',
            'document' => absint($document_index),
        ],
        admin_url('admin-post.php')
    );
}

function alpha_edu_handle_document_download() {
    $document_index = isset($_GET['document']) ? absint(wp_unslash($_GET['document'])) : 0;
    $documents = alpha_edu_get_documents_data();

    if (! isset($documents[$document_index])) {
        status_header(404);
        wp_die(esc_html__('Không tìm thấy văn bản/Biểu mẫu.', 'alpha-edu'));
    }

    $document = $documents[$document_index];
    $file_id = absint($document['file_id'] ?? 0);
    $file_url = esc_url_raw($document['file_url'] ?? '');

    if (! $file_id && $file_url) {
        $file_id = attachment_url_to_postid($file_url);
    }

    if ($file_id) {
        $file_path = get_attached_file($file_id);

        if ($file_path && file_exists($file_path) && is_readable($file_path)) {
            $filename = basename($file_path);
            $filetype = wp_check_filetype($filename);
            $mime_type = $filetype['type'] ?: 'application/octet-stream';

            while (ob_get_level()) {
                ob_end_clean();
            }

            nocache_headers();
            header('Content-Type: ' . $mime_type);
            header('Content-Disposition: attachment; filename="' . rawurlencode($filename) . '"');
            header('Content-Length: ' . filesize($file_path));
            header('X-Content-Type-Options: nosniff');

            readfile($file_path);
            exit;
        }
    }

    if ($file_url) {
        wp_safe_redirect($file_url);
        exit;
    }

    status_header(404);
    wp_die(esc_html__('File tải xuống không tồn tại.', 'alpha-edu'));
}
add_action('admin_post_alpha_edu_download_document', 'alpha_edu_handle_document_download');
add_action('admin_post_nopriv_alpha_edu_download_document', 'alpha_edu_handle_document_download');

function alpha_edu_register_documents_admin_page() {
    $hook = add_menu_page(
        __('Văn bản/Biểu mẫu', 'alpha-edu'),
        __('Văn bản/Biểu mẫu', 'alpha-edu'),
        'manage_options',
        'alpha-edu-documents',
        'alpha_edu_render_documents_admin_page',
        'dashicons-media-document',
        63
    );

    add_action('admin_enqueue_scripts', function ($hook_suffix) use ($hook) {
        if ($hook_suffix === $hook) {
            wp_enqueue_media();
        }
    });
}
add_action('admin_menu', 'alpha_edu_register_documents_admin_page');

function alpha_edu_handle_documents_save() {
    if (! current_user_can('manage_options')) {
        wp_die(esc_html__('Bạn không có quyền thực hiện thao tác này.', 'alpha-edu'));
    }

    check_admin_referer('alpha_edu_documents_save');

    $documents = isset($_POST['alpha_documents']) && is_array($_POST['alpha_documents'])
        ? wp_unslash($_POST['alpha_documents'])
        : [];
    $clean_documents = [];

    foreach ($documents as $document) {
        if (! is_array($document)) {
            continue;
        }

        $file_id = absint($document['file_id'] ?? 0);
        $file_url = esc_url_raw($document['file_url'] ?? '');
        $title = alpha_edu_clean_exam_cell($document['title'] ?? '');
        $description = alpha_edu_clean_exam_cell($document['description'] ?? '');

        if ($file_id) {
            $attachment_url = wp_get_attachment_url($file_id);

            if ($attachment_url) {
                $file_url = $attachment_url;
            }
        }

        if ('' === $title && $file_id) {
            $title = get_the_title($file_id);
        }

        if ('' === $title && $file_url) {
            $title = basename(parse_url($file_url, PHP_URL_PATH));
        }

        if ('' === $title || '' === $file_url) {
            continue;
        }

        $clean_documents[] = [
            'title'       => $title,
            'description' => $description,
            'file_id'     => $file_id,
            'file_url'    => $file_url,
        ];
    }

    update_option('alpha_edu_documents_data', $clean_documents, false);

    wp_safe_redirect(add_query_arg('alpha_documents_status', 'saved', wp_get_referer()));
    exit;
}
add_action('admin_post_alpha_edu_save_documents', 'alpha_edu_handle_documents_save');

function alpha_edu_render_documents_admin_page() {
    $documents = alpha_edu_get_documents_data();
    $status = isset($_GET['alpha_documents_status']) ? sanitize_key(wp_unslash($_GET['alpha_documents_status'])) : '';
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Quản lý văn bản/Biểu mẫu', 'alpha-edu'); ?></h1>

        <?php if ('saved' === $status) : ?>
            <div class="notice notice-success is-dismissible"><p><?php esc_html_e('Đã lưu danh sách văn bản/Biểu mẫu.', 'alpha-edu'); ?></p></div>
        <?php endif; ?>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <?php wp_nonce_field('alpha_edu_documents_save'); ?>
            <input type="hidden" name="action" value="alpha_edu_save_documents">

            <p><?php esc_html_e('Thêm các file PDF/Word/Excel vào đây, trang Văn bản/Biểu mẫu ngoài website sẽ tự hiển thị danh sách tải xuống.', 'alpha-edu'); ?></p>

            <table class="widefat striped" style="max-width:1200px;" data-alpha-documents-table>
                <thead>
                    <tr>
                        <th style="width:32%;"><?php esc_html_e('Tiêu đề', 'alpha-edu'); ?></th>
                        <th style="width:30%;"><?php esc_html_e('Mô tả', 'alpha-edu'); ?></th>
                        <th><?php esc_html_e('File', 'alpha-edu'); ?></th>
                        <th style="width:90px;"><?php esc_html_e('Xóa', 'alpha-edu'); ?></th>
                    </tr>
                </thead>
                <tbody data-alpha-documents-body>
                    <?php foreach ($documents as $index => $document) : ?>
                        <tr>
                            <td><input type="text" name="alpha_documents[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($document['title']); ?>" style="width:100%;"></td>
                            <td><input type="text" name="alpha_documents[<?php echo esc_attr($index); ?>][description]" value="<?php echo esc_attr($document['description']); ?>" style="width:100%;"></td>
                            <td>
                                <input type="hidden" name="alpha_documents[<?php echo esc_attr($index); ?>][file_id]" value="<?php echo esc_attr($document['file_id']); ?>" data-alpha-document-file-id>
                                <input type="url" name="alpha_documents[<?php echo esc_attr($index); ?>][file_url]" value="<?php echo esc_url($document['file_url']); ?>" style="width:72%;" data-alpha-document-file-url>
                                <button type="button" class="button" data-alpha-document-select><?php esc_html_e('Chọn file', 'alpha-edu'); ?></button>
                            </td>
                            <td><button type="button" class="button-link-delete" data-alpha-document-remove><?php esc_html_e('Xóa', 'alpha-edu'); ?></button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p>
                <button type="button" class="button" data-alpha-document-add><?php esc_html_e('Thêm văn bản/Biểu mẫu', 'alpha-edu'); ?></button>
            </p>

            <?php submit_button(__('Lưu danh sách', 'alpha-edu')); ?>
        </form>

        <script type="text/html" id="tmpl-alpha-document-row">
            <tr>
                <td><input type="text" name="alpha_documents[__INDEX__][title]" value="" style="width:100%;"></td>
                <td><input type="text" name="alpha_documents[__INDEX__][description]" value="" style="width:100%;"></td>
                <td>
                    <input type="hidden" name="alpha_documents[__INDEX__][file_id]" value="" data-alpha-document-file-id>
                    <input type="url" name="alpha_documents[__INDEX__][file_url]" value="" style="width:72%;" data-alpha-document-file-url>
                    <button type="button" class="button" data-alpha-document-select><?php esc_html_e('Chọn file', 'alpha-edu'); ?></button>
                </td>
                <td><button type="button" class="button-link-delete" data-alpha-document-remove><?php esc_html_e('Xóa', 'alpha-edu'); ?></button></td>
            </tr>
        </script>

        <script>
            jQuery(function ($) {
                var body = $('[data-alpha-documents-body]');
                var template = $('#tmpl-alpha-document-row').html();

                $('[data-alpha-document-add]').on('click', function () {
                    var index = Date.now();
                    body.append(template.replace(/__INDEX__/g, index));
                });

                body.on('click', '[data-alpha-document-remove]', function () {
                    $(this).closest('tr').remove();
                });

                body.on('click', '[data-alpha-document-select]', function (event) {
                    event.preventDefault();

                    var row = $(this).closest('tr');
                    var frame = wp.media({
                        title: '<?php echo esc_js(__('Chọn văn bản/Biểu mẫu', 'alpha-edu')); ?>',
                        button: { text: '<?php echo esc_js(__('Dùng file này', 'alpha-edu')); ?>' },
                        multiple: false
                    });

                    frame.on('select', function () {
                        var attachment = frame.state().get('selection').first().toJSON();
                        row.find('[data-alpha-document-file-id]').val(attachment.id || '');
                        row.find('[data-alpha-document-file-url]').val(attachment.url || '');

                        var titleInput = row.find('input[name$="[title]"]');

                        if (!titleInput.val()) {
                            titleInput.val(attachment.title || attachment.filename || '');
                        }
                    });

                    frame.open();
                });
            });
        </script>
    </div>
    <?php
}

function alpha_edu_get_about_field_group_config() {
    return [
        'key' => 'group_alpha_about',
        'title' => __('Nội dung trang Giới thiệu', 'alpha-edu'),
        'fields' => [
            [
                'key' => 'field_alpha_about_hero_tab',
                'label' => __('Banner đầu trang', 'alpha-edu'),
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_alpha_about_hero_title',
                'label' => __('Tiêu đề banner', 'alpha-edu'),
                'name' => 'about_hero_title',
                'type' => 'text',
                'default_value' => 'GIỚI THIỆU',
            ],
            [
                'key' => 'field_alpha_about_hero_image',
                'label' => __('Ảnh banner', 'alpha-edu'),
                'name' => 'about_hero_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_alpha_about_intro_tab',
                'label' => __('Về chúng tôi', 'alpha-edu'),
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_alpha_about_intro_eyebrow',
                'label' => __('Tiêu đề nhỏ', 'alpha-edu'),
                'name' => 'about_intro_eyebrow',
                'type' => 'text',
                'default_value' => 'VỀ CHÚNG TÔI',
            ],
            [
                'key' => 'field_alpha_about_intro_title',
                'label' => __('Tiêu đề chính', 'alpha-edu'),
                'name' => 'about_intro_title',
                'type' => 'text',
                'default_value' => 'TRUNG TÂM NGOẠI NGỮ - TIN HỌC ALPHA',
            ],
            [
                'key' => 'field_alpha_about_intro_content',
                'label' => __('Nội dung giới thiệu', 'alpha-edu'),
                'name' => 'about_intro_content',
                'type' => 'textarea',
                'rows' => 8,
                'new_lines' => '',
            ],
            [
                'key' => 'field_alpha_about_intro_image',
                'label' => __('Ảnh bên dưới phần giới thiệu', 'alpha-edu'),
                'name' => 'about_intro_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_alpha_about_sections_tab',
                'label' => __('Sứ mệnh / Khẩu hiệu / Thành tựu', 'alpha-edu'),
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_alpha_about_mission_title',
                'label' => __('Tiêu đề Sứ mệnh', 'alpha-edu'),
                'name' => 'about_mission_title',
                'type' => 'text',
                'default_value' => 'SỨ MỆNH',
            ],
            [
                'key' => 'field_alpha_about_mission_content',
                'label' => __('Nội dung Sứ mệnh', 'alpha-edu'),
                'name' => 'about_mission_content',
                'type' => 'textarea',
                'rows' => 5,
                'new_lines' => '',
            ],
            [
                'key' => 'field_alpha_about_slogan_title',
                'label' => __('Tiêu đề Khẩu hiệu', 'alpha-edu'),
                'name' => 'about_slogan_title',
                'type' => 'text',
                'default_value' => 'KHẨU HIỆU',
            ],
            [
                'key' => 'field_alpha_about_slogan_content',
                'label' => __('Nội dung Khẩu hiệu', 'alpha-edu'),
                'name' => 'about_slogan_content',
                'type' => 'textarea',
                'rows' => 4,
                'new_lines' => '',
            ],
            [
                'key' => 'field_alpha_about_achievement_title',
                'label' => __('Tiêu đề Thành tựu', 'alpha-edu'),
                'name' => 'about_achievement_title',
                'type' => 'text',
                'default_value' => 'THÀNH TỰU',
            ],
            [
                'key' => 'field_alpha_about_achievement_content',
                'label' => __('Nội dung Thành tựu', 'alpha-edu'),
                'name' => 'about_achievement_content',
                'type' => 'textarea',
                'rows' => 4,
                'new_lines' => '',
            ],
            [
                'key' => 'field_alpha_about_stats_tab',
                'label' => __('Thông tin nổi bật', 'alpha-edu'),
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_alpha_about_stats_title',
                'label' => __('Tiêu đề thống kê', 'alpha-edu'),
                'name' => 'about_stats_title',
                'type' => 'text',
                'default_value' => 'THÔNG TIN NỔI BẬT',
            ],
            [
                'key' => 'field_alpha_about_stats_background',
                'label' => __('Ảnh nền thống kê', 'alpha-edu'),
                'name' => 'about_stats_background',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
            ],
            [
                'key' => 'field_alpha_about_stat_1_number',
                'label' => __('Số liệu 1', 'alpha-edu'),
                'name' => 'about_stat_1_number',
                'type' => 'text',
                'default_value' => '5+',
            ],
            [
                'key' => 'field_alpha_about_stat_1_label',
                'label' => __('Nhãn 1', 'alpha-edu'),
                'name' => 'about_stat_1_label',
                'type' => 'text',
                'default_value' => 'NĂM THÀNH LẬP',
            ],
            [
                'key' => 'field_alpha_about_stat_2_number',
                'label' => __('Số liệu 2', 'alpha-edu'),
                'name' => 'about_stat_2_number',
                'type' => 'text',
                'default_value' => '2000+',
            ],
            [
                'key' => 'field_alpha_about_stat_2_label',
                'label' => __('Nhãn 2', 'alpha-edu'),
                'name' => 'about_stat_2_label',
                'type' => 'text',
                'default_value' => 'HỌC VIÊN',
            ],
            [
                'key' => 'field_alpha_about_stat_3_number',
                'label' => __('Số liệu 3', 'alpha-edu'),
                'name' => 'about_stat_3_number',
                'type' => 'text',
                'default_value' => '300+',
            ],
            [
                'key' => 'field_alpha_about_stat_3_label',
                'label' => __('Nhãn 3', 'alpha-edu'),
                'name' => 'about_stat_3_label',
                'type' => 'text',
                'default_value' => 'KHÓA HỌC',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-templates/template-about.php',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ];
}

function alpha_edu_seed_about_acf_field_group() {
    if (! function_exists('acf_import_field_group')) {
        return;
    }

    $existing_groups = get_posts([
        'post_type'        => 'acf-field-group',
        'post_status'      => 'any',
        'name'             => 'group_alpha_about',
        'posts_per_page'   => 1,
        'fields'           => 'ids',
        'suppress_filters' => true,
    ]);

    if ($existing_groups) {
        return;
    }

    acf_import_field_group(alpha_edu_get_about_field_group_config());
}
add_action('acf/init', 'alpha_edu_seed_about_acf_field_group');
