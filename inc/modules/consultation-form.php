<?php
/**
 * Module: Courses Showcase Assets & Consultation Registration Form (CPT + REST/AJAX)
 * Scope: M4 — [hpo_courses], [hpo_course_info], [hpo_consultation_form]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 1. Enqueue M4 module CSS & deferred JS via M1's `hpo_enqueue_module_assets` hook.
 */
function hpo_enqueue_courses_form_assets() {
    $css_rel = '/assets/css/hpo-courses-form.css';
    $js_rel  = '/assets/js/hpo-courses-form.js';

    if ( file_exists( HPO_THEME_DIR . $css_rel ) ) {
        wp_enqueue_style(
            'hpo-courses-form',
            HPO_THEME_URI . $css_rel,
            array( 'hpo-elements' ),
            function_exists( 'hpo_asset_version' ) ? hpo_asset_version( $css_rel ) : HPO_VERSION
        );
    }

    if ( file_exists( HPO_THEME_DIR . $js_rel ) ) {
        wp_enqueue_script(
            'hpo-courses-form-js',
            HPO_THEME_URI . $js_rel,
            array(),
            function_exists( 'hpo_asset_version' ) ? hpo_asset_version( $js_rel ) : HPO_VERSION,
            array(
                'in_footer' => true,
                'strategy'  => 'defer',
            )
        );

        wp_localize_script(
            'hpo-courses-form-js',
            'hpoCoursesFormConfig',
            array(
                'restUrl'            => esc_url_raw( rest_url( 'hpo/v1/consultation' ) ),
                'ajaxUrl'            => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
                'ajaxAction'         => 'hpo_consultation',
                'nonce'              => wp_create_nonce( 'wp_rest' ),
                'assetsBaseUrl'      => esc_url_raw( trailingslashit( HPO_THEME_URI . '/assets/images/courses-demo' ) ),
                'coursesVehiclesUrl' => esc_url_raw( trailingslashit( HPO_THEME_URI . '/assets/images/courses-demo/vehicles' ) ),
                'locationsBaseUrl'   => esc_url_raw( trailingslashit( HPO_THEME_URI . '/assets/data/locations' ) ),
                'hotline'            => '028.36.362.362',
                'hotlineTel'         => 'tel:02836362362',
            )
        );
    }
}
add_action( 'hpo_enqueue_module_assets', 'hpo_enqueue_courses_form_assets' );

/**
 * 1b. Add `has-uu-reg` body class on pages displaying the consultation form (CSS also works without it).
 */
function hpo_consultation_body_class( $classes ) {
    global $post;
    $has_form = is_front_page() || is_home();
    if ( ! $has_form && is_singular() && $post instanceof WP_Post ) {
        if ( has_shortcode( $post->post_content, 'hpo_consultation_form' ) || false !== strpos( $post->post_content, 'hpo_consultation_form' ) ) {
            $has_form = true;
        }
    }
    if ( $has_form && ! in_array( 'has-uu-reg', $classes, true ) ) {
        $classes[] = 'has-uu-reg';
    }
    return $classes;
}
add_filter( 'body_class', 'hpo_consultation_body_class' );

/**
 * 2. Helper Maps: Lead Statuses & Allowed Course Options
 */
function hpo_get_registration_statuses() {
    return array(
        'new'         => 'Mới',
        'contacted'   => 'Đã liên hệ',
        'enrolled'    => 'Đã đăng ký',
        'unreachable' => 'Không liên hệ được',
    );
}

function hpo_get_allowed_consultation_courses() {
    $courses = array(
        'Hạng B - Số tự động',
        'Hạng B - Số cơ khí',
        'Hạng C1 - Xe tải',
        'Chưa xác định',
    );
    return apply_filters( 'hpo_consultation_allowed_courses', $courses );
}

/**
 * 3. Register Private CPT: `hpo_registration`
 */
function hpo_register_consultation_cpt() {
    $labels = array(
        'name'               => 'Đăng ký tư vấn',
        'singular_name'      => 'Đăng ký tư vấn',
        'menu_name'          => 'Đăng ký tư vấn',
        'all_items'          => 'Tất cả đăng ký',
        'add_new'            => 'Thêm mới',
        'add_new_item'       => 'Thêm đăng ký mới',
        'edit_item'          => 'Chi tiết đăng ký tư vấn',
        'new_item'           => 'Đăng ký mới',
        'view_item'          => 'Xem đăng ký',
        'search_items'       => 'Tìm theo tên hoặc SĐT',
        'not_found'          => 'Chưa có lượt đăng ký tư vấn nào.',
        'not_found_in_trash' => 'Không có đăng ký nào trong thùng rác.',
    );

    register_post_type(
        'hpo_registration',
        array(
            'labels'              => $labels,
            'public'              => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'show_in_rest'        => false, // Protect lead PII from /wp/v2 REST
            'has_archive'         => false,
            'rewrite'             => false,
            'query_var'           => false,
            'menu_position'       => 26,
            'menu_icon'           => 'dashicons-forms',
            'supports'            => array( 'title' ),
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
        )
    );
}
add_action( 'init', 'hpo_register_consultation_cpt' );

/**
 * 4. Admin List Columns, Sorting & Status Filter
 */
function hpo_registration_columns( $columns ) {
    return array(
        'cb'         => isset( $columns['cb'] ) ? $columns['cb'] : '<input type="checkbox" />',
        'hpo_name'   => 'Họ tên',
        'hpo_phone'  => 'Số điện thoại',
        'hpo_course' => 'Hạng đào tạo',
        'hpo_area'   => 'Xã / Khu vực',
        'hpo_source' => 'Nguồn trang',
        'hpo_date'   => 'Ngày đăng ký',
        'hpo_status' => 'Trạng thái',
    );
}
add_filter( 'manage_hpo_registration_posts_columns', 'hpo_registration_columns' );

function hpo_registration_primary_column( $default, $screen ) {
    if ( 'edit-hpo_registration' === $screen ) {
        return 'hpo_name';
    }
    return $default;
}
add_filter( 'list_table_primary_column', 'hpo_registration_primary_column', 10, 2 );

function hpo_registration_custom_column( $column, $post_id ) {
    switch ( $column ) {
        case 'hpo_name':
            $name = get_post_meta( $post_id, '_hpo_reg_name', true );
            if ( '' === (string) $name ) {
                $name = get_the_title( $post_id );
            }
            $edit_link = get_edit_post_link( $post_id );
            if ( $edit_link ) {
                printf(
                    '<strong><a class="row-title" href="%s">%s</a></strong>',
                    esc_url( $edit_link ),
                    esc_html( $name )
                );
            } else {
                echo '<strong>' . esc_html( $name ) . '</strong>';
            }
            break;

        case 'hpo_phone':
            $phone = (string) get_post_meta( $post_id, '_hpo_reg_phone', true );
            if ( '' !== $phone ) {
                printf(
                    '<a href="%s">%s</a>',
                    esc_attr( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ),
                    esc_html( $phone )
                );
            } else {
                echo '—';
            }
            break;

        case 'hpo_course':
            $course = (string) get_post_meta( $post_id, '_hpo_reg_course', true );
            echo '' !== $course ? esc_html( $course ) : '—';
            break;

        case 'hpo_area':
            $area = (string) get_post_meta( $post_id, '_hpo_reg_area', true );
            echo '' !== $area ? esc_html( $area ) : '—';
            break;

        case 'hpo_source':
            $source = (string) get_post_meta( $post_id, '_hpo_reg_source_url', true );
            if ( '' !== $source ) {
                $label = wp_parse_url( $source, PHP_URL_PATH );
                $query = wp_parse_url( $source, PHP_URL_QUERY );
                $short = ( $label ? $label : '/' ) . ( $query ? '?' . $query : '' );
                printf(
                    '<a href="%s" target="_blank" rel="noopener noreferrer" title="%s">%s</a>',
                    esc_url( $source ),
                    esc_attr( $source ),
                    esc_html( function_exists( 'hpo_truncate_text' ) ? hpo_truncate_text( $short, 42 ) : $short )
                );
            } else {
                echo '—';
            }
            break;

        case 'hpo_date':
            echo esc_html( get_the_date( 'd/m/Y H:i', $post_id ) );
            break;

        case 'hpo_status':
            $statuses = hpo_get_registration_statuses();
            $status   = (string) get_post_meta( $post_id, '_hpo_reg_status', true );
            if ( ! isset( $statuses[ $status ] ) ) {
                $status = 'new';
            }
            $colors = array(
                'new'         => 'background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;',
                'contacted'   => 'background:#fffbeb;color:#92400e;border:1px solid #fde68a;',
                'enrolled'    => 'background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;',
                'unreachable' => 'background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;',
            );
            $style = isset( $colors[ $status ] ) ? $colors[ $status ] : $colors['new'];
            printf(
                '<span style="display:inline-block;padding:2px 8px;border-radius:999px;font-size:12px;font-weight:600;%s">%s</span>',
                esc_attr( $style ),
                esc_html( $statuses[ $status ] )
            );
            break;
    }
}
add_action( 'manage_hpo_registration_posts_custom_column', 'hpo_registration_custom_column', 10, 2 );

function hpo_registration_sortable_columns( $columns ) {
    $columns['hpo_date']   = 'date';
    $columns['hpo_status'] = 'hpo_status';
    $columns['hpo_course'] = 'hpo_course';
    $columns['hpo_area']   = 'hpo_area';
    return $columns;
}
add_filter( 'manage_edit-hpo_registration_sortable_columns', 'hpo_registration_sortable_columns' );

function hpo_registration_admin_query( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( 'hpo_registration' !== $query->get( 'post_type' ) ) {
        return;
    }

    $orderby  = $query->get( 'orderby' );
    $meta_map = array(
        'hpo_status' => '_hpo_reg_status',
        'hpo_course' => '_hpo_reg_course',
        'hpo_area'   => '_hpo_reg_area',
    );
    if ( isset( $meta_map[ $orderby ] ) ) {
        $query->set( 'meta_key', $meta_map[ $orderby ] );
        $query->set( 'orderby', 'meta_value' );
    }

    if ( ! empty( $_GET['hpo_reg_status_filter'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $filter_status = sanitize_key( wp_unslash( $_GET['hpo_reg_status_filter'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $statuses      = hpo_get_registration_statuses();
        if ( isset( $statuses[ $filter_status ] ) ) {
            $query->set(
                'meta_query',
                array(
                    array(
                        'key'   => '_hpo_reg_status',
                        'value' => $filter_status,
                    ),
                )
            );
        }
    }
}
add_action( 'pre_get_posts', 'hpo_registration_admin_query' );

function hpo_registration_status_filter_dropdown( $post_type ) {
    if ( 'hpo_registration' !== $post_type ) {
        return;
    }
    $current  = isset( $_GET['hpo_reg_status_filter'] ) ? sanitize_key( wp_unslash( $_GET['hpo_reg_status_filter'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $statuses = hpo_get_registration_statuses();
    echo '<select name="hpo_reg_status_filter">';
    echo '<option value="">Tất cả trạng thái</option>';
    foreach ( $statuses as $key => $label ) {
        printf(
            '<option value="%s"%s>%s</option>',
            esc_attr( $key ),
            selected( $current, $key, false ),
            esc_html( $label )
        );
    }
    echo '</select>';
}
add_action( 'restrict_manage_posts', 'hpo_registration_status_filter_dropdown' );

/**
 * 5. Admin Meta Box (Lead Details & Status Update)
 */
function hpo_registration_add_meta_boxes() {
    add_meta_box(
        'hpo_registration_details',
        'Thông tin đăng ký tư vấn',
        'hpo_registration_render_meta_box',
        'hpo_registration',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes_hpo_registration', 'hpo_registration_add_meta_boxes' );

function hpo_registration_render_meta_box( $post ) {
    wp_nonce_field( 'hpo_save_registration_meta', 'hpo_reg_meta_nonce' );

    $name      = (string) get_post_meta( $post->ID, '_hpo_reg_name', true );
    $phone     = (string) get_post_meta( $post->ID, '_hpo_reg_phone', true );
    $course    = (string) get_post_meta( $post->ID, '_hpo_reg_course', true );
    $area      = (string) get_post_meta( $post->ID, '_hpo_reg_area', true );
    $source    = (string) get_post_meta( $post->ID, '_hpo_reg_source_url', true );
    $submitted = (string) get_post_meta( $post->ID, '_hpo_reg_submitted_at', true );
    $ip        = (string) get_post_meta( $post->ID, '_hpo_reg_ip', true );
    $status    = (string) get_post_meta( $post->ID, '_hpo_reg_status', true );
    $notes     = (string) get_post_meta( $post->ID, '_hpo_reg_notes', true );

    $statuses = hpo_get_registration_statuses();
    if ( ! isset( $statuses[ $status ] ) ) {
        $status = 'new';
    }
    ?>
    <table class="form-table" role="presentation">
        <tr>
            <th><label for="hpo_reg_name">Họ và tên</label></th>
            <td><input type="text" id="hpo_reg_name" name="hpo_reg_name" value="<?php echo esc_attr( $name ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="hpo_reg_phone">Số điện thoại</label></th>
            <td><input type="text" id="hpo_reg_phone" name="hpo_reg_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="hpo_reg_course">Hạng đào tạo quan tâm</label></th>
            <td><input type="text" id="hpo_reg_course" name="hpo_reg_course" value="<?php echo esc_attr( $course ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="hpo_reg_area">Xã / Khu vực</label></th>
            <td><input type="text" id="hpo_reg_area" name="hpo_reg_area" value="<?php echo esc_attr( $area ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th>Nguồn trang</th>
            <td>
                <?php if ( '' !== $source ) : ?>
                    <a href="<?php echo esc_url( $source ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $source ); ?></a>
                <?php else : ?>
                    <span>—</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Thời gian / IP</th>
            <td><code><?php echo esc_html( $submitted ? $submitted : get_the_date( 'Y-m-d H:i:s', $post ) ); ?></code><?php echo $ip ? ' &middot; IP: <code>' . esc_html( $ip ) . '</code>' : ''; ?></td>
        </tr>
        <tr>
            <th><label for="hpo_reg_status">Trạng thái xử lý</label></th>
            <td>
                <select id="hpo_reg_status" name="hpo_reg_status">
                    <?php foreach ( $statuses as $key => $label ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $status, $key ); ?>><?php echo esc_html( $label ); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="hpo_reg_notes">Ghi chú tuyển sinh</label></th>
            <td><textarea id="hpo_reg_notes" name="hpo_reg_notes" rows="4" class="large-text"><?php echo esc_textarea( $notes ); ?></textarea></td>
        </tr>
    </table>
    <?php
}

function hpo_registration_save_meta_box( $post_id ) {
    if ( ! isset( $_POST['hpo_reg_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hpo_reg_meta_nonce'] ) ), 'hpo_save_registration_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $statuses = hpo_get_registration_statuses();
    if ( isset( $_POST['hpo_reg_status'] ) ) {
        $new_status = sanitize_key( wp_unslash( $_POST['hpo_reg_status'] ) );
        if ( isset( $statuses[ $new_status ] ) ) {
            update_post_meta( $post_id, '_hpo_reg_status', $new_status );
        }
    }

    if ( isset( $_POST['hpo_reg_notes'] ) ) {
        update_post_meta( $post_id, '_hpo_reg_notes', sanitize_textarea_field( wp_unslash( $_POST['hpo_reg_notes'] ) ) );
    }

    $old_name  = (string) get_post_meta( $post_id, '_hpo_reg_name', true );
    $old_phone = (string) get_post_meta( $post_id, '_hpo_reg_phone', true );

    $text_fields = array(
        'hpo_reg_name'   => '_hpo_reg_name',
        'hpo_reg_phone'  => '_hpo_reg_phone',
        'hpo_reg_course' => '_hpo_reg_course',
        'hpo_reg_area'   => '_hpo_reg_area',
    );
    foreach ( $text_fields as $post_key => $meta_key ) {
        if ( isset( $_POST[ $post_key ] ) ) {
            update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $post_key ] ) ) );
        }
    }

    $new_name  = (string) get_post_meta( $post_id, '_hpo_reg_name', true );
    $new_phone = (string) get_post_meta( $post_id, '_hpo_reg_phone', true );
    if ( ( $new_name !== $old_name || $new_phone !== $old_phone || '' !== $new_name || '' !== $new_phone )
        && ( '' !== $new_name || '' !== $new_phone ) ) {
        if ( '' !== $new_name && '' !== $new_phone ) {
            $synced_title = sprintf( '%s — %s', $new_name, $new_phone );
        } else {
            $synced_title = '' !== $new_name ? $new_name : $new_phone;
        }
        if ( get_post_field( 'post_title', $post_id ) !== $synced_title ) {
            remove_action( 'save_post_hpo_registration', 'hpo_registration_save_meta_box' );
            wp_update_post(
                wp_slash(
                    array(
                        'ID'         => $post_id,
                        'post_title' => $synced_title,
                    )
                )
            );
            add_action( 'save_post_hpo_registration', 'hpo_registration_save_meta_box' );
        }
    }
}
add_action( 'save_post_hpo_registration', 'hpo_registration_save_meta_box' );

/**
 * 6. Validation, Normalization & Submission Processing
 */
function hpo_normalize_vn_phone( $raw_phone ) {
    if ( ! is_scalar( $raw_phone ) ) {
        return '';
    }
    $digits = preg_replace( '/[\s.\-()]+/', '', (string) $raw_phone );
    if ( null === $digits ) {
        return '';
    }
    if ( 0 === strpos( $digits, '+84' ) ) {
        $digits = '0' . substr( $digits, 3 );
    } elseif ( 0 === strpos( $digits, '84' ) && in_array( strlen( $digits ), array( 11, 12 ), true ) ) {
        $digits = '0' . substr( $digits, 2 );
    }
    return preg_match( '/^0[1-9]\d{8,9}$/', $digits ) ? $digits : '';
}

function hpo_process_consultation_submission( array $payload ) {
    // Optional nonce verification (disabled by default for cached public pages & direct REST tests)
    if ( apply_filters( 'hpo_consultation_enforce_nonce', false ) ) {
        $nonce = ( isset( $payload['nonce'] ) && is_scalar( $payload['nonce'] ) )
            ? sanitize_text_field( (string) $payload['nonce'] )
            : '';
        if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
            return array(
                'status' => 403,
                'body'   => array(
                    'ok'      => false,
                    'field'   => '',
                    'message' => 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang và thử lại.',
                ),
            );
        }
    }

    // 1. Honeypot check: silent 200 without DB insert
    $honeypot = ( isset( $payload['website'] ) && is_scalar( $payload['website'] ) )
        ? trim( (string) $payload['website'] )
        : '';
    if ( '' !== $honeypot ) {
        return array(
            'status' => 200,
            'body'   => array(
                'ok'      => true,
                'message' => 'Đã nhận đăng ký. Cảm ơn bạn!',
            ),
        );
    }

    // 2. Sanitize & validate inputs
    if ( isset( $payload['hoTen'] ) && ! is_scalar( $payload['hoTen'] ) ) {
        return array(
            'status' => 422,
            'body'   => array(
                'ok'      => false,
                'field'   => 'hoTen',
                'message' => 'Vui lòng nhập họ và tên.',
            ),
        );
    }
    $ho_ten = isset( $payload['hoTen'] ) ? sanitize_text_field( (string) $payload['hoTen'] ) : '';
    $ho_ten = trim( $ho_ten );
    if ( mb_strlen( $ho_ten, 'UTF-8' ) > 80 ) {
        $ho_ten = mb_substr( $ho_ten, 0, 80, 'UTF-8' );
    }
    if ( mb_strlen( $ho_ten, 'UTF-8' ) < 2 ) {
        return array(
            'status' => 422,
            'body'   => array(
                'ok'      => false,
                'field'   => 'hoTen',
                'message' => 'Vui lòng nhập họ và tên.',
            ),
        );
    }

    if ( isset( $payload['soDienThoai'] ) && ! is_scalar( $payload['soDienThoai'] ) ) {
        return array(
            'status' => 422,
            'body'   => array(
                'ok'      => false,
                'field'   => 'soDienThoai',
                'message' => 'Số điện thoại chưa đúng (10–11 số, bắt đầu bằng 0).',
            ),
        );
    }
    $raw_phone = isset( $payload['soDienThoai'] ) ? sanitize_text_field( (string) $payload['soDienThoai'] ) : '';
    $phone     = hpo_normalize_vn_phone( $raw_phone );
    if ( '' === $phone ) {
        return array(
            'status' => 422,
            'body'   => array(
                'ok'      => false,
                'field'   => 'soDienThoai',
                'message' => 'Số điện thoại chưa đúng (10–11 số, bắt đầu bằng 0).',
            ),
        );
    }

    if ( isset( $payload['hangDaoTao'] ) && ! is_scalar( $payload['hangDaoTao'] ) ) {
        return array(
            'status' => 422,
            'body'   => array(
                'ok'      => false,
                'field'   => 'hangDaoTao',
                'message' => 'Vui lòng chọn hạng đào tạo.',
            ),
        );
    }
    $hang            = isset( $payload['hangDaoTao'] ) ? sanitize_text_field( (string) $payload['hangDaoTao'] ) : '';
    $hang            = trim( $hang );
    $allowed_courses = hpo_get_allowed_consultation_courses();
    $strict_courses  = apply_filters( 'hpo_consultation_strict_course_check', true );
    if ( '' === $hang || ( $strict_courses && ! in_array( $hang, $allowed_courses, true ) ) ) {
        return array(
            'status' => 422,
            'body'   => array(
                'ok'      => false,
                'field'   => 'hangDaoTao',
                'message' => 'Vui lòng chọn hạng đào tạo.',
            ),
        );
    }

    $xa = ( isset( $payload['xa'] ) && is_scalar( $payload['xa'] ) )
        ? sanitize_text_field( (string) $payload['xa'] )
        : '';
    $xa = mb_substr( trim( $xa ), 0, 80, 'UTF-8' );

    $trang = ( isset( $payload['trang'] ) && is_scalar( $payload['trang'] ) )
        ? esc_url_raw( trim( (string) $payload['trang'] ) )
        : '';
    if ( '' === $trang ) {
        $trang = wp_get_referer() ? esc_url_raw( wp_get_referer() ) : home_url( '/' );
    }
    $trang = substr( $trang, 0, 300 );

    $client_ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

    // 3. Persist as private `hpo_registration` post
    $post_id = wp_insert_post(
        wp_slash(
            array(
                'post_type'   => 'hpo_registration',
                'post_status' => 'publish',
                'post_title'  => sprintf( '%s — %s', $ho_ten, $phone ),
            )
        ),
        true
    );

    if ( is_wp_error( $post_id ) || ! $post_id ) {
        return array(
            'status' => 500,
            'body'   => array(
                'ok'      => false,
                'field'   => '',
                'message' => 'Chưa lưu được đăng ký. Vui lòng thử lại hoặc gọi tổng đài 028.36.362.362.',
            ),
        );
    }

    $submitted_at = current_time( 'mysql' );
    update_post_meta( $post_id, '_hpo_reg_name', wp_slash( $ho_ten ) );
    update_post_meta( $post_id, '_hpo_reg_phone', $phone );
    update_post_meta( $post_id, '_hpo_reg_course', wp_slash( $hang ) );
    update_post_meta( $post_id, '_hpo_reg_area', wp_slash( $xa ) );
    update_post_meta( $post_id, '_hpo_reg_source_url', $trang );
    update_post_meta( $post_id, '_hpo_reg_status', 'new' );
    update_post_meta( $post_id, '_hpo_reg_submitted_at', $submitted_at );
    update_post_meta( $post_id, '_hpo_reg_ip', $client_ip );

    // 4. Optional admin email notification (never fails the submission if mail server is offline)
    $notify_to = apply_filters( 'hpo_consultation_notify_email', get_option( 'hpo_consultation_notify_email', get_option( 'admin_email' ) ), $post_id );
    if ( is_string( $notify_to ) && is_email( $notify_to ) ) {
        $subject = sprintf( '[HPO] Đăng ký tư vấn mới: %s (%s)', $ho_ten, $hang );
        $body    = implode(
            "\n",
            array(
                'Có đăng ký tư vấn mới từ website HPO:',
                '- Họ và tên: ' . $ho_ten,
                '- Số điện thoại: ' . $phone,
                '- Hạng đào tạo: ' . $hang,
                '- Xã / Khu vực: ' . ( '' !== $xa ? $xa : '(Không có)' ),
                '- Nguồn trang: ' . $trang,
                '- Thời gian: ' . $submitted_at,
                '- Quản lý trong WP Admin: ' . admin_url( 'post.php?post=' . $post_id . '&action=edit' ),
            )
        );
        @wp_mail( $notify_to, $subject, $body ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
    }

    // 5. Optional non-blocking Google Sheet webhook (disabled unless option/filter explicitly configured)
    $webhook_url = apply_filters( 'hpo_consultation_webhook_url', get_option( 'hpo_consultation_webhook_url', '' ), $post_id );
    if ( is_string( $webhook_url ) && '' !== trim( $webhook_url ) && 0 === strpos( trim( $webhook_url ), 'https://' ) ) {
        wp_remote_post(
            esc_url_raw( trim( $webhook_url ) ),
            array(
                'timeout'  => 5,
                'blocking' => false,
                'body'     => array(
                    'hoTen'       => $ho_ten,
                    'soDienThoai' => $phone,
                    'hangDaoTao'  => $hang,
                    'xa'          => $xa,
                    'trang'       => $trang,
                ),
            )
        );
    }

    do_action( 'hpo_consultation_submitted', $post_id, $payload );

    return array(
        'status' => 200,
        'body'   => array(
            'ok'      => true,
            'id'      => (int) $post_id,
            'message' => sprintf(
                'Đã nhận đăng ký của %s. Nhân viên tuyển sinh Hiệp Phát sẽ gọi lại cho bạn sớm.',
                $ho_ten
            ),
        ),
    );
}

/**
 * 7. REST API Endpoint: POST /wp-json/hpo/v1/consultation
 */
function hpo_register_consultation_rest_route() {
    register_rest_route(
        'hpo/v1',
        '/consultation',
        array(
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => 'hpo_handle_consultation_rest',
            'permission_callback' => '__return_true',
        )
    );
}
add_action( 'rest_api_init', 'hpo_register_consultation_rest_route' );

function hpo_handle_consultation_rest( WP_REST_Request $request ) {
    $json   = $request->get_json_params();
    $params = is_array( $json ) && ! empty( $json ) ? $json : $request->get_params();
    if ( ! is_array( $params ) ) {
        $params = array();
    }
    $body_nonce = ( isset( $params['nonce'] ) && is_scalar( $params['nonce'] ) ) ? trim( (string) $params['nonce'] ) : '';
    if ( '' === $body_nonce ) {
        $header_nonce = $request->get_header( 'X-WP-Nonce' );
        if ( is_string( $header_nonce ) && '' !== trim( $header_nonce ) ) {
            $params['nonce'] = trim( $header_nonce );
        }
    }
    $result = hpo_process_consultation_submission( $params );
    return new WP_REST_Response( $result['body'], $result['status'] );
}

/**
 * 8. AJAX Fallback: wp_ajax_hpo_consultation & wp_ajax_nopriv_hpo_consultation
 */
function hpo_handle_consultation_ajax() {
    $raw_body = file_get_contents( 'php://input' );
    $decoded  = is_string( $raw_body ) && '' !== trim( $raw_body ) ? json_decode( $raw_body, true ) : null;
    $params   = is_array( $decoded ) ? $decoded : wp_unslash( $_POST ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
    if ( ! is_array( $params ) ) {
        $params = array();
    }
    $result = hpo_process_consultation_submission( $params );
    wp_send_json( $result['body'], $result['status'] );
}
add_action( 'wp_ajax_hpo_consultation', 'hpo_handle_consultation_ajax' );
add_action( 'wp_ajax_nopriv_hpo_consultation', 'hpo_handle_consultation_ajax' );
