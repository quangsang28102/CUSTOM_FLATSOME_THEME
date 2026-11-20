<?php
/**
 * UX Builder Element: HPO Footer
 * Tag: [hpo_footer]
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_ux_builder_shortcode( 'hpo_footer', array(
    'name'     => __( 'HPO Footer', 'flatsome-child' ),
    'category' => __( 'HPO Elements', 'flatsome-child' ),
    'priority' => 10,
    'options'  => array(
        'brand_group' => array(
            'type'    => 'group',
            'heading' => __( 'Thương hiệu & Liên hệ', 'flatsome-child' ),
            'options' => array(
                'logo_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Logo nền tối (Trắng)', 'flatsome-child' ),
                    'default' => '',
                ),
                'company_license' => array(
                    'type'    => 'textarea',
                    'heading' => __( 'Tên công ty & GCNKD', 'flatsome-child' ),
                    'default' => "Công ty TNHH Ô Tô Hiệp Phát\nGCNKD số 0309987279, do Sở KH&ĐT TP.HCM\ncấp lần đầu ngày 11/05/2010.",
                ),
                'address' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Địa chỉ trụ sở', 'flatsome-child' ),
                    'default' => '176 Thế Lữ, Ấp 1, xã Tân Nhựt, TP. Hồ Chí Minh',
                ),
                'phone' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Số điện thoại hiển thị', 'flatsome-child' ),
                    'default' => '028.36.362.362',
                ),
                'tel' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Số điện thoại (tel:)', 'flatsome-child' ),
                    'default' => '02836362362',
                ),
                'email' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Email liên hệ', 'flatsome-child' ),
                    'default' => 'tuyensinh@hpo.edu.vn',
                ),
                'facebook_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link Facebook', 'flatsome-child' ),
                    'default' => 'https://www.facebook.com/profile.php?id=61579767334341',
                ),
                'youtube_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link YouTube', 'flatsome-child' ),
                    'default' => 'https://youtube.com/@hiepphat2727',
                ),
                'tiktok_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link TikTok / Thông báo', 'flatsome-child' ),
                    'default' => 'https://hpo.edu.vn/thong-bao',
                ),
            ),
        ),
        'branches_group' => array(
            'type'    => 'group',
            'heading' => __( 'Danh sách cơ sở', 'flatsome-child' ),
            'options' => array(
                'branches_heading' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề cột cơ sở', 'flatsome-child' ),
                    'default' => 'Cơ sở',
                ),
                'branch1_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Cơ sở 1 — Tên', 'flatsome-child' ),
                    'default' => '1. Trụ sở chính',
                ),
                'branch1_address' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Cơ sở 1 — Địa chỉ', 'flatsome-child' ),
                    'default' => '176 Thế Lữ, Tân Nhựt, TP. HCM',
                ),
                'branch1_phone' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Cơ sở 1 — SĐT', 'flatsome-child' ),
                    'default' => '028.36.362.362',
                ),
                'branch2_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Cơ sở 2 — Tên', 'flatsome-child' ),
                    'default' => '2. Cơ sở Vĩnh Lộc',
                ),
                'branch2_address' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Cơ sở 2 — Địa chỉ', 'flatsome-child' ),
                    'default' => '271 Đường số 1, Phường Bình Tân',
                ),
                'branch2_phone' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Cơ sở 2 — SĐT', 'flatsome-child' ),
                    'default' => '028.36.201.199',
                ),
                'branch3_title' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Cơ sở 3 — Tên', 'flatsome-child' ),
                    'default' => '3. VP Tuyển Sinh',
                ),
                'branch3_address' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Cơ sở 3 — Địa chỉ', 'flatsome-child' ),
                    'default' => '276 Minh Phụng, Phường Minh Phụng, TP. HCM',
                ),
                'branch3_phone' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Cơ sở 3 — SĐT', 'flatsome-child' ),
                    'default' => '0912.799.129',
                ),
            ),
        ),
        'apps_map_group' => array(
            'type'    => 'group',
            'heading' => __( 'Ứng dụng, Bản đồ & Bộ Công Thương', 'flatsome-child' ),
            'options' => array(
                'apps_heading' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề cột ứng dụng', 'flatsome-child' ),
                    'default' => 'Tải ứng dụng',
                ),
                'app_desc' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Mô tả ứng dụng', 'flatsome-child' ),
                    'default' => 'Trải nghiệm ngay trên Hiệp Phát Edu.',
                ),
                'chplay_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link Google Play', 'flatsome-child' ),
                    'default' => 'https://play.google.com/store/apps/details?id=com.hpo.edugo',
                ),
                'chplay_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh Google Play', 'flatsome-child' ),
                    'default' => '',
                ),
                'appstore_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link App Store', 'flatsome-child' ),
                    'default' => 'https://apps.apple.com/vn/app/hiep-phat-edu/id6748065752',
                ),
                'appstore_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh App Store', 'flatsome-child' ),
                    'default' => '',
                ),
                'map_heading' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Tiêu đề cột bản đồ', 'flatsome-child' ),
                    'default' => 'Bản đồ',
                ),
                'map_embed_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Google Maps Embed URL', 'flatsome-child' ),
                    'default' => 'https://www.google.com/maps?q=C%C3%B4ng%20ty%20TNHH%20%C3%94%20T%C3%B4%20Hi%E1%BB%87p%20Ph%C3%A1t%20176%20%C4%90%C6%B0%E1%BB%9Dng%20Th%E1%BA%BF%20L%E1%BB%AF%20T%C3%A2n%20Nh%E1%BB%B1t%20TP.HCM&output=embed',
                ),
                'bct_url' => array(
                    'type'    => 'textfield',
                    'heading' => __( 'Link Bộ Công Thương', 'flatsome-child' ),
                    'default' => 'http://online.gov.vn/Website/chi-tiet-135372',
                ),
                'bct_image' => array(
                    'type'    => 'image',
                    'heading' => __( 'Ảnh Bộ Công Thương', 'flatsome-child' ),
                    'default' => '',
                ),
            ),
        ),
    ),
) );
