<?php
/**
 * Shortcode Render: [hpo_curriculum]
 * Renders #chuong-trinh-mon-hoc (6-Subject Curriculum with nested accordions & modal triggers, Feature F19).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'hpo_curriculum_resolve_image_url' ) ) {
	function hpo_curriculum_resolve_image_url( $value, $fallback_url ) {
		if ( is_numeric( $value ) && (int) $value > 0 ) {
			return hpo_get_image_url( (int) $value, 'full', $fallback_url );
		}
		if ( is_string( $value ) && '' !== trim( $value ) ) {
			$trimmed = trim( $value );
			if ( preg_match( '#^(https?:)?//#i', $trimmed ) || 0 === strpos( $trimmed, '/' ) || 0 === strpos( $trimmed, 'data:' ) ) {
				return $trimmed;
			}
			if ( 0 === strpos( $trimmed, 'assets/' ) ) {
				return HPO_THEME_URI . '/' . ltrim( $trimmed, '/' );
			}
			return HPO_THEME_URI . '/assets/images/' . ltrim( $trimmed, '/' );
		}
		return hpo_get_image_url( 0, 'full', $fallback_url );
	}
}

function hpo_shortcode_curriculum( $atts ) {
	$a = shortcode_atts( array(
		'section_id'   => 'chuong-trinh-mon-hoc',
		'eyebrow'      => 'Chương trình đào tạo',
		'title_prefix' => 'Chương trình đào tạo lái xe ô tô',
		'title_accent' => 'thông minh',
		// Subjects 01-06
		'm1_title'     => 'Pháp luật về giao thông đường bộ',
		'm1_meta_1'    => '3 phần',
		'm1_meta_2'    => '15 chương',
		'm1_sub'       => 'Danh mục chương chính',
		'm2_title'     => 'Cấu tạo và sửa chữa thông thường',
		'm2_meta'      => '8 chương',
		'm2_sub'       => 'Danh mục nội dung chính',
		'm3_title'     => 'Đạo đức người lái xe, văn hóa giao thông, phòng chống tác hại của rượu bia; kỹ năng phòng cháy chữa cháy và cứu nạn cứu hộ',
		'm3_meta'      => '6 chương',
		'm3_sub'       => 'Danh mục nội dung chính',
		'm4_title'     => 'Kỹ thuật lái xe',
		'm4_meta'      => '9 chương',
		'm4_sub'       => 'Danh mục nội dung chính',
		'm5_title'     => 'Phần mềm mô phỏng tình huống giao thông',
		'm5_meta'      => '120 tình huống',
		'm5_sub'       => 'Cục Đường bộ Việt Nam · 120 tình huống thực tế',
		'm6_title'     => 'Thực hành lái xe',
		'm6_meta'      => '4 chương',
		'm6_sub'       => 'Danh mục nội dung chính',
		// Bienbao images
		'bb1_image'    => '',
		'bb2_image'    => '',
		'bb3_image'    => '',
		'bb4_image'    => '',
		'bb5_image'    => '',
		// Video lessons
		'v1_url'       => 'https://youtu.be/G9eeLeNSYB4',
		'v1_title'     => 'Hư hỏng thường gặp ở động cơ',
		'v2_url'       => 'https://youtu.be/E2rwBpPNPiQ',
		'v2_title'     => 'Hư hỏng thường gặp ở hộp số',
		'v3_url'       => 'https://youtu.be/F4Fz56U2Fjc',
		'v3_title'     => 'Hư hỏng thường gặp ở điều hòa và hệ thống điện',
		'v4_url'       => 'https://youtu.be/3q1WpUh1AsE',
		'v4_title'     => 'Hư hỏng thường gặp ở hệ thống lái và treo',
		'v5_url'       => 'https://youtu.be/8DGmYr3N-DI',
		'v5_title'     => 'Bài giảng 360° tham quan các bộ phận của xe ô tô',
	), $atts, 'hpo_curriculum' );

	$section_id = sanitize_html_class( $a['section_id'] );
	if ( '' === $section_id ) {
		$section_id = 'chuong-trinh-mon-hoc';
	}

	$bb_imgs = array(
		hpo_curriculum_resolve_image_url( $a['bb1_image'], HPO_THEME_URI . '/assets/images/bienbao/bbcam.png' ),
		hpo_curriculum_resolve_image_url( $a['bb2_image'], HPO_THEME_URI . '/assets/images/bienbao/bbNguyHiem.png' ),
		hpo_curriculum_resolve_image_url( $a['bb3_image'], HPO_THEME_URI . '/assets/images/bienbao/bbHieuLenh.png' ),
		hpo_curriculum_resolve_image_url( $a['bb4_image'], HPO_THEME_URI . '/assets/images/bienbao/bbChiDan.png' ),
		hpo_curriculum_resolve_image_url( $a['bb5_image'], HPO_THEME_URI . '/assets/images/bienbao/bbPhu.png' ),
	);

	$subjects = array(
		array(
			'mon'            => '01',
			'tag_type'       => 'ly-thuyet',
			'tag_label'      => 'Lý thuyết',
			'title'          => $a['m1_title'],
			'is_traffic_law' => true,
			'metas'          => array( $a['m1_meta_1'], $a['m1_meta_2'] ),
			'sub'            => $a['m1_sub'],
			'toggle'         => 'chap-phap-luat',
			'down_aria'      => 'Mở danh mục chương môn Pháp luật về giao thông đường bộ',
			'play_aria'      => 'Phát video',
			'detail_id'      => 'syllDetail-chap-phap-luat-static',
			'phans'          => array(
				array(
					'id'         => 'phan-chap-01-I-static',
					'class'      => 'phan phan--I has-chip',
					'roman'      => 'I',
					'chip'       => 'Phần 1',
					'title'      => 'Luật Trật tự, an toàn giao thông đường bộ',
					'count_meta' => '07 chương',
					'desc'       => "Hệ thống quy định pháp luật cốt lõi về trật tự, an toàn giao thông đường bộ năm 2024 - quy tắc giao thông,\nngười điều khiển phương tiện, trách nhiệm pháp lý và xử lý vi phạm.",
					'chapters'   => array(
						array( 'type' => 'plain', 'num' => '1', 'title' => 'Những quy định chung' ),
						array( 'type' => 'plain', 'num' => '2', 'title' => 'Quy tắc giao thông đường bộ' ),
						array( 'type' => 'plain', 'num' => '3', 'title' => 'Xe ô tô tham gia giao thông đường bộ' ),
						array( 'type' => 'plain', 'num' => '4', 'title' => 'Người lái xe ô tô tham gia giao thông đường bộ' ),
						array( 'type' => 'plain', 'num' => '5', 'title' => 'Nhận thức về Bộ luật hình sự liên quan đến nhóm tội phạm quy định về giao thông' ),
						array( 'type' => 'plain', 'num' => '6', 'title' => 'Pháp luật về xử lý vi phạm hành chính về trật tự, an toàn giao thông đường bộ' ),
						array( 'type' => 'plain', 'num' => '7', 'title' => 'Nhận thức về xếp hàng hóa trên xe ô tô và pháp luật về vận tải đường bộ' ),
					),
				),
				array(
					'id'         => 'phan-chap-01-II-static',
					'class'      => 'phan phan--II has-chip',
					'roman'      => 'II',
					'chip'       => 'Phần 2',
					'title'      => 'Hệ thống báo hiệu đường bộ',
					'count_meta' => '05 chương',
					'desc'       => "Nhận biết và phân loại đầy đủ hệ thống báo hiệu đường bộ: biển báo, đèn tín hiệu,\nvạch kẻ đường và hiệu lệnh người điều khiển - nền tảng để xử lý đúng mọi tình huống thực tế.",
					'chapters'   => array(
						array( 'type' => 'plain', 'num' => '1', 'title' => 'Quy định chung' ),
						array( 'type' => 'plain', 'num' => '2', 'title' => 'Hiệu lệnh điều khiển giao thông' ),
						array(
							'type'     => 'featured_bb',
							'id'       => 'chap-full-01-bb-static',
							'chip'     => 'Chương 3',
							'title'    => 'Biển báo hiệu',
							'desc'     => 'Nhận diện 5 nhóm biển báo qua hình ảnh trực quan, hiểu ý nghĩa để xử lý tình huống đúng luật. Đăng ký học ngay để tự tin hơn trên mọi hành trình.',
							'cards'    => array(
								array(
									'slug'        => 'bien-cam',
									'name'        => '1. Biển báo cấm',
									'img'         => $bb_imgs[0],
									'alt'         => 'Biển báo cấm',
									'shape_text'  => 'Tròn ·',
									'color_class' => 'bb-color-red',
									'color_label' => 'Viền đỏ',
									'count'       => '63',
								),
								array(
									'slug'        => 'nguy-hiem',
									'name'        => '2. Biển nguy hiểm',
									'img'         => $bb_imgs[1],
									'alt'         => 'Biển nguy hiểm',
									'shape_text'  => 'Tam giác ·',
									'color_class' => 'bb-color-yellow',
									'color_label' => 'Vàng',
									'count'       => '83',
								),
								array(
									'slug'        => 'hieu-lenh',
									'name'        => '3. Biển hiệu lệnh',
									'img'         => $bb_imgs[2],
									'alt'         => 'Biển hiệu lệnh',
									'shape_text'  => 'Tròn ·',
									'color_class' => 'bb-color-blue',
									'color_label' => 'Nền xanh',
									'count'       => '65',
								),
								array(
									'slug'        => 'chi-dan',
									'name'        => '4. Biển chỉ dẫn',
									'img'         => $bb_imgs[3],
									'alt'         => 'Biển chỉ dẫn',
									'shape_text'  => 'Chữ nhật ·',
									'color_class' => 'bb-color-blue',
									'color_label' => 'Xanh',
									'count'       => '92',
								),
								array(
									'slug'        => 'bien-phu',
									'name'        => '5. Biển phụ',
									'img'         => $bb_imgs[4],
									'alt'         => 'Biển phụ',
									'shape_text'  => 'Chữ nhật ·',
									'color_class' => 'bb-color-gray',
									'color_label' => 'Trắng',
									'count'       => '31',
								),
							),
						),
						array( 'type' => 'plain', 'num' => '4', 'title' => 'Các báo hiệu đường bộ khác' ),
						array( 'type' => 'plain', 'num' => '5', 'title' => 'Tốc độ và khoảng cách' ),
					),
				),
				array(
					'id'         => 'phan-chap-01-III-static',
					'class'      => 'phan phan--III has-chip',
					'roman'      => 'III',
					'chip'       => 'Phần 3',
					'title'      => 'Xử lý các tình huống giao thông',
					'count_meta' => '03 chương',
					'desc'       => "Phương pháp phân tích sa hình và 7 nguyên tắc xử lý tình huống giao nhau, rèn kỹ năng quyết định nhanh,\nan toàn khi tham gia giao thông.",
					'chapters'   => array(
						array( 'type' => 'plain', 'num' => '1', 'title' => 'Các đặc điểm của sa hình' ),
						array(
							'type'  => 'featured_sh',
							'id'    => 'chap-full-01-sa-static',
							'chip'  => 'Chương 2',
							'title' => 'Các nguyên tắc đi sa hình',
							'desc'  => 'Nắm thứ tự ưu tiên và cách xử lý từng tình huống sa hình, giúp bạn chọn hướng đi chính xác khi luyện tập và sát hạch. Đăng ký học để luyện vững từng dạng bài.',
							'cards' => array(
								array( 'slug' => 'nguyen-tac-1', 'num' => '1', 'text' => 'Xe có đường riêng' ),
								array( 'slug' => 'nguyen-tac-2', 'num' => '2', 'text' => 'Quyền bình đẳng xe vào nơi đường giao nhau' ),
								array( 'slug' => 'nguyen-tac-3', 'num' => '3', 'text' => 'Xe ưu tiên theo luật giao thông đường bộ' ),
								array( 'slug' => 'nguyen-tac-4', 'num' => '4', 'text' => 'Xe ở đường ưu tiên' ),
								array( 'slug' => 'nguyen-tac-5', 'num' => '5', 'text' => 'Xe có quyền ưu tiên bên phải' ),
								array( 'slug' => 'nguyen-tac-6', 'num' => '6', 'text' => 'Quyền ưu tiên đối với xe đi cùng đoàn, cùng hướng' ),
								array( 'slug' => 'nguyen-tac-7', 'num' => '7', 'text' => 'Xe phải nhường đường khi rẽ trái' ),
							),
						),
						array( 'type' => 'plain', 'num' => '3', 'title' => 'Nhận thức về phòng ngừa tai nạn giao thông' ),
					),
				),
			),
		),
		array(
			'mon'            => '02',
			'tag_type'       => 'ly-thuyet',
			'tag_label'      => 'Lý thuyết',
			'title'          => $a['m2_title'],
			'is_traffic_law' => false,
			'metas'          => array( $a['m2_meta'] ),
			'sub'            => $a['m2_sub'],
			'toggle'         => 'chap-cau-tao',
			'down_aria'      => 'Mở danh mục môn Cấu tạo và sửa chữa thông thường',
			'play_aria'      => 'Phát video',
			'detail_id'      => 'syllDetail-chap-cau-tao-static',
			'phans'          => array(
				array(
					'id'         => 'phan-chap-02-static',
					'class'      => 'phan phan--I has-chip is-open',
					'roman'      => 'II',
					'chip'       => 'Môn 2',
					'title'      => 'Cấu tạo và sửa chữa thông thường',
					'count_meta' => '08 mục',
					'desc'       => '',
					'chapters'   => array(
						array( 'type' => 'chip', 'num' => '1', 'chip' => 'Chương 1', 'title' => 'Giới thiệu chung về xe ô tô' ),
						array(
							'type'  => 'featured_engine',
							'id'    => 'chap-full-02-engine-static',
							'chip'  => 'Chương 2',
							'title' => 'Động cơ xe ô tô',
							'desc'  => 'Khám phá nguyên lý hoạt động của động cơ 4 kỳ để hiểu rõ hơn chiếc xe mình điều khiển. Bắt đầu học ngay để xây nền tảng kiến thức ô tô vững chắc.',
							'items' => array(
								array(
									'href'      => '#dong-co-4-ky',
									'view'      => 'engine-4ky',
									'badge'     => 'BG',
									'title'     => 'Nguyên lý làm việc của động cơ 4 kỳ',
									'tag_class' => 'tag-blue',
									'tag_label' => 'Bài giảng',
								),
							),
						),
						array( 'type' => 'chip', 'num' => '3', 'chip' => 'Chương 3', 'title' => 'Cấu tạo Gầm ô tô' ),
						array( 'type' => 'chip', 'num' => '4', 'chip' => 'Chương 4', 'title' => 'Hệ thống Điện xe ô tô' ),
						array( 'type' => 'chip', 'num' => '5', 'chip' => 'Chương 5', 'title' => 'Các hệ thống an toàn chủ động trang bị trên xe ô tô' ),
						array( 'type' => 'chip', 'num' => '6', 'chip' => 'Chương 6', 'title' => 'Hệ thống tự chẩn đoán trên ô tô' ),
						array( 'type' => 'chip', 'num' => '7', 'chip' => 'Chương 7', 'title' => 'Nội quy xưởng và kỹ thuật an toàn' ),
						array(
							'type'  => 'featured_videos',
							'id'    => 'chap-full-02-hu-hong-static',
							'chip'  => 'Chương 8',
							'title' => 'Các hư hỏng thông thường',
							'desc'  => 'Nhận biết dấu hiệu hư hỏng thường gặp ở động cơ, hộp số, điều hòa, điện, lái và treo để chủ động đưa xe đi kiểm tra. Đăng ký học để chăm sóc xe tốt hơn.',
							'items' => array(
								array( 'badge' => 'BG', 'url' => $a['v1_url'], 'title' => $a['v1_title'] ),
								array( 'badge' => 'BG', 'url' => $a['v2_url'], 'title' => $a['v2_title'] ),
								array( 'badge' => 'BG', 'url' => $a['v3_url'], 'title' => $a['v3_title'] ),
								array( 'badge' => 'BG', 'url' => $a['v4_url'], 'title' => $a['v4_title'] ),
							),
						),
					),
				),
			),
		),
		array(
			'mon'            => '03',
			'tag_type'       => 'ly-thuyet',
			'tag_label'      => 'Lý thuyết',
			'title'          => $a['m3_title'],
			'wrap_title_span' => true,
			'is_traffic_law' => false,
			'metas'          => array( $a['m3_meta'] ),
			'sub'            => $a['m3_sub'],
			'toggle'         => 'chap-dao-duc',
			'down_aria'      => 'Mở danh mục môn Đạo đức người lái xe, văn hóa giao thông, phòng chống tác hại của rượu bia, kỹ năng PCCC và CNCH',
			'play_aria'      => 'Phát video',
			'detail_id'      => 'syllDetail-chap-dao-duc-static',
			'phans'          => array(
				array(
					'id'         => 'phan-chap-03-static',
					'class'      => 'phan phan--II has-chip',
					'roman'      => 'III',
					'chip'       => 'Môn 3',
					'title'      => 'Đạo đức người lái xe, văn hóa GT và phòng chống tác hại của rượu, bia khi tham gia GT, kỹ năng PCCC và CNCH',
					'count_meta' => '06 mục',
					'desc'       => '',
					'chapters'   => array(
						array( 'type' => 'chip', 'num' => '1', 'chip' => 'Chương 1', 'title' => 'Những vấn đề cơ bản về phẩm chất đạo đức trong giai đoạn hiện nay' ),
						array( 'type' => 'chip', 'num' => '2', 'chip' => 'Chương 2', 'title' => 'Đạo đức của người lái xe' ),
						array(
							'type'  => 'featured_lessons',
							'id'    => 'chap-full-03-van-hoa-static',
							'chip'  => 'Chương 3',
							'title' => 'Văn hóa giao thông',
							'desc'  => 'Rèn văn hóa giao thông và ý thức trách nhiệm, để mỗi hành trình an toàn, văn minh hơn cho bạn và mọi người. Đăng ký khóa học để trở thành người lái xe trách nhiệm.',
							'items' => array(
								array( 'badge' => 'BG', 'title' => 'Văn hóa giao thông và trách nhiệm của người lái xe', 'tag_class' => 'tag-blue', 'tag_label' => 'Bài giảng' ),
							),
						),
						array(
							'type'  => 'featured_lessons',
							'id'    => 'chap-full-03-ruou-bia-static',
							'chip'  => 'Chương 4',
							'title' => 'Phòng, chống tác hại của rượu, bia khi tham gia giao thông',
							'desc'  => 'Hiểu tác hại của rượu, bia và cách phòng tránh rủi ro khi tham gia giao thông, giúp bạn chọn phương án an toàn cho mình và cộng đồng. Đăng ký học ngay để xây dựng thói quen lái xe an toàn.',
							'items' => array(
								array( 'badge' => 'BG', 'title' => 'Phòng, chống tác hại của rượu, bia khi tham gia giao thông', 'tag_class' => 'tag-fire', 'tag_label' => 'Bài giảng' ),
							),
						),
						array(
							'type'  => 'featured_lessons',
							'id'    => 'chap-full-03-so-cap-cuu-static',
							'chip'  => 'Chương 5',
							'title' => 'Thực hành sơ cấp cứu',
							'desc'  => 'Học kỹ năng sơ cấp cứu cơ bản để biết cách hỗ trợ ban đầu khi xảy ra tai nạn. Đăng ký học để sẵn sàng giúp đỡ người gặp nạn.',
							'items' => array(
								array( 'badge' => 'BG', 'title' => 'Kỹ năng sơ cấp cứu cơ bản khi xảy ra tai nạn giao thông', 'tag_class' => 'tag-green', 'tag_label' => 'Bài giảng' ),
							),
						),
						array( 'type' => 'chip', 'num' => '6', 'chip' => 'Chương 6', 'title' => 'Hướng dẫn kỹ năng phòng cháy, chữa cháy và cứu nạn, cứu hộ' ),
					),
				),
			),
		),
		array(
			'mon'            => '04',
			'tag_type'       => 'thuc-hanh',
			'tag_label'      => 'Thực hành',
			'title'          => $a['m4_title'],
			'is_traffic_law' => false,
			'metas'          => array( $a['m4_meta'] ),
			'sub'            => $a['m4_sub'],
			'toggle'         => 'chap-ky-thuat',
			'down_aria'      => 'Mở danh mục môn Kỹ thuật lái xe',
			'play_aria'      => 'Phát video',
			'detail_id'      => 'syllDetail-chap-ky-thuat-static',
			'phans'          => array(
				array(
					'id'         => 'phan-chap-05-static',
					'class'      => 'phan phan--I has-chip',
					'roman'      => 'IV',
					'chip'       => 'Môn 4',
					'title'      => 'Kỹ thuật lái xe',
					'count_meta' => '09 mục',
					'desc'       => '',
					'chapters'   => array(
						array(
							'type'  => 'featured_videos',
							'id'    => 'chap-full-05-buong-lai-static',
							'chip'  => 'Chương 1',
							'title' => 'Vị trí, tác dụng các bộ phận trong buồng lái',
							'desc'  => 'Khám phá buồng lái qua bài giảng 360°, nhận biết vị trí và chức năng các bộ phận để làm quen xe trước giờ thực hành. Đăng ký học ngay để tự tin hơn khi vào buồng lái.',
							'items' => array(
								array( 'badge' => '360°', 'url' => $a['v5_url'], 'title' => $a['v5_title'] ),
							),
						),
						array( 'type' => 'chip', 'num' => '2', 'chip' => 'Chương 2', 'title' => 'Kỹ thuật lái xe cơ bản' ),
						array( 'type' => 'chip', 'num' => '3', 'chip' => 'Chương 3', 'title' => 'Kỹ thuật lái xe trên các loại đường' ),
						array( 'type' => 'chip', 'num' => '4', 'chip' => 'Chương 4', 'title' => 'Kỹ thuật lái xe an toàn chủ động' ),
						array( 'type' => 'chip', 'num' => '5', 'chip' => 'Chương 5', 'title' => 'Kỹ thuật lái xe ô tô chở hàng hóa' ),
						array( 'type' => 'chip', 'num' => '6', 'chip' => 'Chương 6', 'title' => 'Tâm lý điều khiển xe ô tô' ),
						array(
							'type'  => 'featured_lsh',
							'id'    => 'chap-full-05-sa-hinh-static',
							'chip'  => 'Chương 7',
							'title' => 'Phương pháp thực hành lái xe tổng hợp',
							'desc'  => 'Luyện 11 bài tập từ xuất phát đến kết thúc bài sát hạch, làm quen trình tự và củng cố kỹ năng lái. Đăng ký học ngay để tự tin hơn trước ngày sát hạch.',
							'cards' => array(
								array( 'slug' => 'bai-1', 'num' => '1', 'text' => 'Xuất phát' ),
								array( 'slug' => 'bai-2', 'num' => '2', 'text' => 'Dừng xe nhường đường cho người đi bộ' ),
								array( 'slug' => 'bai-3', 'num' => '3', 'text' => 'Dừng xe và khởi hành ngang dốc' ),
								array( 'slug' => 'bai-4', 'num' => '4', 'text' => 'Qua vệt bánh xe và đường hẹp vuông góc' ),
								array( 'slug' => 'bai-5', 'num' => '5', 'text' => 'Qua ngã tư có đèn tín hiệu giao thông' ),
								array( 'slug' => 'bai-6', 'num' => '6', 'text' => 'Đường vòng quanh co' ),
								array( 'slug' => 'bai-7', 'num' => '7', 'text' => 'Ghép xe dọc vào nơi đỗ' ),
								array( 'slug' => 'bai-8', 'num' => '8', 'text' => 'Tạm dừng ở nơi có đường sắt chạy qua' ),
								array( 'slug' => 'bai-9', 'num' => '9', 'text' => 'Thay đổi số trên đường bằng' ),
								array( 'slug' => 'bai-10', 'num' => '10', 'text' => 'Ghép xe ngang vào nơi đỗ' ),
								array( 'slug' => 'bai-11', 'num' => '11', 'text' => 'Bài kết thúc' ),
							),
						),
						array( 'type' => 'chip', 'num' => '8', 'chip' => 'Chương 8', 'title' => 'Kỹ thuật kiểm tra, quan sát an toàn, chỉnh gương chiếu hậu trước khi cho xe tập lái xuất phát' ),
						array( 'type' => 'chip', 'num' => '9', 'chip' => 'Chương 9', 'title' => 'Kỹ thuật thực hiện các tình huống học lái xe ô tô' ),
					),
				),
			),
		),
		array(
			'mon'            => '05',
			'tag_type'       => 'mo-phong',
			'tag_label'      => 'Mô phỏng',
			'title'          => $a['m5_title'],
			'is_traffic_law' => false,
			'metas'          => array( $a['m5_meta'] ),
			'sub'            => $a['m5_sub'],
			'toggle'         => '',
			'down_aria'      => '',
			'play_aria'      => 'Phát video môn Phần mềm mô phỏng tình huống giao thông',
			'detail_id'      => '',
			'phans'          => array(),
		),
		array(
			'mon'            => '06',
			'tag_type'       => 'thuc-hanh',
			'tag_label'      => 'Thực hành',
			'title'          => $a['m6_title'],
			'is_traffic_law' => false,
			'metas'          => array( $a['m6_meta'] ),
			'sub'            => $a['m6_sub'],
			'toggle'         => 'chap-thuc-hanh',
			'down_aria'      => 'Mở danh mục môn Thực hành lái xe',
			'play_aria'      => 'Phát video',
			'detail_id'      => 'syllDetail-chap-thuc-hanh-static',
			'phans'          => array(
				array(
					'id'         => 'phan-chap-06-static',
					'class'      => 'phan phan--II has-chip',
					'roman'      => 'VI',
					'chip'       => 'Môn 6',
					'title'      => 'Thực hành lái xe',
					'count_meta' => '04 mục',
					'desc'       => '',
					'chapters'   => array(
						array( 'type' => 'chip', 'num' => '1', 'chip' => 'Chương 1', 'title' => 'Tập lái xe trên xe ô tô được kê kích' ),
						array( 'type' => 'chip', 'num' => '2', 'chip' => 'Chương 2', 'title' => 'Tập lái xe trên sân tập lái' ),
						array( 'type' => 'chip', 'num' => '3', 'chip' => 'Chương 3', 'title' => 'Tập lái xe trên đường giao thông' ),
						array( 'type' => 'chip', 'num' => '4', 'chip' => 'Chương 4', 'title' => 'Ôn luyện theo các nội dung sát hạch lái xe' ),
					),
				),
			),
		),
	);

	/**
	 * Filter the 6-subject curriculum dataset.
	 *
	 * @param array $subjects Curriculum subjects array.
	 * @param array $a        Shortcode attributes.
	 */
	$subjects = apply_filters( 'hpo_curriculum_subjects', $subjects, $a );

	$caret_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9" /></svg>';
	$play_svg  = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z" /></svg>';

	ob_start();
	?>
	<section
	  class="syll syll--chapters syll--chapters-color-bg syll--chapters-html platform-v2-curriculum"
	  id="<?php echo esc_attr( $section_id ); ?>"
	  aria-labelledby="<?php echo esc_attr( $section_id . '-title' ); ?>"
	>
	  <div class="container">
	    <div class="curr-head curr-head--chapters">
	      <div data-reveal>
	        <span class="eyebrow"><?php echo esc_html( $a['eyebrow'] ); ?></span>
	        <h4
	          class="sec-title sec-title--new-color"
	          id="<?php echo esc_attr( $section_id . '-title' ); ?>"
	        >
	          <?php echo esc_html( $a['title_prefix'] ); ?>
	          <span class="pv-accent"><?php echo esc_html( $a['title_accent'] ); ?></span>
	        </h4>
	      </div>
	    </div>

	    <div
	      class="syll-list syll-list--chapters"
	      data-reveal
	      data-delay="1"
	    >
	      <?php foreach ( $subjects as $subj ) : ?>
	        <div
	          class="syll-row"
	          data-mon="<?php echo esc_attr( $subj['mon'] ); ?>"
	        >
	          <span class="syll-num"><?php echo esc_html( $subj['mon'] ); ?></span>
	          <span
	            class="syll-tag"
	            data-type="<?php echo esc_attr( $subj['tag_type'] ); ?>"
	            ><?php echo esc_html( $subj['tag_label'] ); ?></span
	          >
	          <?php if ( ! empty( $subj['is_traffic_law'] ) ) : ?>
	            <div class="syll-title syll-title--traffic-law">
	              <div class="syll-title-main">
	                <?php echo esc_html( $subj['title'] ); ?>
	              </div>
	              <div class="syll-title-meta">
	                <?php foreach ( $subj['metas'] as $meta ) : ?>
	                  <span class="syll-meta"><?php echo esc_html( $meta ); ?></span>
	                <?php endforeach; ?>
	              </div>
	              <small><?php echo esc_html( $subj['sub'] ); ?></small>
	            </div>
	          <?php else : ?>
	            <div class="syll-title">
	              <?php if ( ! empty( $subj['wrap_title_span'] ) ) : ?>
	                <span class="syll-title-main"><?php echo esc_html( $subj['title'] ); ?></span>
	              <?php else : ?>
	                <?php echo esc_html( $subj['title'] ); ?>
	              <?php endif; ?>
	              <?php foreach ( $subj['metas'] as $meta ) : ?>
	                <span class="syll-meta"><?php echo esc_html( $meta ); ?></span>
	              <?php endforeach; ?>
	              <small><?php echo esc_html( $subj['sub'] ); ?></small>
	            </div>
	          <?php endif; ?>

	          <?php if ( ! empty( $subj['toggle'] ) ) : ?>
	            <button
	              type="button"
	              class="syll-down"
	              aria-label="<?php echo esc_attr( $subj['down_aria'] ); ?>"
	              aria-expanded="false"
	              data-toggle="<?php echo esc_attr( $subj['toggle'] ); ?>"
	            >
	              <?php echo $caret_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	            </button>
	          <?php else : ?>
	            <span></span>
	          <?php endif; ?>
	          <button
	            type="button"
	            class="syll-play"
	            aria-label="<?php echo esc_attr( $subj['play_aria'] ); ?>"
	          >
	            <?php echo $play_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	          </button>
	        </div>

	        <?php if ( ! empty( $subj['detail_id'] ) && ! empty( $subj['phans'] ) ) : ?>
	          <div
	            class="syll-detail is-redesigned"
	            id="<?php echo esc_attr( $subj['detail_id'] ); ?>"
	          >
	            <div class="syll-detail-inner">
	              <div class="mon-body-pad">
	                <?php foreach ( $subj['phans'] as $phan ) : ?>
	                  <div
	                    class="<?php echo esc_attr( $phan['class'] ); ?>"
	                    id="<?php echo esc_attr( $phan['id'] ); ?>"
	                  >
	                    <div
	                      class="phan-header"
	                      data-phan-toggle="<?php echo esc_attr( $phan['id'] ); ?>"
	                      role="button"
	                      tabindex="0"
	                      aria-expanded="false"
	                    >
	                      <div class="phan-stripe"></div>
	                      <div class="phan-header-inner">
	                        <div class="phan-roman"><?php echo esc_html( $phan['roman'] ); ?></div>
	                        <div class="phan-text">
	                          <div class="phan-title">
	                            <span class="phan-chip"><?php echo esc_html( $phan['chip'] ); ?></span><?php echo esc_html( $phan['title'] ); ?><span
	                              class="phan-count-meta"
	                              ><?php echo esc_html( $phan['count_meta'] ); ?></span
	                            >
	                          </div>
	                          <?php if ( ! empty( $phan['desc'] ) ) : ?>
	                            <div class="phan-desc">
	                              <?php echo nl2br( esc_html( $phan['desc'] ) ); ?>
	                            </div>
	                          <?php endif; ?>
	                        </div>
	                      </div>
	                      <div class="phan-caret">
	                        <?php echo $caret_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	                      </div>
	                    </div>
	                    <div class="phan-body">
	                      <div class="phan-body-inner">
	                        <div class="phan-body-pad">
	                          <div class="chap-list">
	                            <?php foreach ( $phan['chapters'] as $ch ) : ?>
	                              <?php if ( 'plain' === $ch['type'] ) : ?>
	                                <div class="chap">
	                                  <div class="chap-row">
	                                    <div class="chap-num-wrap"><?php echo esc_html( $ch['num'] ); ?></div>
	                                    <div class="chap-info">
	                                      <div class="chap-title">
	                                        <?php echo esc_html( $ch['title'] ); ?>
	                                      </div>
	                                    </div>
	                                  </div>
	                                </div>
	                              <?php elseif ( 'chip' === $ch['type'] ) : ?>
	                                <div class="chap">
	                                  <div class="chap-row">
	                                    <div class="chap-num-wrap"><?php echo esc_html( $ch['num'] ); ?></div>
	                                    <div class="chap-info">
	                                      <div class="chap-title">
	                                        <span class="chap-chip"><?php echo esc_html( $ch['chip'] ); ?></span><?php echo esc_html( $ch['title'] ); ?>
	                                      </div>
	                                    </div>
	                                  </div>
	                                </div>
	                              <?php elseif ( 'featured_bb' === $ch['type'] ) : ?>
	                                <div
	                                  class="chap is-featured"
	                                  id="<?php echo esc_attr( $ch['id'] ); ?>"
	                                >
	                                  <div class="chap-row">
	                                    <div class="chap-info">
	                                      <div class="chap-title">
	                                        <span class="chap-chip"><?php echo esc_html( $ch['chip'] ); ?></span><?php echo esc_html( $ch['title'] ); ?>
	                                      </div>
	                                      <p class="chap-desc">
	                                        <?php echo esc_html( $ch['desc'] ); ?>
	                                      </p>
	                                    </div>
	                                  </div>
	                                  <div class="bb-grid">
	                                    <?php foreach ( $ch['cards'] as $card ) : ?>
	                                      <a
	                                        class="bb-card"
	                                        href="<?php echo esc_attr( '#' . $card['slug'] ); ?>"
	                                        data-bb-view="<?php echo esc_attr( $card['slug'] ); ?>"
	                                        aria-haspopup="dialog"
	                                      >
	                                        <div class="bb-name"><?php echo esc_html( $card['name'] ); ?></div>
	                                        <div class="bb-icon">
	                                          <img
	                                            src="<?php echo esc_url( $card['img'] ); ?>"
	                                            alt="<?php echo esc_attr( $card['alt'] ); ?>"
	                                          />
	                                        </div>
	                                        <div class="bb-shape">
	                                          <?php echo esc_html( $card['shape_text'] ); ?>
	                                          <em class="bb-shape-color <?php echo esc_attr( $card['color_class'] ); ?>"
	                                            ><?php echo esc_html( $card['color_label'] ); ?></em
	                                          >
	                                        </div>
	                                        <div class="bb-count">
	                                          <?php echo esc_html( $card['count'] ); ?>
	                                          <small>kiểu</small>
	                                        </div>
	                                      </a>
	                                    <?php endforeach; ?>
	                                  </div>
	                                </div>
	                              <?php elseif ( 'featured_sh' === $ch['type'] ) : ?>
	                                <div
	                                  class="chap is-featured is-open"
	                                  id="<?php echo esc_attr( $ch['id'] ); ?>"
	                                >
	                                  <div class="chap-row">
	                                    <div class="chap-info">
	                                      <div class="chap-title">
	                                        <span class="chap-chip"><?php echo esc_html( $ch['chip'] ); ?></span><?php echo esc_html( $ch['title'] ); ?>
	                                      </div>
	                                      <p class="chap-desc">
	                                        <?php echo esc_html( $ch['desc'] ); ?>
	                                      </p>
	                                    </div>
	                                  </div>
	                                  <div class="sa-grid">
	                                    <?php foreach ( $ch['cards'] as $card ) : ?>
	                                      <a
	                                        class="sa-card"
	                                        href="<?php echo esc_attr( '#' . $card['slug'] ); ?>"
	                                        data-sh-view="<?php echo esc_attr( $card['slug'] ); ?>"
	                                        aria-haspopup="dialog"
	                                      >
	                                        <div class="sa-num"><?php echo esc_html( $card['num'] ); ?></div>
	                                        <div class="sa-text"><?php echo esc_html( $card['text'] ); ?></div>
	                                      </a>
	                                    <?php endforeach; ?>
	                                  </div>
	                                </div>
	                              <?php elseif ( 'featured_lsh' === $ch['type'] ) : ?>
	                                <div
	                                  class="chap is-featured is-open"
	                                  id="<?php echo esc_attr( $ch['id'] ); ?>"
	                                >
	                                  <div class="chap-row">
	                                    <div class="chap-info">
	                                      <div class="chap-title">
	                                        <span class="chap-chip"><?php echo esc_html( $ch['chip'] ); ?></span><?php echo esc_html( $ch['title'] ); ?>
	                                      </div>
	                                      <p class="chap-desc">
	                                        <?php echo esc_html( $ch['desc'] ); ?>
	                                      </p>
	                                    </div>
	                                  </div>
	                                  <div class="sa-grid">
	                                    <?php foreach ( $ch['cards'] as $card ) : ?>
	                                      <a
	                                        class="sa-card"
	                                        href="<?php echo esc_attr( '#' . $card['slug'] ); ?>"
	                                        data-lsh-view="<?php echo esc_attr( $card['slug'] ); ?>"
	                                        aria-haspopup="dialog"
	                                      >
	                                        <div class="sa-num"><?php echo esc_html( $card['num'] ); ?></div>
	                                        <div class="sa-text"><?php echo esc_html( $card['text'] ); ?></div>
	                                      </a>
	                                    <?php endforeach; ?>
	                                  </div>
	                                </div>
	                              <?php elseif ( 'featured_engine' === $ch['type'] ) : ?>
	                                <div
	                                  class="chap is-featured is-open"
	                                  id="<?php echo esc_attr( $ch['id'] ); ?>"
	                                >
	                                  <div class="chap-row">
	                                    <div class="chap-info">
	                                      <div class="chap-title">
	                                        <span class="chap-chip"><?php echo esc_html( $ch['chip'] ); ?></span><?php echo esc_html( $ch['title'] ); ?>
	                                      </div>
	                                      <p class="chap-desc">
	                                        <?php echo esc_html( $ch['desc'] ); ?>
	                                      </p>
	                                    </div>
	                                  </div>
	                                  <div class="chap-content-pad">
	                                    <div class="chap-list">
	                                      <?php foreach ( $ch['items'] as $item ) : ?>
	                                        <a
	                                          class="chap"
	                                          href="<?php echo esc_attr( $item['href'] ); ?>"
	                                          data-engine-view="<?php echo esc_attr( $item['view'] ); ?>"
	                                          aria-haspopup="dialog"
	                                        >
	                                          <div class="chap-row">
	                                            <div
	                                              class="chap-num-wrap"
	                                              style="font-size: 11px"
	                                            >
	                                              <?php echo esc_html( $item['badge'] ); ?>
	                                            </div>
	                                            <div class="chap-info">
	                                              <div class="chap-title">
	                                                <?php echo esc_html( $item['title'] ); ?>
	                                              </div>
	                                            </div>
	                                            <div class="chap-action">
	                                              <span class="chap-tag <?php echo esc_attr( $item['tag_class'] ); ?>"
	                                                ><?php echo esc_html( $item['tag_label'] ); ?></span
	                                              >
	                                            </div>
	                                          </div>
	                                        </a>
	                                      <?php endforeach; ?>
	                                    </div>
	                                  </div>
	                                </div>
	                              <?php elseif ( 'featured_videos' === $ch['type'] ) : ?>
	                                <div
	                                  class="chap is-featured is-open"
	                                  id="<?php echo esc_attr( $ch['id'] ); ?>"
	                                >
	                                  <div class="chap-row">
	                                    <div class="chap-info">
	                                      <div class="chap-title">
	                                        <span class="chap-chip"><?php echo esc_html( $ch['chip'] ); ?></span><?php echo esc_html( $ch['title'] ); ?>
	                                      </div>
	                                      <p class="chap-desc">
	                                        <?php echo esc_html( $ch['desc'] ); ?>
	                                      </p>
	                                    </div>
	                                  </div>
	                                  <div class="chap-content-pad">
	                                    <div class="chap-list">
	                                      <?php foreach ( $ch['items'] as $item ) :
	                                        $video_id = '';
	                                        if ( ! empty( $item['url'] ) && preg_match( '~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|v/|shorts/))([a-zA-Z0-9_-]+)~', $item['url'], $m ) ) {
	                                          $video_id = $m[1];
	                                        }
	                                      ?>
	                                        <div
	                                          class="chap chap--video"
	                                          data-chap-video-src="<?php echo esc_url( $item['url'] ); ?>"
	                                          data-chap-video-title="<?php echo esc_attr( $item['title'] ); ?>"
	                                          <?php if ( $video_id ) : ?>data-video-id="<?php echo esc_attr( $video_id ); ?>"<?php endif; ?>
	                                          role="button"
	                                          tabindex="0"
	                                          aria-haspopup="dialog"
	                                        >
	                                          <div class="chap-row">
	                                            <div
	                                              class="chap-num-wrap"
	                                              style="font-size: 11px"
	                                            >
	                                              <?php echo esc_html( $item['badge'] ); ?>
	                                            </div>
	                                            <div class="chap-info">
	                                              <div class="chap-title">
	                                                <?php echo esc_html( $item['title'] ); ?>
	                                              </div>
	                                            </div>
	                                            <div class="chap-action">
	                                              <span
	                                                class="chap-play"
	                                                aria-hidden="true"
	                                                ><?php echo $play_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span
	                                              >
	                                            </div>
	                                          </div>
	                                        </div>
	                                      <?php endforeach; ?>
	                                    </div>
	                                  </div>
	                                </div>
	                              <?php elseif ( 'featured_lessons' === $ch['type'] ) : ?>
	                                <div
	                                  class="chap is-featured"
	                                  id="<?php echo esc_attr( $ch['id'] ); ?>"
	                                >
	                                  <div class="chap-row">
	                                    <div class="chap-info">
	                                      <div class="chap-title">
	                                        <span class="chap-chip"><?php echo esc_html( $ch['chip'] ); ?></span><?php echo esc_html( $ch['title'] ); ?>
	                                      </div>
	                                      <p class="chap-desc">
	                                        <?php echo esc_html( $ch['desc'] ); ?>
	                                      </p>
	                                    </div>
	                                  </div>
	                                  <div class="chap-content-pad">
	                                    <div class="chap-list">
	                                      <?php foreach ( $ch['items'] as $item ) : ?>
	                                        <div class="chap">
	                                          <div class="chap-row">
	                                            <div
	                                              class="chap-num-wrap"
	                                              style="font-size: 11px"
	                                            >
	                                              <?php echo esc_html( $item['badge'] ); ?>
	                                            </div>
	                                            <div class="chap-info">
	                                              <div class="chap-title">
	                                                <?php echo esc_html( $item['title'] ); ?>
	                                              </div>
	                                            </div>
	                                            <div class="chap-action">
	                                              <span class="chap-tag <?php echo esc_attr( $item['tag_class'] ); ?>"
	                                                ><?php echo esc_html( $item['tag_label'] ); ?></span
	                                              >
	                                            </div>
	                                          </div>
	                                        </div>
	                                      <?php endforeach; ?>
	                                    </div>
	                                  </div>
	                                </div>
	                              <?php endif; ?>
	                            <?php endforeach; ?>
	                          </div>
	                        </div>
	                      </div>
	                    </div>
	                  </div>
	                <?php endforeach; ?>
	              </div>
	            </div>
	          </div>
	        <?php endif; ?>
	      <?php endforeach; ?>
	    </div>
	  </div>
	</section>
	<?php
	return trim( ob_get_clean() );
}
add_shortcode( 'hpo_curriculum', 'hpo_shortcode_curriculum' );
