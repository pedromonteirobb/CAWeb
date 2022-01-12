<?php
/**
 * CAWeb Icon Font Library
 *
 * @package CAWeb
 */

add_filter( 'et_pb_font_icon_symbols', 'caweb_et_pb_font_icon_symbols' );

/**
 * Merger of Divi and CAWeb Icon Font Library
 * This filter is applied by Divi
 *
 * @see Divi includes/builder/functions.php Line 405
 * @version 4.0.7
 * @param  array $divi_symbols Array of Divi Symbols.
 *
 * @return array
 */
function caweb_et_pb_font_icon_symbols( $divi_symbols = array() ) {
	$icons = caweb_symbols( -1, '', '', false );
	return array_values( $icons );
}


if ( ! function_exists( 'et_pb_get_extended_font_icon_symbols' ) ) :
	/**
	 * Returns full list of all icons used in the Divi with ['search_terms'],
	 * unicode icon value ['unicode'], icon name ['name']
	 * groups in which the icon is included ['styles'],
	 * bool flag which determined is this icon a divi icon or FontAwesome icon['is_divi_icon'].
	 *
	 * @since ?
	 *
	 * @return array
	 */
	function et_pb_get_extended_font_icon_symbols() {
		$cache_key = 'et_pb_get_extended_font_icon_symbols';
		if ( ! et_core_cache_has( $cache_key ) ) {
			$full_icons_list_path = CAWEB_ABSPATH . '/assets/full_icons_list.json';
			$divi_icons_list_path = get_template_directory() . '/includes/builder/feature/icon-manager/full_icons_list.json';
			$fa_icons             = array();

			if ( file_exists( $divi_icons_list_path ) ) {
				// phpcs:disable
				$divi_icons = json_decode( file_get_contents( $divi_icons_list_path ), true );
				// phpcs:enable
				$fa_icons = array_filter(
					$divi_icons,
					function( $icon ) {
						return in_array( 'fa', $icon['styles'], true );
					}
				);

				// add glyph to font awesome icons.
				foreach ( $fa_icons as $i => $icon ) {
					$icon['glyph']  = $icon['name'];
					$fa_icons[ $i ] = $icon;
				}
			}

			if ( file_exists( $full_icons_list_path ) ) {
				// phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Can't use wp_remote_get() for local file
				$icons_data = json_decode( file_get_contents( $full_icons_list_path ), true );

				if ( ! empty( $fa_icons ) ) {
					$icons_data = array_merge( $icons_data, $fa_icons );
				}
				// phpcs:enable
				if ( JSON_ERROR_NONE === json_last_error() ) {
					et_core_cache_set( $cache_key, $icons_data );
					return $icons_data;
				}
			}
			et_wrong( 'Problem with loading the icon data on this path: ' . $full_icons_list_path );
		} else {
			return et_core_cache_get( $cache_key );
		}
	}
endif;

/**
 * CA.gov Icon Library List
 *
 * @param  int    $index Icon index.
 * @param  string $icon_code Icon code.
 * @param  string $icon_name Icon name.
 * @param  bool   $extended Whether to include extended icons.
 *
 * @return array
 */
function caweb_symbols( $index = -1, $icon_code = '', $icon_name = '', $extended = true ) {
	$icons   = et_pb_get_extended_font_icon_symbols();
	$symbols = array();
	$fa      = array();
	foreach ( $icons as $i => $icon ) {
		$glyph = isset( $icon['glyph'] ) ? $icon['glyph'] : $icon['name'];

		// if symbol was not already added.
		if ( ! isset( $symbols[ $glyph ] ) ) {
			$symbols[ $glyph ] = $icon;

			// if not extended, unicode is set, and remove font awesome icons.
			if ( ! $extended && isset( $icon['unicode'] ) ) {
				$symbols[ $glyph ] = ! in_array( 'fa', $icon['styles'], true ) ? $icon['unicode'] : '';
			}
		}
	}

	$symbols = array_filter( $symbols );

	if ( 0 <= $index ) {
		$values = array_values( $symbols );
		return isset( $values[ $index ] ) ? $values[ $index ]['glyph'] : '';
	}

	if ( ! empty( $icon_code ) ) {
		$name = '';
		foreach ( $symbols as $n => $icon ) {

			if ( $extended ) {
				if ( $icon_code === $icon['unicode'] ) {
					$name = $n;
					break;
				}
			} elseif ( $icon_code === $icon ) {
				$name = $n;
				break;
			}
		}

		return $name;
	}

	if ( ! empty( $icon_name ) ) {
		if ( isset( $symbols[ $icon_name ] ) ) {
			return $extended ? $symbols[ $icon_name ]['unicode'] : $symbols[ $icon_name ];
		}

		return '';
	}

	return $symbols;

}

/**
 * Looking for a way to automate everything below here by opening the SVG file.
 */

/**
 * This array is required and needs to be updated whenever new icons are added,
 * this ensures that icons appear in the list in the correct order
 *
 * @return array
 */
function caweb_icons() {
	return array(
		'logo'                      => '&#xe600;',
		'home'                      => '&#xe601;',
		'menu'                      => '&#xe602;',
		'apps'                      => '&#xe603;',
		'search'                    => '&#xe604;',
		'chat'                      => '&#xe605;',
		'capitol'                   => '&#xe606;',
		'state'                     => '&#xe607;',
		'phone'                     => '&#xe608;',
		'email'                     => '&#xe609;',
		'contact-us'                => '&#xe66e;',
		'calendar'                  => '&#xe60a;',
		'bear'                      => '&#xe60b;',
		'chat-bubble'               => '&#xe66f;',
		'info-bubble'               => '&#xe670;',
		'share-button'              => '&#xe671;',
		'share-facebook'            => '&#xe672;',
		'share-email'               => '&#xe673;',
		'share-flickr'              => '&#xe674;',
		'share-twitter'             => '&#xe675;',
		'share-linkedin'            => '&#xe676;',
		'share-googleplus'          => '&#xe677;',
		'share-instagram'           => '&#xe678;',
		'share-pinterest'           => '&#xe679;',
		'share-vimeo'               => '&#xe67a;',
		'share-youtube'             => '&#xe67b;',
		'law-enforcement'           => '&#xe60c;',
		'justice-legal'             => '&#xe60d;',
		'at-sign'                   => '&#xe60e;',
		'attachment'                => '&#xe60f;',
		'zipped-file'               => '&#xe610;',
		'powerpoint'                => '&#xe611;',
		'excel'                     => '&#xe612;',
		'word'                      => '&#xe613;',
		'pdf'                       => '&#xe614;',
		'share'                     => '&#x2022;',
		'facebook'                  => '&#xe616;',
		'linkedin'                  => '&#xe617;',
		'youtube'                   => '&#xe618;',
		'twitter'                   => '&#xe619;',
		'pinterest'                 => '&#xe61a;',
		'vimeo'                     => '&#xe61b;',
		'instagram'                 => '&#xe61c;',
		'flickr'                    => '&#xe61d;',
		'google-plus'               => '&#xe66d;',
		'microsoft'                 => '&#xe61e;',
		'apple'                     => '&#xe61f;',
		'android'                   => '&#xe620;',
		'computer'                  => '&#xe621;',
		'tablet'                    => '&#xe622;',
		'smartphone'                => '&#xe623;',
		'roadways'                  => '&#xe624;',
		'travel-car'                => '&#xe625;',
		'travel-air'                => '&#xe626;',
		'truck-delivery'            => '&#xe627;',
		'construction'              => '&#xe628;',
		'bar-chart'                 => '&#xe629;',
		'pie-chart'                 => '&#xe62a;',
		'graph'                     => '&#xe62b;',
		'server'                    => '&#xe62c;',
		'download'                  => '&#xe62d;',
		'cloud-download'            => '&#xe62e;',
		'cloud-upload'              => '&#xe62f;',
		'shield'                    => '&#xe630;',
		'fire'                      => '&#xe631;',
		'binoculars'                => '&#xe632;',
		'compass'                   => '&#xe633;',
		'sos'                       => '&#xe634;',
		'shopping-cart'             => '&#xe635;',
		'video-camera'              => '&#xe636;',
		'camera'                    => '&#xe637;',
		'green'                     => '&#xe638;',
		'loud-speaker'              => '&#xe639;',
		'audio'                     => '&#xe094;',
		'print'                     => '&#xe63b;',
		'medical'                   => '&#xe63c;',
		'zoom-out'                  => '&#xe63d;',
		'zoom-in'                   => '&#xe63e;',
		'important'                 => '&#xe63f;',
		'chat-bubbles'              => '&#xe640;',
		'call'                      => '&#xe641;',
		'people'                    => '&#xe642;',
		'person'                    => '&#xe643;',
		'user-id'                   => '&#xe644;',
		'payment-card'              => '&#xe645;',
		'skip-backwards'            => '&#xe646;',
		'play'                      => '&#xe647;',
		'pause'                     => '&#xe648;',
		'skip-forward'              => '&#xe649;',
		'mail'                      => '&#xe64a;',
		'image'                     => '&#xe64b;',
		'house'                     => '&#xe64c;',
		'gear'                      => '&#xe64d;',
		'tool'                      => '&#xe64e;',
		'time'                      => '&#xe64f;',
		'cal'                       => '&#xe650;',
		'check-list'                => '&#xe651;',
		'document'                  => '&#xe652;',
		'clipboard'                 => '&#xe653;',
		'page'                      => '&#xe654;',
		'read-book'                 => '&#xe655;',
		'cc-copyright'              => '&#xe656;',
		'ca-capitol'                => '&#xe657;',
		'ca-state'                  => '&#xe658;',
		'favorite'                  => '&#xe659;',
		'rss'                       => '&#xe65a;',
		'road-pin'                  => '&#xe65b;',
		'online-services'           => '&#xe65c;',
		'link'                      => '&#xe65d;',
		'magnify-glass'             => '&#xe65e;',
		'key'                       => '&#xe65f;',
		'lock'                      => '&#xe660;',
		'info'                      => '&#xe661;',
		'arrow-up'                  => '&#xe04b;',
		'arrow-down'                => '&#xe04c;',
		'arrow-left'                => '&#xe04d;',
		'arrow-right'               => '&#xe04e;',
		'carousel-prev'             => '&#xe666;',
		'carousel-next'             => '&#xe667;',
		'arrow-prev'                => '&#xe668;',
		'arrow-next'                => '&#xe669;',
		'menu-toggle-closed'        => '&#xe66a;',
		'menu-toggle-open'          => '&#xe66b;',
		'carousel-play'             => '&#xe907;',
		'carousel-pause'            => '&#xe66c;',
		'search-right'              => '&#x55;',
		'graduate'                  => '&#xe903;',
		'briefcase'                 => '&#xe901;',
		'images'                    => '&#xe904;',
		'gears'                     => '&#xe900;',
		'tools'                     => '&#xe035;',
		'pencil'                    => '&#x6a;',
		'pencil-edit'               => '&#x6c;',
		'science'                   => '&#xe00a;',
		'film'                      => '&#xe024;',
		'table'                     => '&#xe025;',
		'flowchart'                 => '&#xe0df;',
		'building'                  => '&#xe0fd;',
		'searching'                 => '&#xe0f7;',
		'wallet'                    => '&#xe0d8;',
		'tags'                      => '&#xe07c;',
		'currency'                  => '&#xe0f3;',
		'idea'                      => '&#xe902;',
		'lightbulb'                 => '&#xe072;',
		'calculator'                => '&#xe0e7;',
		'drive'                     => '&#xe0e5;',
		'globe'                     => '&#xe0e3;',
		'hourglass'                 => '&#xe0e1;',
		'mic'                       => '&#xe07f;',
		'volume'                    => '&#xe069;',
		'music'                     => '&#xe08e;',
		'folder'                    => '&#xe05c;',
		'grid'                      => '&#xe08c;',
		'archive'                   => '&#xe088;',
		'contacts'                  => '&#xe087;',
		'book'                      => '&#xe086;',
		'drawer'                    => '&#xe084;',
		'map'                       => '&#xe083;',
		'pushpin'                   => '&#xe082;',
		'location'                  => '&#xe081;',
		'quote-fill'                => '&#xe06a;',
		'question-fill'             => '&#xe064;',
		'warning-triangle'          => '&#xe063;',
		'warning-fill'              => '&#xe062;',
		'check-fill'                => '&#xe052;',
		'close-fill'                => '&#xe051;',
		'plus-fill'                 => '&#xe050;',
		'minus-fill'                => '&#xe04f;',
		'caret-fill-right'          => '&#xe046;',
		'caret-fill-left'           => '&#xe045;',
		'caret-fill-down'           => '&#xe044;',
		'caret-fill-up'             => '&#xe043;',
		'caret-fill-two-right'      => '&#xe04a;',
		'caret-fill-two-left'       => '&#xe049;',
		'caret-fill-two-down'       => '&#xe048;',
		'caret-fill-two-up'         => '&#xe047;',
		'arrow-fill-right'          => '&#xe03c;',
		'arrow-fill-left'           => '&#xe03b;',
		'arrow-fill-up'             => '&#xe039;',
		'arrow-fill-down'           => '&#xe03a;',
		'arrow-fill-left-down'      => '&#xe040;',
		'arrow-fill-right-down'     => '&#xe03f;',
		'arrow-fill-left-up'        => '&#xe03d;',
		'arrow-fill-right-up'       => '&#xe03e;',
		'triangle-line-right'       => '&#x49;',
		'triangle-line-left'        => '&#x48;',
		'triangle-line-up'          => '&#x46;',
		'triangle-line-down'        => '&#x47;',
		'caret-line-two-right'      => '&#x41;',
		'caret-line-two-left'       => '&#x40;',
		'caret-line-two-up'         => '&#x3e;',
		'caret-line-two-down'       => '&#x3f;',
		'caret-line-right'          => '&#x3d;',
		'caret-line-left'           => '&#x3c;',
		'caret-line-up'             => '&#x3a;',
		'caret-line-down'           => '&#x3b;',
		'important-line'            => '&#xe906;',
		'info-line'                 => '&#xe905;',
		'check-line'                => '&#x52;',
		'question-line'             => '&#xe908;',
		'close-line'                => '&#x51;',
		'plus-line'                 => '&#x50;',
		'minus-line'                => '&#x4f;',
		'question'                  => '&#xe909;',
		'minus-mark'                => '&#x4b;',
		'plus-mark'                 => '&#x4c;',
		'collapse'                  => '&#x58;',
		'expand'                    => '&#x59;',
		'check-mark'                => '&#x4e;',
		'close-mark'                => '&#x4d;',
		'triangle-right'            => '&#x45;',
		'triangle-left'             => '&#x44;',
		'triangle-up'               => '&#x42;',
		'triangle-down'             => '&#x43;',
		'caret-two-right'           => '&#x39;',
		'caret-two-left'            => '&#x38;',
		'caret-two-down'            => '&#x37;',
		'caret-two-up'              => '&#x36;',
		'caret-right'               => '&#x35;',
		'caret-left'                => '&#x34;',
		'caret-up'                  => '&#x32;',
		'caret-down'                => '&#x33;',
		'filter'                    => '&#xe90a;',
		'caweb'                     => '&#xc90b;',
		'arrow_up'                  => '&#x21;',
		'arrow_down'                => '&#x22;',
		'arrow_left'                => '&#x23;',
		'arrow_right'               => '&#x24;',
		'arrow_left-up'             => '&#x25;',
		'arrow_right-up'            => '&#x26;',
		'arrow_right-down'          => '&#x27;',
		'arrow_left-down'           => '&#x28;',
		'arrow-up-down'             => '&#x29;',
		'arrow_up-down_alt'         => '&#x2a;',
		'arrow_left-right_alt'      => '&#x2b;',
		'arrow_left-right'          => '&#x2c;',
		'arrow_expand_alt2'         => '&#x2d;',
		'arrow_expand_alt'          => '&#x2e;',
		'arrow_condense'            => '&#x2f;',
		'arrow_expand'              => '&#x30;',
		'arrow_move'                => '&#x31;',
		'arrow_back'                => '&#x4a;',
		'icon_zoom-out_alt'         => '&#x53;',
		'icon_zoom-in_alt'          => '&#x54;',
		'icon_box-empty'            => '&#x56;',
		'icon_box-selected'         => '&#x57;',
		'icon_box-checked'          => '&#x5a;',
		'icon_circle-empty'         => '&#x5b;',
		'icon_circle-slelected'     => '&#x5c;',
		'icon_stop_alt2'            => '&#x5d;',
		'icon_stop'                 => '&#x5e;',
		'icon_pause_alt2'           => '&#x5f;',
		'icon_pause'                => '&#x60;',
		'icon_menu'                 => '&#x61;',
		'icon_menu-square_alt2'     => '&#x62;',
		'icon_menu-circle_alt2'     => '&#x63;',
		'icon_ul'                   => '&#x64;',
		'icon_ol'                   => '&#x65;',
		'icon_adjust-horiz'         => '&#x66;',
		'icon_adjust-vert'          => '&#x67;',
		'icon_document_alt'         => '&#x68;',
		'icon_documents_alt'        => '&#x69;',
		'icon_pencil-edit_alt'      => '&#x6b;',
		'icon_folder-alt'           => '&#x6d;',
		'icon_folder-open_alt'      => '&#x6e;',
		'icon_folder-add_alt'       => '&#x6f;',
		'icon_error-circle_alt'     => '&#x72;',
		'icon_error-triangle_alt'   => '&#x73;',
		'icon_comment_alt'          => '&#x76;',
		'icon_chat_alt'             => '&#x77;',
		'icon_vol-mute_alt'         => '&#x78;',
		'icon_volume-low_alt'       => '&#x79;',
		'icon_volume-high_alt'      => '&#x7a;',
		'icon_quotations'           => '&#x7b;',
		'icon_quotations_alt2'      => '&#x7c;',
		'icon_clock_alt'            => '&#x7d;',
		'icon_lock_alt'             => '&#x7e;',
		'icon_lock-open_alt'        => '&#xe000;',
		'icon_key_alt'              => '&#xe001;',
		'icon_cloud_alt'            => '&#xe002;',
		'icon_cloud-upload_alt'     => '&#xe003;',
		'icon_cloud-download_alt'   => '&#xe004;',
		'icon_lightbulb_alt'        => '&#xe007;',
		'icon_house_alt'            => '&#xe009;',
		'icon_laptop'               => '&#xe00d;',
		'icon_camera_alt'           => '&#xe00f;',
		'icon_mail_alt'             => '&#xe010;',
		'icon_cone_alt'             => '&#xe011;',
		'icon_ribbon_alt'           => '&#xe012;',
		'icon_bag_alt'              => '&#xe013;',
		'icon_creditcard'           => '&#xe014;',
		'icon_cart_alt'             => '&#xe015;',
		'icon_paperclip'            => '&#xe016;',
		'icon_tag_alt'              => '&#xe017;',
		'icon_tags_alt'             => '&#xe018;',
		'icon_trash_alt'            => '&#xe019;',
		'icon_cursor_alt'           => '&#xe01a;',
		'icon_mic_alt'              => '&#xe01b;',
		'icon_compass_alt'          => '&#xe01c;',
		'icon_pin_alt'              => '&#xe01d;',
		'icon_pushpin_alt'          => '&#xe01e;',
		'icon_map_alt'              => '&#xe01f;',
		'icon_drawer_alt'           => '&#xe020;',
		'icon_toolbox_alt'          => '&#xe021;',
		'icon_book_alt'             => '&#xe022;',
		'icon_calendar'             => '&#xe023;',
		'icon_contacts_alt'         => '&#xe026;',
		'icon_headphones'           => '&#xe027;',
		'icon_refresh'              => '&#xe02a;',
		'icon_link_alt'             => '&#xe02b;',
		'icon_link'                 => '&#xe02c;',
		'icon_loading'              => '&#xe02d;',
		'icon_blocked'              => '&#xe02e;',
		'icon_archive_alt'          => '&#xe02f;',
		'icon_heart_alt'            => '&#xe030;',
		'icon_printer'              => '&#xe103;',
		'icon_calulator'            => '&#xe0ee;',
		'icon_building'             => '&#xe0ef;',
		'icon_floppy'               => '&#xe0e8;',
		'icon_drive'                => '&#xe0ea;',
		'icon_search'               => '&#xe101;',
		'icon_id'                   => '&#xe107;',
		'icon_id-2'                 => '&#xe108;',
		'icon_puzzle'               => '&#xe102;',
		'icon_like'                 => '&#xe106;',
		'icon_dislike'              => '&#xe0eb;',
		'icon_mug'                  => '&#xe105;',
		'icon_currency'             => '&#xe0ed;',
		'icon_wallet'               => '&#xe100;',
		'icon_pens'                 => '&#xe104;',
		'icon_easel'                => '&#xe0e9;',
		'icon_flowchart'            => '&#xe109;',
		'icon_datareport'           => '&#xe0ec;',
		'icon_briefcase'            => '&#xe0fe;',
		'icon_shield'               => '&#xe0f6;',
		'icon_percent'              => '&#xe0fb;',
		'icon_globe'                => '&#xe0e2;',
		'icon_target'               => '&#xe0f5;',
		'icon_balance'              => '&#xe0ff;',
		'icon_star_alt'             => '&#xe031;',
		'icon_star-half_alt'        => '&#xe032;',
		'icon_star-half'            => '&#xe034;',
		'icon_cog'                  => '&#xe037;',
		'icon_cogs'                 => '&#xe038;',
		'arrow_condense_alt'        => '&#xe041;',
		'arrow_expand_alt3'         => '&#xe042;',
		'icon_zoom-out'             => '&#xe053;',
		'icon_zoom-in'              => '&#xe054;',
		'icon_stop_alt'             => '&#xe055;',
		'icon_menu-square_alt'      => '&#xe056;',
		'icon_menu-circle_alt'      => '&#xe057;',
		'icon_document'             => '&#xe058;',
		'icon_documents'            => '&#xe059;',
		'icon_pencil_alt'           => '&#xe05a;',
		'icon_folder'               => '&#xe05b;',
		'icon_folder-add'           => '&#xe05d;',
		'icon_folder_upload'        => '&#xe05e;',
		'icon_folder_download'      => '&#xe05f;',
		'icon_error-circle'         => '&#xe061;',
		'icon_comment'              => '&#xe065;',
		'icon_chat'                 => '&#xe066;',
		'icon_vol-mute'             => '&#xe067;',
		'icon_volume-low'           => '&#xe068;',
		'icon_clock'                => '&#xe06b;',
		'icon_lock'                 => '&#xe06c;',
		'icon_lock-open'            => '&#xe06d;',
		'icon_key'                  => '&#xe06e;',
		'icon_cloud'                => '&#xe06f;',
		'icon_cloud-upload'         => '&#xe070;',
		'icon_cloud-download'       => '&#xe071;',
		'icon_gift'                 => '&#xe073;',
		'icon_house'                => '&#xe074;',
		'icon_mail'                 => '&#xe076;',
		'icon_cone'                 => '&#xe077;',
		'icon_ribbon'               => '&#xe078;',
		'icon_bag'                  => '&#xe079;',
		'icon_cart'                 => '&#xe07a;',
		'icon_tag'                  => '&#xe07b;',
		'icon_trash'                => '&#xe07d;',
		'icon_cursor'               => '&#xe07e;',
		'icon_compass'              => '&#xe080;',
		'icon_heart'                => '&#xe089;',
		'icon_pause_alt'            => '&#xe08f;',
		'icon_phone'                => '&#xe090;',
		'icon_upload'               => '&#xe091;',
		'icon_download'             => '&#xe092;',
		'icon_rook'                 => '&#xe0f8;',
		'icon_floppy_alt'           => '&#xe0e4;',
		'icon_id_alt'               => '&#xe0e0;',
		'icon_puzzle_alt'           => '&#xe0f9;',
		'icon_like_alt'             => '&#xe0dd;',
		'icon_dislike_alt'          => '&#xe0f1;',
		'icon_mug_alt'              => '&#xe0dc;',
		'icon_pens_alt'             => '&#xe0db;',
		'icon_briefcase_alt'        => '&#xe0f4;',
		'icon_shield_alt'           => '&#xe0d9;',
		'icon_percent_alt'          => '&#xe0da;',
		'icon_globe_alt'            => '&#xe0de;',
		'icon_clipboard'            => '&#xe0e6;',
		'social_googleplus'         => '&#xe096;',
		'social_tumblr'             => '&#xe097;',
		'social_tumbleupon'         => '&#xe098;',
		'social_wordpress'          => '&#xe099;',
		'social_dribbble'           => '&#xe09b;',
		'social_deviantart'         => '&#xe09f;',
		'social_myspace'            => '&#xe0a1;',
		'social_skype'              => '&#xe0a2;',
		'social_picassa'            => '&#xe0a4;',
		'social_googledrive'        => '&#xe0a5;',
		'social_flickr'             => '&#xe0a6;',
		'social_blogger'            => '&#xe0a7;',
		'social_spotify'            => '&#xe0a8;',
		'social_delicious'          => '&#xe0a9;',
		'social_facebook_circle'    => '&#xe0aa;',
		'social_twitter_circle'     => '&#xe0ab;',
		'social_pinterest_circle'   => '&#xe0ac;',
		'social_googleplus_circle'  => '&#xe0ad;',
		'social_tumblr_circle'      => '&#xe0ae;',
		'social_stumbleupon_circle' => '&#xe0af;',
		'social_wordpress_circle'   => '&#xe0b0;',
		'social_instagram_circle'   => '&#xe0b1;',
		'social_dribbble_circle'    => '&#xe0b2;',
		'social_vimeo_circle'       => '&#xe0b3;',
		'social_linkedin_circle'    => '&#xe0b4;',
		'social_rss_circle'         => '&#xe0b5;',
		'social_deviantart_circle'  => '&#xe0b6;',
		'social_share_circle'       => '&#xe0b7;',
		'social_myspace_circle'     => '&#xe0b8;',
		'social_skype_circle'       => '&#xe0b9;',
		'social_youtube_circle'     => '&#xe0ba;',
		'social_picassa_circle'     => '&#xe0bb;',
		'social_googledrive_alt2'   => '&#xe0bc;',
		'social_flickr_circle'      => '&#xe0bd;',
		'social_blogger_circle'     => '&#xe0be;',
		'social_spotify_circle'     => '&#xe0bf;',
		'social_delicious_circle'   => '&#xe0c0;',
		'social_tumblr_square'      => '&#xe0c5;',
		'social_stumbleupon_square' => '&#xe0c6;',
		'social_wordpress_square'   => '&#xe0c7;',
		'social_instagram_square'   => '&#xe0c8;',
		'social_dribbble_square'    => '&#xe0c9;',
		'social_rss_square'         => '&#xe0cc;',
		'social_deviantart_square'  => '&#xe0cd;',
		'social_share_square'       => '&#xe0ce;',
		'social_myspace_square'     => '&#xe0cf;',
		'social_skype_square'       => '&#xe0d0;',
		'social_picassa_square'     => '&#xe0d2;',
		'social_googledrive_square' => '&#xe0d3;',
		'social_flickr_square'      => '&#xe0d4;',
		'social_blogger_square'     => '&#xe0d5;',
		'social_spotify_square'     => '&#xe0d6;',
		'social_delicious_square'   => '&#xe0d7;',
		'toggle'                    => '&#x70;',
		'tabs'                      => '&#x2018;',
		'subscribe'                 => '&#x2019;',
		'slider'                    => '&#x201c;',
		'sidebar'                   => '&#x201d;',
		'share2'                    => '&#xe615;',
		'pricing-table'             => '&#x2013;',
		'portfolio'                 => '&#x2014;',
		'number-counter'            => '&#x2dc;',
		'header'                    => '&#x2122;',
		'filtered-portfolio'        => '&#x161;',
		'divider'                   => '&#x203a;',
		'cta'                       => '&#x153;',
		'countdown'                 => '&#x71;',
		'circle-counter'            => '&#x17e;',
		'blurb'                     => '&#x178;',
		'bar-counters'              => '&#xe093;',
		'audio2'                    => '&#xe63a;',
		'accordion'                 => '&#xe095;',
		'icon_gift_alt'             => '&#xe008;',
		'code'                      => '&#xe91c;',
		'hours'                     => '&#xe90c;',
		'hours-security'            => '&#xe90d;',
		'albums'                    => '&#xe90e;',
		'brain'                     => '&#xe90f;',
		'certificate'               => '&#xe910;',
		'certificate-check'         => '&#xe911;',
		'charge'                    => '&#xe912;',
		'charge-cycle'              => '&#xe913;',
		'charge-units'              => '&#xe914;',
		'city'                      => '&#xe915;',
		'clock'                     => '&#xe916;',
		'cloud-gear'                => '&#xe917;',
		'cloud-services'            => '&#xe91a;',
		'cloud-sync'                => '&#xe91b;',
		'ear'                       => '&#xe91d;',
		'ear-slash'                 => '&#xe91e;',
		'eye'                       => '&#xe91f;',
		'eye-slash'                 => '&#xe920;',
		'file'                      => '&#xe921;',
		'file-audio'                => '&#xe922;',
		'file-certificate'          => '&#xe923;',
		'file-check'                => '&#xe924;',
		'file-code'                 => '&#xe925;',
		'file-csv'                  => '&#xe926;',
		'file-download'             => '&#xe927;',
		'file-excel'                => '&#xe928;',
		'file-export'               => '&#xe929;',
		'file-import'               => '&#xe92a;',
		'file-invoice'              => '&#xe92b;',
		'file-medical'              => '&#xe92c;',
		'file-medical-alt'          => '&#xe92d;',
		'file-pdf'                  => '&#xe92e;',
		'file-powerpoint'           => '&#xe92f;',
		'file-prescription'         => '&#xe930;',
		'file-upload'               => '&#xe931;',
		'file-video'                => '&#xe932;',
		'file-word'                 => '&#xe933;',
		'file-zip'                  => '&#xe934;',
		'filter-solid'              => '&#xe935;',
		'fingerprint'               => '&#xe936;',
		'fingerprint-check'         => '&#xe937;',
		'hand'                      => '&#xe938;',
		'hand-money'                => '&#xe939;',
		'handshake'                 => '&#xe93a;',
		'institute'                 => '&#xe93b;',
		'medical-bubble'            => '&#xe93c;',
		'medical-care'              => '&#xe93d;',
		'medical-case'              => '&#xe93e;',
		'medical-clinic'            => '&#xe93f;',
		'medical-cross'             => '&#xe940;',
		'medical-doctor'            => '&#xe941;',
		'medical-heart'             => '&#xe942;',
		'medical-pills'             => '&#xe943;',
		'mobile'                    => '&#xe944;',
		'pro-services'              => '&#xe945;',
		'puzzle'                    => '&#xe946;',
		'puzzle-piece'              => '&#xe947;',
		'recycle'                   => '&#xe948;',
		'responsive'                => '&#xe949;',
		'responsive-alt'            => '&#xe94a;',
		'security-network'          => '&#xe94b;',
		'security-system'           => '&#xe94c;',
		'shield-check'              => '&#xe94d;',
		'thumb-up'                  => '&#xe94e;',
		'trophy'                    => '&#xe94f;',
		'users'                     => '&#xe950;',
		'users-alt'                 => '&#xe951;',
		'users-dialog'              => '&#xe952;',
		'users-interaction'         => '&#xe953;',
		'video'                     => '&#xe954;',
		'beaker3'                   => '&#xc901;',
		'beaker4'                   => '&#xc902;',
		'beaker5'                   => '&#xc903;',
		'candle-alt'                => '&#xc910;',
		'cal-bear'                  => '&#xe90b;',
		'biohazard'                 => '&#xe918;',
		'malware'                   => '&#xe919;',
		'radiation'                 => '&#xe955;',
		'chemical-hazard'           => '&#xe956;',
		'danger'                    => '&#xe957;',
		'do-not-sign'               => '&#xe958;',
		'earthquake'                => '&#xe959;',
		'quake-house'               => '&#xe95a;',
		'quake-hazard'              => '&#xe95b;',
		'electricity-hazard'        => '&#xe95c;',
		'flood'                     => '&#xe95d;',
		'hazard'                    => '&#xe95e;',
		'hurricane'                 => '&#xe95f;',
		'sea-level-rise'            => '&#xe960;',
		'severe-weather'            => '&#xe961;',
		'stop-fire'                 => '&#xe962;',
		'stop-hand'                 => '&#xe963;',
		'tornado'                   => '&#xe964;',
		'tsunami'                   => '&#xe965;',
		'volcano'                   => '&#xe966;',
		'warning-circle'            => '&#xe967;',
		'warning-square'            => '&#xe968;',
		'tent'                      => '&#xe969;',
		'campfire'                  => '&#xe96a;',
		'dam'                       => '&#xe96b;',
		'download-cloud'            => '&#xe96c;',
		'upload-cloud'              => '&#xe96d;',
		'sea-level-rise-alt'        => '&#xe96e;',
		'tsunami-alt'               => '&#xe96f;',
		'collapse-all'              => '&#xe970;',
		'sign-language'             => '&#xe971;',
		'drag'                      => '&#xe972;',
		'agriculture'               => '&#xe973;',
		'cannabis'                  => '&#xe974;',
		'angry'                     => '&#xe975;',
		'happy'                     => '&#xe976;',
		'visa'                      => '&#xe977;',
		'mastercard'                => '&#xe978;',
		'amexcard'                  => '&#xe979;',
		'apple-pay'                 => '&#xe97a;',
		'discovercard'              => '&#xe97b;',
		'paypal'                    => '&#xe97c;',
		'chrome'                    => '&#xe97d;',
		'firefox'                   => '&#xe97e;',
		'ie'                        => '&#xe97f;',
		'opera'                     => '&#xe980;',
		'safari'                    => '&#xe981;',
		'bell'                      => '&#xe982;',
		'bookmark'                  => '&#xe983;',
		'books'                     => '&#xe984;',
		'reader'                    => '&#xe985;',
		'palette'                   => '&#xe986;',
		'glass'                     => '&#xe987;',
		'heart'                     => '&#xe988;',
		'digging'                   => '&#xe989;',
		'gas-pump'                  => '&#xe98a;',
		'idea-alt'                  => '&#xe98b;',
		'medal'                     => '&#xe98c;',
		'smoking'                   => '&#xe98d;',
		'no-smoking'                => '&#xe98e;',
		'share-snapchat'            => '&#xe98f;',
		'snapchat'                  => '&#xe990;',
		'expand-all'                => '&#xe991;',
		'accessibility'             => '&#xe992;',
		'features'                  => '&#xe993;',
		'distance'                  => '&#xe995;',
		'coronavirus'               => '&#xe996;',
		'coughing'                  => '&#xe997;',
		'cover'                     => '&#xe998;',
		'cubes'                     => '&#xe999;',
		'hand-heart'                => '&#xe99a;',
		'hand-watter'               => '&#xe99b;',
		'lab-tests'                 => '&#xe99c;',
		'mask'                      => '&#xe99d;',
		'no-coughing'               => '&#xe99e;',
		'no-handshake'              => '&#xe99f;',
		'no-virus'                  => '&#xe9a0;',
		'procurement'               => '&#xe9a1;',
		'project'                   => '&#xe9a2;',
		'soap'                      => '&#xe9a3;',
		'stay-home'                 => '&#xe9a4;',
		'teleworking'               => '&#xe9a5;',
		'testing'                   => '&#xe9a6;',
		'testing-alt'               => '&#xe9a7;',
		'virus'                     => '&#xe9a8;',
		'viruses'                   => '&#xe9a9;',
		'wash'                      => '&#xe9aa;',
		'air'                       => '&#xe9de;',
		'air-pollution'             => '&#xe9df;',
		'air-quality'               => '&#xe9e0;',
		'amusement'                 => '&#xe9ab;',
		'anchor'                    => '&#xe9e1;',
		'audience'                  => '&#xe9fa;',
		'balloons'                  => '&#xe9ac;',
		'badminton'                 => '&#xe9e2;',
		'barge-ship'                => '&#xe9ad;',
		'bars-up'                   => '&#xe9fd;',
		'bars-upward'               => '&#xea1d;',
		'baseball'                  => '&#xe9e3;',
		'basketball'                => '&#xe9e4;',
		'bath'                      => '&#xe9e5;',
		'bike'                      => '&#xe9ae;',
		'billiards'                 => '&#xe9e6;',
		'boat'                      => '&#xe9af;',
		'bowling'                   => '&#xe9e7;',
		'bridge'                    => '&#xe9b0;',
		'bridge-alt'                => '&#xe9b1;',
		'bus'                       => '&#xe9b2;',
		'bus-alt'                   => '&#xe9b3;',
		'car'                       => '&#xe9b4;',
		'car-alt'                   => '&#xe9b5;',
		'care-tweezers'             => '&#xe9e8;',
		'cart-delivered'            => '&#xea15;',
		'casino'                    => '&#xe9b6;',
		'cellphone-touch'           => '&#xea08;',
		'certificate-click'         => '&#xea03;',
		'church'                    => '&#xe9e9;',
		'cloud-network'             => '&#xea1b;',
		'coffee'                    => '&#xe9b7;',
		'cruise-ship'               => '&#xe9b8;',
		'desktop-checklist'         => '&#xea05;',
		'desktop-video-module'      => '&#xea10;',
		'dices'                     => '&#xe9b9;',
		'directions'                => '&#xe9ba;',
		'entertainment'             => '&#xe9bb;',
		'envelope-checklist'        => '&#xea13;',
		'external-link'             => '&#xe9ed;',
		'family'                    => '&#xe9bc;',
		'family-alt'                => '&#xe9bd;',
		'fastfood'                  => '&#xe9be;',
		'ferry'                     => '&#xe9bf;',
		'fitness'                   => '&#xe9c0;',
		'fitness-alt'               => '&#xe9c1;',
		'football'                  => '&#xe9ee;',
		'golf'                      => '&#xe9ef;',
		'google'                    => '&#xea0e;',
		'graduate-pointer'          => '&#xea0f;',
		'hair'                      => '&#xe9c2;',
		'hair-salon'                => '&#xe9c3;',
		'highway'                   => '&#xe9c4;',
		'home-education'            => '&#xea07;',
		'home-graduate'             => '&#xea09;',
		'improvements'              => '&#xea1a;',
		'mask-dark'                 => '&#xe9fc;',
		'mask-light'                => '&#xe9fb;',
		'medical-shipped'           => '&#xea16;',
		'mobile-graduate'           => '&#xea11;',
		'mobile-textbook'           => '&#xea0a;',
		'museum'                    => '&#xe9c5;',
		'museum-alt'                => '&#xe9c6;',
		'nail-polish'               => '&#xe9f1;',
		'no-travel'                 => '&#xe9c7;',
		'online-education'          => '&#xea01;',
		'online-graduate'           => '&#xe9ff;',
		'online-help'               => '&#xea1e;',
		'online-module'             => '&#xea0b;',
		'paddle-boat'               => '&#xe9c8;',
		'party'                     => '&#xe9c9;',
		'pdf-text'                  => '&#xea20;',
		'personal-care'             => '&#xe9f2;',
		'pharmacy'                  => '&#xea12;',
		'places'                    => '&#xe9ca;',
		'rail'                      => '&#xe9cb;',
		'restaurant'                => '&#xe9cc;',
		'road'                      => '&#xe9cd;',
		'rv'                        => '&#xe9ce;',
		'sail-ship'                 => '&#xe9cf;',
		'scooter'                   => '&#xe9d0;',
		'ship'                      => '&#xe9d1;',
		'soccer'                    => '&#xe9f4;',
		'spartan-helmet'            => '&#xea14;',
		'speech-dialog'             => '&#xea1f;',
		'speedtrain'                => '&#xe9d2;',
		'suv'                       => '&#xe9d3;',
		'team'                      => '&#xea18;',
		'teams'                     => '&#xea0c;',
		'technology-reuse'          => '&#xea1c;',
		'temple'                    => '&#xe9d4;',
		'tennis'                    => '&#xe9f5;',
		'textbook'                  => '&#xea00;',
		'train'                     => '&#xe9d5;',
		'trolleybus'                => '&#xe9d6;',
		'truck'                     => '&#xe9d7;',
		'truck-alt'                 => '&#xe9d8;',
		'update'                    => '&#xe994;',
		'user-desk'                 => '&#xea0d;',
		'user-desktop-instructor'   => '&#xea02;',
		'user-headphone'            => '&#xea06;',
		'user-laptop'               => '&#xea04;',
		'users-check-mark'          => '&#xea27;',
		'users-huddle'              => '&#xea28;',
		'vaccine'                   => '&#xea17;',
		'vaccine-check'             => '&#xe9fe;',
		'vaccine-patient'           => '&#xea19;',
		'van'                       => '&#xe9d9;',
		'yacht'                     => '&#xe9da;',
		'zoo'                       => '&#xe9db;',
		'zoo-alt'                   => '&#xe9dc;',
	);
}

/**
 * Generates the CA.gov Full Icon JSON File
 *
 * @return void
 */
function caweb_generate_icon_json() {
	$svg = CAWEB_ABSPATH . '/fonts/CaGov.svg';

	if ( file_exists( $svg ) ) {
		$output = array();

		$icons = caweb_icons();

		foreach ( $icons as $i => $data ) {
			$glyph  = $i;
			$code   = $data;
			$search = str_replace( array( '_', '-' ), ' ', $glyph );
			$name   = ucwords( str_replace( array( ' line', ' alt' ), '', $search ) );
			$style  = in_array( 'line', explode( ' ', $search ), true ) ? ', "line"' : ', "solid"';

			$output[] = sprintf( '{"search_terms":"%1$s","unicode":"%2$s","name":"%3$s","glyph": "%4$s","styles":["divi"%5$s],"is_divi_icon":true,"font_weight":400}', $search, $code, $name, $glyph, $style );
		}

		$json = implode( ',', $output );

		// phpcs:disable
		file_put_contents( CAWEB_ABSPATH . '/assets/full_icons_list.json', "[$json]" );
		// phpcs:enable
	}

}
