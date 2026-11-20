<?php
/**
 * Module: Press Coverage CPT, Taxonomy, Meta Box, REST API, Assets & Seeder
 * Milestone: M2 (F7, F8, F9)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Default ordered press channels matching bao-chi.json.
 *
 * @return array<string, string>
 */
function hpo_press_default_channels() {
    return array(
        'bao-dien-tu' => 'Báo điện tử',
        'truyen-hinh' => 'Truyền hình',
        'phat-thanh'  => 'Phát thanh',
        'mang-xa-hoi' => 'Mạng xã hội',
    );
}

/**
 * Return inline SVG markup for a given press channel slug.
 *
 * @param string $kenh Channel slug.
 * @return string
 */
function hpo_press_channel_icon_svg( $kenh ) {
    $paths = array(
        'bao-dien-tu' => '<path d="M4 5h13v14H6a2 2 0 0 1-2-2zM17 9h3v8a2 2 0 0 1-2 2"/><path d="M7.5 9h6M7.5 12.5h6M7.5 16h4"/>',
        'truyen-hinh' => '<rect x="3" y="5" width="18" height="14" rx="3"/><path d="M10 9.5v5l4.2-2.5z"/>',
        'phat-thanh'  => '<rect x="9" y="3" width="6" height="11" rx="3"/><path d="M5.5 11a6.5 6.5 0 0 0 13 0M12 17.5V21M8.5 21h7"/>',
        'mang-xa-hoi' => '<circle cx="18" cy="5.5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="18.5" r="2.5"/><path d="m8.2 10.8 7.6-4M8.2 13.2l7.6 4"/>',
    );
    $inner = isset( $paths[ $kenh ] ) ? $paths[ $kenh ] : $paths['bao-dien-tu'];
    return '<svg viewBox="0 0 24 24" aria-hidden="true">' . $inner . '</svg>';
}

/**
 * Register CPT hpo_press and taxonomy hpo_press_channel.
 */
function hpo_register_press_post_type() {
    $post_labels = array(
        'name'                  => __( 'Báo chí đưa tin', 'flatsome-child' ),
        'singular_name'         => __( 'Bài báo chí', 'flatsome-child' ),
        'menu_name'             => __( 'Báo chí', 'flatsome-child' ),
        'name_admin_bar'        => __( 'Bài báo chí', 'flatsome-child' ),
        'add_new'               => __( 'Thêm bài mới', 'flatsome-child' ),
        'add_new_item'          => __( 'Thêm bài báo mới', 'flatsome-child' ),
        'edit_item'             => __( 'Sửa bài báo chí', 'flatsome-child' ),
        'new_item'              => __( 'Bài báo mới', 'flatsome-child' ),
        'view_item'             => __( 'Xem bài báo', 'flatsome-child' ),
        'search_items'          => __( 'Tìm bài báo', 'flatsome-child' ),
        'not_found'             => __( 'Chưa có bài báo nào', 'flatsome-child' ),
        'not_found_in_trash'    => __( 'Không có bài nào trong thùng rác', 'flatsome-child' ),
        'all_items'             => __( 'Tất cả bài báo', 'flatsome-child' ),
        'featured_image'        => __( 'Ảnh đại diện bài báo (960×540 .webp)', 'flatsome-child' ),
        'set_featured_image'    => __( 'Chọn ảnh đại diện', 'flatsome-child' ),
        'remove_featured_image' => __( 'Gỡ ảnh đại diện', 'flatsome-child' ),
        'use_featured_image'    => __( 'Dùng làm ảnh đại diện', 'flatsome-child' ),
    );

    register_post_type(
        'hpo_press',
        array(
            'labels'              => $post_labels,
            'public'              => false,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => true,
            'show_in_rest'        => true,
            'rest_base'           => 'hpo-press',
            'menu_position'       => 21,
            'menu_icon'           => 'dashicons-megaphone',
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'hierarchical'        => false,
            'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
            'has_archive'         => false,
            'rewrite'             => false,
            'query_var'           => false,
        )
    );

    $tax_labels = array(
        'name'          => __( 'Kênh báo chí', 'flatsome-child' ),
        'singular_name' => __( 'Kênh báo chí', 'flatsome-child' ),
        'search_items'  => __( 'Tìm kênh', 'flatsome-child' ),
        'all_items'     => __( 'Tất cả kênh', 'flatsome-child' ),
        'edit_item'     => __( 'Sửa kênh', 'flatsome-child' ),
        'update_item'   => __( 'Cập nhật kênh', 'flatsome-child' ),
        'add_new_item'  => __( 'Thêm kênh mới', 'flatsome-child' ),
        'new_item_name' => __( 'Tên kênh mới', 'flatsome-child' ),
        'menu_name'     => __( 'Kênh báo chí', 'flatsome-child' ),
    );

    register_taxonomy(
        'hpo_press_channel',
        array( 'hpo_press' ),
        array(
            'labels'            => $tax_labels,
            'hierarchical'      => true,
            'public'            => false,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'show_in_nav_menus' => false,
            'show_in_rest'      => true,
            'show_admin_column' => false,
            'rewrite'           => false,
            'query_var'         => false,
        )
    );
}
add_action( 'init', 'hpo_register_press_post_type' );

/**
 * Ensure the 4 default channel terms exist in hpo_press_channel.
 */
function hpo_press_ensure_default_terms() {
    if ( ! taxonomy_exists( 'hpo_press_channel' ) ) {
        return;
    }
    foreach ( hpo_press_default_channels() as $slug => $label ) {
        if ( ! term_exists( $slug, 'hpo_press_channel' ) ) {
            wp_insert_term(
                $label,
                'hpo_press_channel',
                array( 'slug' => $slug )
            );
        }
    }
}

/**
 * One-time term pre-seeding on admin_init (never runs DB inserts on frontend init).
 */
function hpo_press_maybe_seed_terms_in_admin() {
    if ( get_option( 'hpo_press_terms_seeded_v1' ) ) {
        return;
    }
    hpo_press_ensure_default_terms();
    update_option( 'hpo_press_terms_seeded_v1', 1, false );
}
add_action( 'admin_init', 'hpo_press_maybe_seed_terms_in_admin' );

/**
 * Add native meta box for hpo_press details.
 */
function hpo_press_add_meta_boxes() {
    add_meta_box(
        'hpo_press_details',
        __( 'Thông tin bài báo chí', 'flatsome-child' ),
        'hpo_press_render_meta_box',
        'hpo_press',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes_hpo_press', 'hpo_press_add_meta_boxes' );

/**
 * Render meta box fields.
 *
 * @param WP_Post $post Current post object.
 */
function hpo_press_render_meta_box( $post ) {
    wp_nonce_field( 'hpo_press_save_meta', 'hpo_press_meta_nonce' );

    $outlet = get_post_meta( $post->ID, '_hpo_press_outlet', true );
    $url    = get_post_meta( $post->ID, '_hpo_press_url', true );
    $desc   = get_post_meta( $post->ID, '_hpo_press_desc', true );
    $note   = get_post_meta( $post->ID, '_hpo_press_note', true );
    ?>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="hpo_press_outlet"><?php esc_html_e( 'Tên báo / Đơn vị (bao)', 'flatsome-child' ); ?></label>
                </th>
                <td>
                    <input
                        type="text"
                        id="hpo_press_outlet"
                        name="hpo_press_outlet"
                        value="<?php echo esc_attr( $outlet ); ?>"
                        class="regular-text"
                        placeholder="Ví dụ: Tuổi Trẻ, CafeTek - HTV"
                    />
                    <p class="description">
                        <?php esc_html_e( 'Dùng "Tên gốc - Kênh" (ví dụ: CafeTek - HTV) để bộ lọc tự gộp theo Tên báo.', 'flatsome-child' ); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hpo_press_url"><?php esc_html_e( 'Đường dẫn bài gốc (link)', 'flatsome-child' ); ?></label>
                </th>
                <td>
                    <input
                        type="url"
                        id="hpo_press_url"
                        name="hpo_press_url"
                        value="<?php echo esc_attr( $url ); ?>"
                        class="large-text"
                        placeholder="https://..."
                    />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hpo_press_desc"><?php esc_html_e( 'Mô tả ngắn (moTa)', 'flatsome-child' ); ?></label>
                </th>
                <td>
                    <textarea
                        id="hpo_press_desc"
                        name="hpo_press_desc"
                        rows="3"
                        class="large-text"
                        placeholder="Không bắt buộc — để trống sẽ tự hiển thị Tên báo · Kênh · Ngày đăng."
                    ><?php echo esc_textarea( $desc ); ?></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="hpo_press_note"><?php esc_html_e( 'Ghi chú nội bộ (ghiChu)', 'flatsome-child' ); ?></label>
                </th>
                <td>
                    <textarea
                        id="hpo_press_note"
                        name="hpo_press_note"
                        rows="2"
                        class="large-text"
                        placeholder="Chỉ hiển thị trong quản trị, không xuất ra trang chủ."
                    ><?php echo esc_textarea( $note ); ?></textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
}

/**
 * Save meta box fields securely.
 *
 * @param int $post_id Post ID.
 */
function hpo_press_save_meta_box( $post_id ) {
    if ( ! isset( $_POST['hpo_press_meta_nonce'] ) ) {
        return;
    }

    $nonce = sanitize_text_field( wp_unslash( $_POST['hpo_press_meta_nonce'] ) );
    if ( ! wp_verify_nonce( $nonce, 'hpo_press_save_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $outlet = isset( $_POST['hpo_press_outlet'] ) ? sanitize_text_field( wp_unslash( $_POST['hpo_press_outlet'] ) ) : '';
    $url    = isset( $_POST['hpo_press_url'] ) ? esc_url_raw( wp_unslash( $_POST['hpo_press_url'] ) ) : '';
    $desc   = isset( $_POST['hpo_press_desc'] ) ? sanitize_textarea_field( wp_unslash( $_POST['hpo_press_desc'] ) ) : '';
    $note   = isset( $_POST['hpo_press_note'] ) ? sanitize_textarea_field( wp_unslash( $_POST['hpo_press_note'] ) ) : '';

    if ( '' !== $outlet ) {
        update_post_meta( $post_id, '_hpo_press_outlet', $outlet );
    } else {
        delete_post_meta( $post_id, '_hpo_press_outlet' );
    }

    if ( '' !== $url ) {
        update_post_meta( $post_id, '_hpo_press_url', $url );
    } else {
        delete_post_meta( $post_id, '_hpo_press_url' );
    }

    if ( '' !== $desc ) {
        update_post_meta( $post_id, '_hpo_press_desc', $desc );
    } else {
        delete_post_meta( $post_id, '_hpo_press_desc' );
    }

    if ( '' !== $note ) {
        update_post_meta( $post_id, '_hpo_press_note', $note );
    } else {
        delete_post_meta( $post_id, '_hpo_press_note' );
    }
}
add_action( 'save_post_hpo_press', 'hpo_press_save_meta_box' );

/**
 * Configure admin list columns for hpo_press.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function hpo_press_admin_columns( $columns ) {
    return array(
        'cb'          => isset( $columns['cb'] ) ? $columns['cb'] : '<input type="checkbox" />',
        'hpo_thumb'   => __( 'Ảnh', 'flatsome-child' ),
        'title'       => __( 'Tiêu đề', 'flatsome-child' ),
        'hpo_outlet'  => __( 'Tên báo', 'flatsome-child' ),
        'hpo_channel' => __( 'Kênh', 'flatsome-child' ),
        'hpo_date'    => __( 'Ngày đăng', 'flatsome-child' ),
        'hpo_order'   => __( 'Thứ tự', 'flatsome-child' ),
        'hpo_url'     => __( 'Liên kết', 'flatsome-child' ),
    );
}
add_filter( 'manage_hpo_press_posts_columns', 'hpo_press_admin_columns' );

/**
 * Render custom admin columns for hpo_press.
 *
 * @param string $column  Column slug.
 * @param int    $post_id Post ID.
 */
function hpo_press_render_admin_column( $column, $post_id ) {
    switch ( $column ) {
        case 'hpo_thumb':
            $thumb_url = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
            if ( $thumb_url ) {
                printf(
                    '<img src="%s" alt="" width="64" height="36" style="width:64px;height:36px;object-fit:cover;border-radius:4px;display:block;" />',
                    esc_url( $thumb_url )
                );
            } else {
                echo '<span aria-hidden="true" style="color:#94a3b8;">—</span>';
            }
            break;

        case 'hpo_outlet':
            $outlet = get_post_meta( $post_id, '_hpo_press_outlet', true );
            echo $outlet ? '<strong>' . esc_html( $outlet ) . '</strong>' : '<span style="color:#94a3b8;">—</span>';
            break;

        case 'hpo_channel':
            $terms = get_the_terms( $post_id, 'hpo_press_channel' );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                $links = array();
                foreach ( $terms as $term ) {
                    $filter_url = add_query_arg(
                        array(
                            'post_type'         => 'hpo_press',
                            'hpo_press_channel' => $term->slug,
                        ),
                        admin_url( 'edit.php' )
                    );
                    $links[] = sprintf(
                        '<a href="%s">%s</a>',
                        esc_url( $filter_url ),
                        esc_html( $term->name )
                    );
                }
                echo wp_kses_post( implode( ', ', $links ) );
            } else {
                echo '<span style="color:#94a3b8;">—</span>';
            }
            break;

        case 'hpo_date':
            $post = get_post( $post_id );
            if ( $post ) {
                echo esc_html( mysql2date( 'H:i · d/m/Y', $post->post_date ) );
            }
            break;

        case 'hpo_order':
            $post = get_post( $post_id );
            echo esc_html( (string) ( $post ? (int) $post->menu_order : 0 ) );
            break;

        case 'hpo_url':
            $url = get_post_meta( $post_id, '_hpo_press_url', true );
            if ( $url ) {
                $label = function_exists( 'hpo_truncate_text' ) ? hpo_truncate_text( $url, 42 ) : $url;
                printf(
                    '<a href="%s" target="_blank" rel="noopener">%s</a>',
                    esc_url( $url ),
                    esc_html( $label )
                );
            } else {
                echo '<span style="color:#94a3b8;">—</span>';
            }
            break;
    }
}
add_action( 'manage_hpo_press_posts_custom_column', 'hpo_press_render_admin_column', 10, 2 );

/**
 * Make hpo_order and hpo_date sortable in wp-admin.
 *
 * @param array $columns Sortable columns.
 * @return array
 */
function hpo_press_sortable_columns( $columns ) {
    $columns['hpo_order'] = 'menu_order';
    $columns['hpo_date']  = 'date';
    return $columns;
}
add_filter( 'manage_edit-hpo_press_sortable_columns', 'hpo_press_sortable_columns' );

/**
 * Default admin list order: menu_order ASC, date DESC.
 *
 * @param WP_Query $query Main query.
 */
function hpo_press_admin_default_order( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( 'hpo_press' !== $query->get( 'post_type' ) ) {
        return;
    }
    if ( ! $query->get( 'orderby' ) ) {
        $query->set(
            'orderby',
            array(
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            )
        );
    }
}
add_action( 'pre_get_posts', 'hpo_press_admin_default_order' );

/**
 * Compact column widths in wp-admin list table.
 */
function hpo_press_admin_list_styles() {
    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    if ( ! $screen || 'edit-hpo_press' !== $screen->id ) {
        return;
    }
    echo '<style>
        .column-hpo_thumb { width: 76px; }
        .column-hpo_order { width: 72px; text-align: center; }
        .column-hpo_date { width: 136px; }
        .column-hpo_channel { width: 120px; }
    </style>';
}
add_action( 'admin_head-edit.php', 'hpo_press_admin_list_styles' );

/**
 * Flush cached press payload transient.
 */
function hpo_press_flush_payload_cache() {
    delete_transient( 'hpo_press_payload_v1' );
}

add_action( 'save_post_hpo_press', 'hpo_press_flush_payload_cache', 20 );
add_action( 'created_hpo_press_channel', 'hpo_press_flush_payload_cache' );
add_action( 'edited_hpo_press_channel', 'hpo_press_flush_payload_cache' );
add_action( 'delete_hpo_press_channel', 'hpo_press_flush_payload_cache' );

/**
 * Flush press payload cache on trash/untrash/delete of hpo_press posts.
 *
 * @param int $post_id Post ID.
 */
function hpo_press_flush_on_post_lifecycle( $post_id ) {
    if ( 'hpo_press' === get_post_type( $post_id ) ) {
        hpo_press_flush_payload_cache();
    }
}
add_action( 'before_delete_post', 'hpo_press_flush_on_post_lifecycle' );
add_action( 'trashed_post', 'hpo_press_flush_on_post_lifecycle' );
add_action( 'untrashed_post', 'hpo_press_flush_on_post_lifecycle' );

/**
 * Flush press payload cache when hpo_press_channel terms are assigned.
 *
 * @param int    $object_id Object ID.
 * @param array  $terms     Terms.
 * @param array  $tt_ids    Term taxonomy IDs.
 * @param string $taxonomy  Taxonomy slug.
 */
function hpo_press_flush_on_set_terms( $object_id, $terms, $tt_ids, $taxonomy ) {
    if ( 'hpo_press_channel' === $taxonomy ) {
        hpo_press_flush_payload_cache();
    }
}
add_action( 'set_object_terms', 'hpo_press_flush_on_set_terms', 10, 4 );

/**
 * Build WP-backed press payload matching { kenh, bai } contract.
 *
 * @param bool $bypass_cache Whether to skip transient read.
 * @return array{kenh: array<string, string>, bai: array<int, array<string, mixed>>}
 */
function hpo_get_press_payload( $bypass_cache = false ) {
    if ( ! $bypass_cache ) {
        $cached = get_transient( 'hpo_press_payload_v1' );
        if ( is_array( $cached ) && isset( $cached['kenh'], $cached['bai'] ) ) {
            return $cached;
        }
    }

    $kenh = hpo_press_default_channels();
    if ( taxonomy_exists( 'hpo_press_channel' ) ) {
        $terms = get_terms(
            array(
                'taxonomy'   => 'hpo_press_channel',
                'hide_empty' => false,
            )
        );
        if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
            foreach ( $terms as $term ) {
                $kenh[ $term->slug ] = $term->name;
            }
        }
    }

    $query = new WP_Query(
        array(
            'post_type'      => 'hpo_press',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => array(
                'menu_order' => 'ASC',
                'date'       => 'DESC',
            ),
            'no_found_rows'  => true,
        )
    );

    if ( ! empty( $query->posts ) ) {
        update_post_thumbnail_cache( $query );
    }

    $bai = array();
    foreach ( $query->posts as $post ) {
        $outlet = get_post_meta( $post->ID, '_hpo_press_outlet', true );
        $url    = get_post_meta( $post->ID, '_hpo_press_url', true );
        $desc   = get_post_meta( $post->ID, '_hpo_press_desc', true );

        if ( '' === $outlet || '' === $url ) {
            continue;
        }

        $channel_slug = 'bao-dien-tu';
        $post_terms   = get_the_terms( $post->ID, 'hpo_press_channel' );
        if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
            $first_term   = reset( $post_terms );
            $channel_slug = $first_term->slug;
        }

        $thumb_url = get_the_post_thumbnail_url( $post->ID, 'full' );
        $item      = array(
            'id'     => (int) $post->ID,
            'bao'    => (string) $outlet,
            'kenh'   => (string) $channel_slug,
            'tieuDe' => (string) $post->post_title,
            'link'   => (string) $url,
            'anh'    => $thumb_url ? (string) $thumb_url : '',
            'ngay'   => (string) mysql2date( 'Y-m-d\TH:i', $post->post_date ),
            'moTa'   => (string) $desc,
        );
        $bai[] = $item;
    }

    $payload = array(
        'kenh' => $kenh,
        'bai'  => $bai,
    );

    set_transient( 'hpo_press_payload_v1', $payload, HOUR_IN_SECONDS );

    return $payload;
}

/**
 * REST callback for GET /wp-json/hpo/v1/press.
 *
 * @return WP_REST_Response
 */
function hpo_rest_get_press() {
    return rest_ensure_response( hpo_get_press_payload() );
}

/**
 * Register REST API route for press items.
 */
function hpo_press_register_rest_routes() {
    register_rest_route(
        'hpo/v1',
        '/press',
        array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'hpo_rest_get_press',
            'permission_callback' => '__return_true',
        )
    );
}
add_action( 'rest_api_init', 'hpo_press_register_rest_routes' );

/**
 * Enqueue F8/F9 CSS & deferred JS after hpo-elements.
 */
function hpo_press_enqueue_assets() {
    $css_ver = function_exists( 'hpo_asset_version' ) ? hpo_asset_version( '/assets/css/hpo-press.css' ) : HPO_VERSION;
    $js_ver  = function_exists( 'hpo_asset_version' ) ? hpo_asset_version( '/assets/js/hpo-press.js' ) : HPO_VERSION;

    wp_enqueue_style(
        'hpo-press',
        HPO_THEME_URI . '/assets/css/hpo-press.css',
        array( 'hpo-elements' ),
        $css_ver
    );

    wp_enqueue_script(
        'hpo-press-js',
        HPO_THEME_URI . '/assets/js/hpo-press.js',
        array(),
        $js_ver,
        array(
            'in_footer' => true,
            'strategy'  => 'defer',
        )
    );

    wp_localize_script( 'hpo-press-js', 'HPO_PRESS_DATA', hpo_get_press_payload() );
    wp_localize_script(
        'hpo-press-js',
        'HPO_PRESS_CONFIG',
        array(
            'restUrl' => esc_url_raw( rest_url( 'hpo/v1/press' ) ),
        )
    );
}
add_action( 'hpo_enqueue_module_assets', 'hpo_press_enqueue_assets' );

/**
 * Store / retrieve shared #pressListDialog state across [hpo_press_strip] and [hpo_news_rotator].
 *
 * @param array|null $args Optional settings ('needed', 'title', 'subtitle', 'count').
 * @return array
 */
function hpo_press_dialog_state( $args = null ) {
    static $state = array(
        'needed'   => false,
        'title'    => 'Báo chí đưa tin về Hiệp Phát',
        'subtitle' => 'bài báo, video, phát thanh sau họp báo ngày 28/10/2026',
        'count'    => null,
    );

    if ( is_array( $args ) ) {
        if ( ! empty( $args['needed'] ) ) {
            $state['needed'] = true;
        }
        if ( isset( $args['title'] ) && '' !== trim( (string) $args['title'] ) ) {
            $state['title'] = (string) $args['title'];
        }
        if ( isset( $args['subtitle'] ) && '' !== trim( (string) $args['subtitle'] ) ) {
            $state['subtitle'] = (string) $args['subtitle'];
        }
        if ( isset( $args['count'] ) ) {
            $state['count'] = (int) $args['count'];
        }
    }

    return $state;
}

/**
 * Mark #pressListDialog as needed on the current page.
 *
 * @param array $args Optional overrides for title, subtitle, count.
 */
function hpo_press_mark_dialog_needed( $args = array() ) {
    $args['needed'] = true;
    hpo_press_dialog_state( $args );
}

/**
 * Render #pressListDialog markup at most once per request.
 *
 * @param array $args Optional overrides for title, subtitle, count.
 * @return string
 */
function hpo_press_render_dialog_markup( $args = array() ) {
    static $rendered = false;
    if ( $rendered ) {
        return '';
    }
    $rendered = true;

    $state    = hpo_press_dialog_state( $args );
    $title    = $state['title'];
    $subtitle = $state['subtitle'];
    $count    = $state['count'];

    if ( null === $count ) {
        $payload = hpo_get_press_payload();
        $count   = isset( $payload['bai'] ) && is_array( $payload['bai'] ) ? count( $payload['bai'] ) : 0;
    }

    ob_start();
    ?>
    <dialog
      class="press-dialog"
      id="pressListDialog"
      aria-labelledby="pressListTitle"
    >
      <div class="press-dialog__head">
        <span class="press-dialog__head-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24">
            <path d="M4 5h13v14H6a2 2 0 0 1-2-2zM17 9h3v8a2 2 0 0 1-2 2" />
            <path d="M7.5 9h6M7.5 12.5h6M7.5 16h4" />
          </svg>
        </span>
        <div class="press-dialog__heading">
          <h2 class="press-dialog__title" id="pressListTitle"><?php echo esc_html( $title ); ?></h2>
          <p class="press-dialog__sub">
            <b data-press-count><?php echo esc_html( (string) $count ); ?></b>
            <?php echo esc_html( $subtitle ); ?>
          </p>
        </div>
        <button
          type="button"
          class="press-dialog__close"
          data-press-close
          aria-label="Đóng danh sách"
          autofocus
        >
          <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M6 6l12 12M18 6 6 18" />
          </svg>
        </button>
      </div>
      <ol class="press-dialog__list" data-press-list></ol>
    </dialog>
    <?php
    return trim( ob_get_clean() );
}

/**
 * Output single-instance #pressListDialog in wp_footer when any press shortcode ran.
 */
function hpo_press_output_dialog_in_footer() {
    $state = hpo_press_dialog_state();
    if ( empty( $state['needed'] ) ) {
        return;
    }
    echo "\n" . hpo_press_render_dialog_markup() . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_footer', 'hpo_press_output_dialog_in_footer', 25 );

/**
 * Emit inline JSON fallback #hpoPressData once if hpo-press-js was not localized/enqueued.
 *
 * @return string
 */
function hpo_press_ensure_inline_data() {
    static $emitted = false;
    if ( $emitted || wp_script_is( 'hpo-press-js', 'enqueued' ) ) {
        return '';
    }
    $emitted = true;
    $json    = wp_json_encode( hpo_get_press_payload(), JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    if ( ! $json ) {
        return '';
    }
    return '<script type="application/json" id="hpoPressData">' . $json . '</script>';
}

/**
 * Idempotent seeder: imports press articles and .webp thumbnails from bao-chi.json.
 * Never invoked automatically on frontend requests.
 *
 * @param array $args Optional keys: 'file' (string), 'force' (bool).
 * @return array{created: int, updated: int, images_attached: int, errors: array<int, string>}
 */
function hpo_seed_press_items( $args = array() ) {
    $summary = array(
        'created'         => 0,
        'updated'         => 0,
        'images_attached' => 0,
        'errors'          => array(),
    );

    $json_path = ! empty( $args['file'] )
        ? (string) $args['file']
        : HPO_THEME_DIR . '/assets/data/bao-chi.json';

    if ( ! file_exists( $json_path ) ) {
        $summary['errors'][] = 'JSON file not found: ' . $json_path;
        return $summary;
    }

    $raw = file_get_contents( $json_path );
    if ( false === $raw ) {
        $summary['errors'][] = 'Unable to read JSON file: ' . $json_path;
        return $summary;
    }

    $data = json_decode( $raw, true );
    if ( ! is_array( $data ) || empty( $data['bai'] ) || ! is_array( $data['bai'] ) ) {
        $summary['errors'][] = 'Invalid bao-chi.json payload.';
        return $summary;
    }

    // Ensure default & any custom channels from JSON exist.
    hpo_press_ensure_default_terms();
    if ( ! empty( $data['kenh'] ) && is_array( $data['kenh'] ) ) {
        foreach ( $data['kenh'] as $slug => $label ) {
            $slug  = sanitize_title( $slug );
            $label = sanitize_text_field( $label );
            if ( $slug && $label && ! term_exists( $slug, 'hpo_press_channel' ) ) {
                wp_insert_term( $label, 'hpo_press_channel', array( 'slug' => $slug ) );
            }
        }
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $img_dir = HPO_THEME_DIR . '/assets/images/bao-chi/';

    foreach ( $data['bai'] as $index => $item ) {
        if ( empty( $item['bao'] ) || empty( $item['link'] ) ) {
            continue;
        }

        $outlet = sanitize_text_field( $item['bao'] );
        $title  = sanitize_text_field( isset( $item['tieuDe'] ) ? $item['tieuDe'] : $outlet );
        $link   = esc_url_raw( $item['link'] );
        $kenh   = ! empty( $item['kenh'] ) ? sanitize_title( $item['kenh'] ) : 'bao-dien-tu';
        $desc   = isset( $item['moTa'] ) ? sanitize_textarea_field( $item['moTa'] ) : '';
        $note   = isset( $item['ghiChu'] ) ? sanitize_textarea_field( $item['ghiChu'] ) : '';
        $ngay   = isset( $item['ngay'] ) ? trim( (string) $item['ngay'] ) : '';

        $post_data = array(
            'post_type'   => 'hpo_press',
            'post_title'  => $title,
            'post_status' => 'publish',
            'menu_order'  => (int) $index,
        );

        if ( '' !== $ngay ) {
            $normalized = str_replace( 'T', ' ', $ngay );
            if ( 10 === strlen( $normalized ) ) {
                $normalized .= ' 00:00:00';
            } elseif ( 16 === strlen( $normalized ) ) {
                $normalized .= ':00';
            } elseif ( strlen( $normalized ) >= 19 ) {
                $normalized = substr( $normalized, 0, 19 );
            }
            $post_data['post_date']     = $normalized;
            $post_data['post_date_gmt'] = get_gmt_from_date( $normalized );
            $post_data['edit_date']     = true;
        }

        $existing = get_posts(
            array(
                'post_type'      => 'hpo_press',
                'post_status'    => 'any',
                'posts_per_page' => 1,
                'fields'         => 'ids',
                'meta_key'       => '_hpo_press_url',
                'meta_value'     => $link,
                'no_found_rows'  => true,
            )
        );

        if ( ! empty( $existing ) ) {
            $post_id         = (int) $existing[0];
            $post_data['ID'] = $post_id;
            $result          = wp_update_post( $post_data, true );
            if ( is_wp_error( $result ) ) {
                $summary['errors'][] = 'Update failed for ' . $outlet . ': ' . $result->get_error_message();
                continue;
            }
            $summary['updated']++;
        } else {
            $result = wp_insert_post( $post_data, true );
            if ( is_wp_error( $result ) ) {
                $summary['errors'][] = 'Insert failed for ' . $outlet . ': ' . $result->get_error_message();
                continue;
            }
            $post_id = (int) $result;
            $summary['created']++;
        }

        update_post_meta( $post_id, '_hpo_press_outlet', $outlet );
        update_post_meta( $post_id, '_hpo_press_url', $link );

        if ( '' !== $desc ) {
            update_post_meta( $post_id, '_hpo_press_desc', $desc );
        } else {
            delete_post_meta( $post_id, '_hpo_press_desc' );
        }

        if ( '' !== $note ) {
            update_post_meta( $post_id, '_hpo_press_note', $note );
        } else {
            delete_post_meta( $post_id, '_hpo_press_note' );
        }

        wp_set_object_terms( $post_id, array( $kenh ), 'hpo_press_channel', false );

        if ( ! empty( $item['anh'] ) ) {
            $filename    = wp_basename( (string) $item['anh'] );
            $source_path = $img_dir . $filename;

            $existing_att = get_posts(
                array(
                    'post_type'      => 'attachment',
                    'post_status'    => 'inherit',
                    'posts_per_page' => 1,
                    'fields'         => 'ids',
                    'meta_key'       => '_hpo_source_file',
                    'meta_value'     => $filename,
                    'no_found_rows'  => true,
                )
            );

            $attach_id = ! empty( $existing_att ) ? (int) $existing_att[0] : 0;

            if ( ! $attach_id ) {
                if ( ! file_exists( $source_path ) ) {
                    $summary['errors'][] = 'Missing image file: ' . $source_path;
                    continue;
                }

                $tmp_file = wp_tempnam( $filename );
                if ( ! $tmp_file || ! copy( $source_path, $tmp_file ) ) {
                    if ( $tmp_file && file_exists( $tmp_file ) ) {
                        wp_delete_file( $tmp_file );
                    }
                    $summary['errors'][] = 'Failed to copy image to temp file: ' . $filename;
                    continue;
                }

                $file_array = array(
                    'name'     => $filename,
                    'tmp_name' => $tmp_file,
                );

                $sideload = media_handle_sideload( $file_array, $post_id, $title );
                if ( is_wp_error( $sideload ) ) {
                    if ( file_exists( $tmp_file ) ) {
                        wp_delete_file( $tmp_file );
                    }
                    $summary['errors'][] = 'Sideload failed for ' . $filename . ': ' . $sideload->get_error_message();
                    continue;
                }

                $attach_id = (int) $sideload;
                update_post_meta( $attach_id, '_hpo_source_file', $filename );
            }

            if ( $attach_id && (int) get_post_thumbnail_id( $post_id ) !== $attach_id ) {
                set_post_thumbnail( $post_id, $attach_id );
                $summary['images_attached']++;
            }
        }
    }

    hpo_press_flush_payload_cache();

    return $summary;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    /**
     * Seed HPO press items from bao-chi.json into hpo_press CPT.
     *
     * ## OPTIONS
     *
     * [--file=<path>]
     * : Optional custom path to bao-chi.json.
     *
     * ## EXAMPLES
     *
     *     wp hpo seed-press
     *
     * @param array $args       Positional args.
     * @param array $assoc_args Named args.
     */
    WP_CLI::add_command(
        'hpo seed-press',
        function( $args, $assoc_args ) {
            $seed_args = array();
            if ( ! empty( $assoc_args['file'] ) ) {
                $seed_args['file'] = $assoc_args['file'];
            }

            $result = hpo_seed_press_items( $seed_args );

            foreach ( $result['errors'] as $err ) {
                WP_CLI::warning( $err );
            }

            WP_CLI::success(
                sprintf(
                    'HPO press seed complete: %d created, %d updated, %d thumbnails attached (%d errors).',
                    $result['created'],
                    $result['updated'],
                    $result['images_attached'],
                    count( $result['errors'] )
                )
            );
        }
    );
}
