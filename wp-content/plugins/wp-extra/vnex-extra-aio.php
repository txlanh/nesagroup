<?php
require_once(ABSPATH . 'wp-includes/pluggable.php');
$vnexoption = vnex_all_options();
function vnex_admin_scripts() {
	wp_register_script( 'vnex-color-picker', plugins_url('js/color-picker.js', __FILE__ ), array( 'jquery' ) );
	wp_enqueue_script( 'vnex-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_media();
	wp_register_script( 'vnex-media-upload', plugins_url('js/media-upload.js', __FILE__ ), array( 'jquery' ) );
	wp_enqueue_script( 'vnex-media-upload' );
}
function vnex_admin_styles() {
	wp_register_style('vnex-extra', plugins_url('css/extra.min.css', __FILE__ ), array() );
	wp_enqueue_style('vnex-extra');
}
add_action('admin_enqueue_scripts', 'vnex_admin_scripts');
add_action('admin_enqueue_scripts', 'vnex_admin_styles');

// Tab 01-post/page tab
// Disables the new Gutenberg Editor (post/page tab)
if ($vnexoption['vnex_remove_gutenberg']) {
	add_action( 'current_screen', 'this_screen_gutenberg_remove' );
	function this_screen_gutenberg_remove() {
		$current_screen = get_current_screen();
		$vnexoption = vnex_all_options();
		if($vnexoption['vnex_remove_gutenberg'] == 1) {
			add_filter('use_block_editor_for_post_type', '__return_false', 100);
		}
		if(($vnexoption['vnex_remove_gutenberg'] == 2) && $current_screen->id === "post" ) {
			add_filter('use_block_editor_for_post_type', '__return_false', 100);
		}
	}
}

// Customize MCE editor (post/page tab)
if ($vnexoption['vnex_mce'] == 1) {
	
	function vnex_mce_load_extra_plugins( $plugins ) {
		foreach(array('searchreplace','table','visualblocks') as $item){
			$plugins[$item] = plugins_url('tinymce/',__FILE__ ) .$item.'/plugin.min.js';
		}
		return $plugins;
	}
	add_filter( 'mce_external_plugins', 'vnex_mce_load_extra_plugins' );
	function vnex_mce_row_first($buttons)
	{
		$remove_first= array(0=>'bold','italic','strikethrough','alignleft','aligncenter','alignright',
						'link','unlink','wp_more','bullist' ,'numlist','blockquote','hr','spellchecker','formatselect');
		$new_buttons=array('styleselect','formatselect','bold','italic','underline','strikethrough','alignleft','aligncenter','alignright','alignjustify','bullist','numlist','outdent','indent','link','unlink','hr','wp_more','wp_page');			
		foreach($buttons as $index=>$item){
			if(in_array($item,$remove_first)){
				unset($buttons[$index]);
			}else{
				$new_buttons[]=$item;
			}
		}
		$new_buttons[] ='wp_help';
		$new_buttons[] ='fullscreen';
		return $new_buttons;
	}
	add_filter("mce_buttons", "vnex_mce_row_first");
	function vnex_mce_row_second($buttons){
		$remove_second= array(0=>'formatselect','strikethrough','undo' ,'redo','outdent','indent','forecolor','wp_help','hr');
		$new_buttons_2=array('fontselect','fontsizeselect','forecolor','backcolor','undo' ,'redo','blockquote','table','visualblocks','searchreplace');		
		foreach($buttons as $index=>$item){
			if(in_array($item,$remove_second)){
				unset($buttons[$index]);
			}else{
				$new_buttons_2[]=$item;
			}
		}
		return $new_buttons_2;
	}
	add_filter("mce_buttons_2", "vnex_mce_row_second");
	function vnex_text_sizes( $initArray ){
	  $initArray['fontsize_formats'] = "8px 10px 12px 14px 16px 20px 24px 28px 32px 36px 48px 60px 72px 96px";
	  return $initArray;
	}
	add_filter( 'tiny_mce_before_init', 'vnex_text_sizes' );
	function remove_auto_p_tinymce($in) {
		$in['forced_root_block'] = "";
		//$in['force_br_newlines'] = false;
		$in['force_p_newlines'] = true;
	return $in;
	}
	add_filter( 'tiny_mce_before_init', 'remove_auto_p_tinymce' );
}

if ($vnexoption['vnex_widgets'] == 1) {
	// Disables the block editor from managing widgets in the Gutenberg plugin.
	add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
	// Disables the block editor from managing widgets.
	add_filter( 'use_widgets_block_editor', '__return_false' );
}

// Customize MCE editor only for Flatsome (post/page tab)
if ($vnexoption['vnex_mce'] == 2) {
	
	function vnex_mce_load_extra_plugins( $plugins ) {
		foreach(array('searchreplace','table','visualblocks') as $item){
			$plugins[$item] = plugins_url('tinymce/',__FILE__ ) .$item.'/plugin.min.js';
		}
		return $plugins;
	}
	add_filter( 'mce_external_plugins', 'vnex_mce_load_extra_plugins' );
	function vnex_mce_row_first($buttons)
	{
		$remove_first= array(0=>'styleselect','bold','italic','strikethrough','alignleft','aligncenter','alignright',
						'link','unlink','wp_more','bullist' ,'numlist','blockquote','hr','spellchecker','formatselect','fullscreen','alignjustify');
		$new_buttons=array('formatselect','bold','italic','underline','strikethrough','alignleft','aligncenter','alignright','alignjustify','bullist','numlist','outdent','indent','link','unlink','hr','wp_more','wp_page');			
		foreach($buttons as $index=>$item){
			if(in_array($item,$remove_first)){
				unset($buttons[$index]);
			}else{
				$new_buttons[]=$item;
			}
		}
		$new_buttons[] ='wp_help';
		$new_buttons[] ='fullscreen';
		return $new_buttons;
	}
	add_filter("mce_buttons", "vnex_mce_row_first");
	function vnex_mce_row_second($buttons){
		$remove_second= array(	0=>'fontsizeselect','formatselect','strikethrough','undo' ,'redo','outdent','indent','forecolor','wp_help','hr','backcolor');
		$new_buttons_2=array('fontselect','fontsizeselect','forecolor','backcolor','undo' ,'redo','blockquote','table','codesample','visualblocks','searchreplace');		
		foreach($buttons as $index=>$item){
			if(in_array($item,$remove_second)){
				unset($buttons[$index]);
			}else{
				$new_buttons_2[]=$item;
			}
		}
		return $new_buttons_2;
	}
	add_filter("mce_buttons_2", "vnex_mce_row_second", 9999);
	function remove_auto_p_tinymce($in) {
		$in['forced_root_block'] = "";
		//$in['force_br_newlines'] = false;
		$in['force_p_newlines'] = true;
	return $in;
	}
	add_filter( 'tiny_mce_before_init', 'remove_auto_p_tinymce' );
}

// Disable Emojis (post/page tab)
if ($vnexoption['vnex_disable_emojis'] == 1) {
	function vnex_disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'tiny_mce_plugins', 'vnex_disable_emojis_tinymce' );
		add_filter( 'wp_resource_hints', 'vnex_disable_emojis_remove_dns_prefetch', 10, 2 );
	}
	add_action( 'init', 'vnex_disable_emojis' );
	function vnex_disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		}
		return array();
	}
	function vnex_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
		if ( 'dns-prefetch' == $relation_type ) {
			$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
			foreach ( $urls as $key => $url ) {
				if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
					unset( $urls[$key] );
				}
			}
		}
		return $urls;
	}
}

// Limit Post Revisions (post/page tab)
if ($vnexoption['vnex_post_revisions']) {
    $vnexoption = vnex_all_options();
    if (!defined('WP_POST_REVISIONS'))
        define('WP_POST_REVISIONS', sanitize_text_field($vnexoption['vnex_post_revisions']));
}

// Empty from the trash bin (post/page tab)
if ($vnexoption['vnex_empty_trash_bin']) {
    $vnexoption = vnex_all_options();
    if (!defined('EMPTY_TRASH_DAYS'))
        define('EMPTY_TRASH_DAYS', sanitize_text_field($vnexoption['vnex_empty_trash_bin']));
}

// Clone Post / Page - Creates post clone as a draft and redirects then to the edit post screen (post/page tab)
if ($vnexoption['vnex_clone_post'] == 1) {
	function vnex_clone_post_as_draft(){
		global $wpdb;
		if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'vnex_clone_post_as_draft' == $_REQUEST['action'] ) ) ) {
			wp_die( __( 'No post to clone has been supplied!', 'vnex' ) );
		}
		if ( !isset( $_GET['clone_nonce'] ) || !wp_verify_nonce( $_GET['clone_nonce'], basename( __FILE__ ) ) )
			return;
		$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
		$post = get_post( $post_id );
		$current_user = wp_get_current_user();
		$new_post_author = $current_user->ID;
		if (isset( $post ) && $post != null) {
			$args = array(
				'comment_status' => $post->comment_status,
				'ping_status'    => $post->ping_status,
				'post_author'    => $new_post_author,
				'post_content'   => $post->post_content,
				'post_excerpt'   => $post->post_excerpt,
				'post_name'      => $post->post_name,
				'post_parent'    => $post->post_parent,
				'post_password'  => $post->post_password,
				'post_status'    => 'draft',
				'post_title'     => $post->post_title,
				'post_type'      => $post->post_type,
				'to_ping'        => $post->to_ping,
				'menu_order'     => $post->menu_order
			);
			$new_post_id = wp_insert_post( $args );
			$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
			foreach ($taxonomies as $taxonomy) {
				$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
				wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
			}
			$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
			if (count($post_meta_infos)!=0) {
				$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					if( $meta_key == '_wp_old_slug' ) continue;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				}
				$sql_query.= implode(" UNION ALL ", $sql_query_sel);
				$wpdb->query($sql_query);
			}
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
			exit;
		} else {
			wp_die( __('Post creation failed, could not find original post: ', 'vnex' ) . $post_id);
		}
	}
	add_action( 'admin_action_vnex_clone_post_as_draft', 'vnex_clone_post_as_draft' );
	function vnex_clone_post_link( $actions, $post ) {
		if (current_user_can('edit_posts')) {
			$actions['clone'] = '<a href="' . wp_nonce_url('admin.php?action=vnex_clone_post_as_draft&post=' . $post->ID, basename(__FILE__), 'clone_nonce' ) . '" title="Clone this item" rel="permalink">Clone</a>';
		}
		return $actions;
	}
	add_filter('post_row_actions', 'vnex_clone_post_link', 10, 2);
	add_filter('page_row_actions', 'vnex_clone_post_link', 10, 2);
}

// Disable & Remove Menu Comments (post/page tab)
if ($vnexoption['vnex_disable_comments'] == 1) {
	function vnex_disable_comments_post_types_support() {
		$post_types = get_post_types();
		foreach ($post_types as $post_type) {
			if(post_type_supports($post_type, 'comments')) {
				remove_post_type_support($post_type, 'comments');
				remove_post_type_support($post_type, 'trackbacks');
			}
		}
	}
	add_action('admin_init', 'vnex_disable_comments_post_types_support');
	function vnex_disable_comments_status() {
		return false;
	}
	add_filter('comments_open', 'vnex_disable_comments_status', 20, 2);
	add_filter('pings_open', 'vnex_disable_comments_status', 20, 2);
	function vnex_disable_comments_hide_existing_comments($comments) {
		$comments = array();
		return $comments;
	}
	add_filter('comments_array', 'vnex_disable_comments_hide_existing_comments', 10, 2);
	function vnex_disable_comments_admin_menu() {
		remove_menu_page('edit-comments.php');
	}
	add_action('admin_menu', 'vnex_disable_comments_admin_menu');
	function vnex_disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ($pagenow === 'edit-comments.php') {
			wp_redirect(admin_url()); exit;
		}
	}
	add_action('admin_init', 'vnex_disable_comments_admin_menu_redirect');
	function vnex_disable_comments_dashboard() {
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	}
	add_action('admin_init', 'vnex_disable_comments_dashboard');
	function remove_comments(){
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('comments');
	}
	add_action( 'wp_before_admin_bar_render', 'remove_comments' );
}

// Publish Button - Making it stick to the bottom of the page when scrolling down the page (post/page tab)
if ($vnexoption['vnex_button_post'] == 1) {
    add_action( 'admin_enqueue_scripts', 'vnex_post_button_enqueue_scripts', 20 );
	function vnex_post_button_enqueue_scripts() {
		global $pagenow;
		if ( is_admin() && ($pagenow == 'post.php' || $pagenow == 'post-new.php') ) {
			wp_register_script('post-button', plugin_dir_url( __FILE__ ) . 'js/post-button.js', array( 'jquery' ) );
			wp_enqueue_script('post-button');
		}
	}
}

// Restrict user to copy content & disable mouse right click (post/page tab)
if ($vnexoption['vnex_donotcopy'] == 1) {
	if ( !current_user_can( 'manage_options' ) ) {
		function donotcopy_function() {
			global $pagenow;
			wp_register_script('donotcopy', plugin_dir_url( __FILE__ ) . 'js/copy.min.js', array( 'jquery' ) );
			wp_enqueue_script('donotcopy');
		}
		add_action('wp_enqueue_scripts', 'donotcopy_function');
	}
}

// Allow SVG (post/page tab)
if ($vnexoption['vnex_allow_svg'] == 1) {
	function ignore_upload_ext($checked, $file, $filename, $mimes){
		if(!$checked['type']){
			$wp_filetype = wp_check_filetype( $filename, $mimes );
			$ext = $wp_filetype['ext'];
			$type = $wp_filetype['type'];
			$proper_filename = $filename;
			if($type && 0 === strpos($type, 'image/') && $ext !== 'svg'){
				$ext = $type = false;
			}
			$checked = compact('ext','type','proper_filename');
		}
		return $checked;
	}
	add_filter('wp_check_filetype_and_ext', 'ignore_upload_ext', 10, 4);
}


// Tab 02-Image
// Downloading automatically image from a post to gallery (image tab)
if ($vnexoption['vnex_auto_save_images']) {
	include plugin_dir_path( __FILE__ ) . 'inc/auto-save-images.php';
}

// Automatically resizes uploaded images (image tab)
if ($vnexoption['vnex_image_resize']) {
	include plugin_dir_path( __FILE__ ) . 'inc/auto-resize-image.php';
}

// Automatically Set the Featured Image (image tab)
if ($vnexoption['vnex_auto_set_featured_image']) {
	function autoset_featured() {
		global $post;
		$post_id = isset( $post->ID ) ? $post->ID : null;
		$already_has_thumb = has_post_thumbnail($post_id);
		if (!$already_has_thumb)  {
		$attached_image = get_children( "post_parent=$post_id&post_type=attachment&post_mime_type=image&numberposts=1" );
		  if ($attached_image) {
				foreach ($attached_image as $attachment_id => $attachment) {
				set_post_thumbnail($post_id, $attachment_id);
				}
		   }
		}
	}
	add_action('the_post', 'autoset_featured');
	add_action('save_post', 'autoset_featured');
	add_action('draft_to_publish', 'autoset_featured');
	add_action('new_to_publish', 'autoset_featured');
	add_action('pending_to_publish', 'autoset_featured');
	add_action('future_to_publish', 'autoset_featured');
}

// Automatically set the image Title, Alt-Text, Caption & Description upload (image tab)
if ($vnexoption['vnex_set_image_meta'] == 1) {
	add_action( 'add_attachment', 'vnex_set_image_meta_image_upload' );
	function vnex_set_image_meta_image_upload( $post_ID ) {
		if ( wp_attachment_is_image( $post_ID ) ) {
		$vnex_image_title = get_post( $post_ID )->post_title;
		$vnex_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',
		$vnex_image_title );
		$vnex_image_title = ucwords( strtolower( $vnex_image_title ) );
		$vnex_my_image_meta = array(
		'ID' => $post_ID,
		'post_title' => $vnex_image_title,
		'post_excerpt' => '',
		);
		update_post_meta( $post_ID, '_wp_attachment_image_alt',	$vnex_image_title );
		wp_update_post( $vnex_my_image_meta );
		}
	}
}


// Tab 03-Setting
// Change Admin footer (setting tab)
if ($vnexoption['vnex_admin_footer']) {
    function vnex_admin_footer_name()
    {
        $vnexoption = vnex_all_options();
        echo '<span id="footer-thankyou"><a href="' . get_bloginfo('wpurl') . '" target="_blank">' .sanitize_text_field($vnexoption['vnex_admin_footer']).'</a></span>';
    }
    add_filter('admin_footer_text', 'vnex_admin_footer_name');
}

// Remove unnecessary links from wp_head (setting tab)
if ($vnexoption['vnex_remove_head_link'] == 1) {
	// Remove RSD Link Tag
    remove_action('wp_head', 'rsd_link');
	// Hide WordPress version
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
	// Remove wlwmanifest Link
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
}

// Disable RSS Feeds and redirect to Homepage (setting tab)
if ($vnexoption['vnex_disable_feed'] == 1) {
    function disable_feeds() {
		wp_redirect( home_url() );
		die;
	}
	// Disable global RSS, RDF & Atom feeds.
	add_action( 'do_feed',      'disable_feeds', -1 );
	add_action( 'do_feed_rdf',  'disable_feeds', -1 );
	add_action( 'do_feed_rss',  'disable_feeds', -1 );
	add_action( 'do_feed_rss2', 'disable_feeds', -1 );
	add_action( 'do_feed_atom', 'disable_feeds', -1 );
	// Disable comment feeds.
	add_action( 'do_feed_rss2_comments', 'disable_feeds', -1 );
	add_action( 'do_feed_atom_comments', 'disable_feeds', -1 );
	// Prevent feed links from being inserted in the <head> of the page.
	add_action( 'feed_links_show_posts_feed',    '__return_false', -1 );
	add_action( 'feed_links_show_comments_feed', '__return_false', -1 );
	remove_action( 'wp_head', 'feed_links',       2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
}

// Add .html to Page (setting tab)
if ($vnexoption['vnex_page_html'] == 1) {
	add_action('init', 'vnex_html_page_permalink', -1);
	function vnex_nopage_slash($string, $type){
	   global $wp_rewrite;
		if ($wp_rewrite->using_permalinks() && $wp_rewrite->use_trailing_slashes==true && $type == 'page'){
			return untrailingslashit($string);
	  }else{
	   return $string;
	  }
	}
	function vnex_html_page_permalink() {
		global $wp_rewrite;
	 if ( !strpos($wp_rewrite->get_page_permastruct(), '.html')){
			$wp_rewrite->page_structure = $wp_rewrite->page_structure . '.html';
	 }
	}
	add_filter('user_trailingslashit', 'vnex_nopage_slash',66,2);
	function active() {
		global $wp_rewrite;
		if ( !strpos($wp_rewrite->get_page_permastruct(), '.html')){
			$wp_rewrite->page_structure = $wp_rewrite->page_structure . '.html';
	 }
	  $wp_rewrite->flush_rules();
	}	
	function deactive() {
		global $wp_rewrite;
		$wp_rewrite->page_structure = str_replace(".html","",$wp_rewrite->page_structure);
		$wp_rewrite->flush_rules();
	}
}

// Login Logo (setting tab)
if ($vnexoption['vnex_admin_logo'] || $vnexoption['vnex_admin_background'] || $vnexoption['vnex_admin_background_color']){
	function vnex_2_rgb( $hex, $opacity = 0.3 ) {
		$hex = str_replace( '#', '', $hex );
		if( strlen( $hex ) == 3) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		return "rgba( $r, $g, $b, $opacity )";
	} 
    function vnex_custom_admin_login()
	{
        $vnexoption = vnex_all_options();
		$color = esc_textarea($vnexoption['vnex_admin_background_color']);
		echo '<style>';
		if ($vnexoption['vnex_admin_background']){
			echo 'body.login {-webkit-background-size: cover !important;-moz-background-size: cover !important;-o-background-size: cover !important;background-size: cover !important;background-color:'. $color .'!important;background-image: url('.$vnexoption['vnex_admin_background'].');background-position:center center;background-repeat:repeat;}';
		}
		if ($vnexoption['vnex_admin_background_color']){
			$rgb_button = vnex_2_rgb($color);
			echo 'body.login {background: -webkit-linear-gradient(left, '. $color .', '. $rgb_button .'); background: linear-gradient(to right, '. $color .', '. $rgb_button .'); } 
			.login form { background: rgba(255,255,255,0.3) !important;} 
			.login.wp-core-ui .button-primary { background: '. $color .'; border-color: '. $color .'; box-shadow: 0 1px 0 '. $color .';text-shadow: none;}
			.login #backtoblog a, .login #nav a {color: #fff;}';
		}
		if ($vnexoption['vnex_admin_logo']) {
			echo '.login h1 a { background-image: url(' . $vnexoption['vnex_admin_logo'] . ')!important; background-size: contain; width:auto!important;max-width:100%; }';
		};
		echo '</style>';
		
	}
	add_action('login_head', 'vnex_custom_admin_login');
	function vnex_custom_login_logo_url() {
		return get_home_url();
	}
	add_filter( 'login_headerurl', 'vnex_custom_login_logo_url' );

	function vnex_custom_login_logo_url_title() {
		return get_option('blogname');
	}
	add_filter( 'login_headertext', 'vnex_custom_login_logo_url_title' );
}

// Add nofollow & _blank (setting tab)
if ($vnexoption['vnex_auto_links'] == 1)  {
	function add_nofollow_content($content) {
	$content = preg_replace_callback('/<a[^>]*href=["|\']([^"|\']*)["|\'][^>]*>([^<]*)<\/a>/i',
	function($m) {
		if (strpos($m[1], $_SERVER['HTTP_HOST']) === false && strpos($m[1], "#") === false ) 
				return '<a href="'.$m[1].'" target="_blank">'.$m[2].'</a>';
		else
			return '<a href="'.$m[1].'">'.$m[2].'</a>';
		},
		$content);
		return $content;
	}
	add_filter('the_content', 'add_nofollow_content');
}

// Add nofollow & _blank (setting tab)
if ($vnexoption['vnex_auto_links'] == 2)  {
	function add_nofollow_content($content) {
	$content = preg_replace_callback('/<a[^>]*href=["|\']([^"|\']*)["|\'][^>]*>([^<]*)<\/a>/i',
	function($m) {
		if (strpos($m[1], $_SERVER['HTTP_HOST']) === false && strpos($m[1], "#") === false ) 
				return '<a href="'.$m[1].'" rel="nofollow" target="_blank">'.$m[2].'</a>';
		else
			return '<a href="'.$m[1].'">'.$m[2].'</a>';
		},
		$content);
		return $content;
	}
	add_filter('the_content', 'add_nofollow_content');
}

// Redirect 404 Error Page to Homepage (setting tab)
if ($vnexoption['vnex_404_home']) {
	function vnex_redirect_404_to_home() {
		if (is_404()) {
		   wp_redirect(home_url(),301);
		   die();
		}
	}
	add_action('wp', 'vnex_redirect_404_to_home', 1);
}

//Redirect To Post If Search Results Return One Post
if ($vnexoption['search_results_return_one_post'] ==1) {
add_action('template_redirect', 'redirect_single_post');
function redirect_single_post() {
    if (is_search()) {
        global $wp_query;
        if ($wp_query->post_count == 1 && $wp_query->max_num_pages == 1) {
            wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
            exit;
        }
    }
}
}

// Clear whitespace in JS and CSS
if ($vnexoption['vnex_clear_whitespace_in_js_and_css'] == 1) {
	function clear_whitespace_func(){
		if (!(is_admin() && is_user_logged_in() == true )) {
			function minify_html(){
				ob_start('html_compress');
			}
			function html_compress($buffer){
				$search = array(
					'/\n/',         // replace end of line by a space
					'/\>[^\S ]+/s',     // strip whitespaces after tags, except space
					'/[^\S ]+\</s',     // strip whitespaces before tags, except space
					'/(\s)+/s',     // shorten multiple whitespace sequences,
					'~<!--//(.*?)-->~s' //html comments
				);
				$replace = array(
					' ',
					'>',
					'<',
					'\\1',
					''
				);
				$buffer = preg_replace($search, $replace, $buffer);
				return $buffer;
			}
			add_action('wp_loaded','minify_html'); 
			} else {
				/* Some other code */
			}
	}
	add_action('init', 'clear_whitespace_func');
}

// Defer CSS
if(!empty($vnexoption['vnex_defer_css'])) {
	function add_rel_preload($html, $handle, $href, $media) {
    if (is_admin())
        return $html;

     $html = <<<EOT
<link defer="defer" rel='stylesheet' href='$href' media="print" onload="this.media='all'" id='$handle' crossorigin="anonymous"/>
<noscript><link defer rel="preload" href="$href" crossorigin="anonymous"></noscript>
EOT;
    return $html;
	}
	add_filter( 'style_loader_tag', 'add_rel_preload', 10, 4 );
}

// Defer Scripts
if(!empty($vnexoption['vnex_defer_js'])) {
	function mind_defer_scripts( $tag, $handle, $src ) {
	  $defer = array(
		'custom-animate',
		'owl-carousel',
		'swiper-jquery',
		'jquery-migrate',
		'florida-custom',
		'scrolldepth',
		'tp-tools',
		'revmin',
		'jquery',
		'hoverIntent',
		'megamenu',
		'jquery-lazyloadxt',
		'jquery-lazyloadxt-srcset',
		'jquery-lazyloadxt-extend',
		'vc_carousel_js',
		'vc_tabs_script',
		'vc_tta_autoplay_script',
		'vc_transition_bootstrap_js',
		'mediaelement',
		'contact-form-7',
		'icegram_main_js',
		'dynamic-js',
		'wpcf7-redirect-script'
	  );
	  if ( in_array( $handle, $defer ) ) {
		 return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
	  }
		
		return $tag;
	} 
	add_filter( 'script_loader_tag', 'mind_defer_scripts', 10, 3 );
}

// Disable Heartbeat
if(!empty($vnexoption['disable_heartbeat'])) {
	add_action('init', 'vnex_disable_heartbeat', 1);
}

function vnex_disable_heartbeat() {

	//check for exception pages in admin
	if(is_admin()) {
		global $pagenow;
		if(!empty($pagenow) && in_array($pagenow, array('admin.php'))) {
			if(!empty($_GET['page'])) {
				$exceptions = array(
					'gf_edit_forms',
					'gf_entries',
					'gf_settings'
				);
				if(in_array($_GET['page'], $exceptions)) {
					return;
				}
			}
		}
	}

	//disable hearbeat
	global $vnexoption;
	if(!empty($vnexoption['disable_heartbeat'])) {
		if($vnexoption['disable_heartbeat'] == '1') {
			vnex_replace_hearbeat();
		}
		elseif($vnexoption['disable_heartbeat'] == '2') {
			global $pagenow;
			if($pagenow != 'post.php' && $pagenow != 'post-new.php') {
				vnex_replace_hearbeat();
			}
		}
	}
}

function vnex_replace_hearbeat() {
	wp_deregister_script('heartbeat');
	//wp_dequeue_script('heartbeat');
	if(is_admin()) {
		wp_register_script('hearbeat', plugins_url('js/heartbeat.js', dirname(__FILE__)));
		wp_enqueue_script('heartbeat', plugins_url('js/heartbeat.js', dirname(__FILE__)));
	}
}

// Heartbeat Frequency
if(!empty($vnexoption['heartbeat_frequency'])) {
	add_filter('heartbeat_settings', 'vnex_heartbeat_frequency');
}

function vnex_heartbeat_frequency($settings) {
	global $vnexoption;
	if(!empty($vnexoption['heartbeat_frequency'])) {
		$settings['interval'] = sanitize_text_field($vnexoption['heartbeat_frequency']);
	}
	return $settings;
}

// Disable Embeds in WordPress
if ($vnexoption['vnex_disable_embeds'] == 1) {
function disable_embeds_code_init() {
  // Remove the REST API endpoint.
  remove_action( 'rest_api_init', 'wp_oembed_register_route' );

  // Turn off oEmbed auto discovery.
  add_filter( 'embed_oembed_discover', '__return_false' );

  // Don't filter oEmbed results.
  remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

  // Remove oEmbed discovery links.
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

  // Remove oEmbed-specific JavaScript from the front-end and back-end.
  remove_action( 'wp_head', 'wp_oembed_add_host_js' );

  add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );

  // Remove all embeds rewrite rules.
  add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

  // Remove filter of the oEmbed result before any HTTP requests are made.
  remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
}

add_action( 'init', 'disable_embeds_code_init', 9999 );

function disable_embeds_tiny_mce_plugin($plugins) {
  return array_diff( $plugins, array('wpembed') );
}

function disable_embeds_rewrites ($rules) {

foreach($rules as $rule => $rewrite) {
 
  if(false !== strpos($rewrite, 'embed=true')) {
    unset($rules[$rule]);
  }
 
}

return $rules;
}
}

// Remove Query Strings
if ($vnexoption['vnex_remove_query_strings'] == 1) {
function _remove_script_version ( $src ){
  $parts = explode( '?', $src );
  return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
}

// Remove the Shortlink Tag
if ($vnexoption['vnex_remove_shortlink'] == 1) {
add_filter('after_setup_theme', 'remove_redundant_shortlink');
function remove_redundant_shortlink() {
  remove_action('wp_head', 'wp_shortlink_wp_head', 10); 
  remove_action( 'template_redirect', 'wp_shortlink_header', 11);
}
}

// Disable Dashicons
if ($vnexoption['vnex_disable_dashicon'] == 1) {
function wpdocs_dequeue_dashicon() {
if (current_user_can( 'update_core' )) {
  return;
}
wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );
}

// Tab 04-Dashboard
// Remove All Dashboard (Dashboard tab)
if ($vnexoption['vnex_remove_dashboard'] == 1) {
	remove_action('welcome_panel', 'wp_welcome_panel');
	function remove_default_dashboard_widgets() {
		remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
	} 
	add_action('wp_dashboard_setup', 'remove_default_dashboard_widgets' );
}

// Add Notice to Dashboard (Dashboard tab)
if ($vnexoption['vnex_dashboard_notice']) {
	function add_dashboard_widgets(){
		global $wp_meta_boxes;
		wp_add_dashboard_widget('custom_help_widget', __( 'Notice', 'vnex' ), 'custom_dashboard_help');
		}
		function custom_dashboard_help() {
		$vnexoption = vnex_all_options();
		echo stripslashes($vnexoption['vnex_dashboard_notice']);
	}
	add_action('wp_dashboard_setup', 'add_dashboard_widgets');
	function full_dashboard_columns () {
		wp_register_style('dashboard-columns', plugins_url('css/dashboard-columns.css', __FILE__ ), array() );
		wp_enqueue_style('dashboard-columns');
	}
	add_action('admin_head-index.php', 'full_dashboard_columns');
}

// Tab 05-Shortcode
// Shortcode tab
if ($vnexoption['vnex_shortcode']) {
	function shortcode_myinfo() {
		$vnexoption = vnex_all_options();
		return stripslashes($vnexoption['vnex_shortcode']);
	}
	add_shortcode('signature', 'shortcode_myinfo');
	function vnex_add_mce_button() {
		if ( !current_user_can( 'edit_posts' ) &&  !current_user_can( 'edit_pages' ) ) {
				   return;
		}
		if ( 'true' == get_user_option( 'rich_editing' ) ) {
		   add_filter( 'mce_external_plugins', 'vnex_add_tinymce_plugin' );
		   add_filter( 'mce_buttons', 'vnex_register_mce_button' );
		}
	}
	add_action('admin_head', 'vnex_add_mce_button');
	function vnex_register_mce_button( $buttons ) {
				array_push( $buttons, 'vnex_mce_button' );
				return $buttons;
	}
	function vnex_add_tinymce_plugin( $plugin_array ) {
			  $plugin_array['vnex_mce_button'] = plugin_dir_url( __FILE__ ) . 'js/mce-signature.js';
			  return $plugin_array;
	}
}

// Tab 06 SMTP and reCAPTCHA V3 and Contact Form 7
// SMTP
if ($vnexoption['vnex_smtp']) {
	add_action( 'phpmailer_init', 'vnex_send_smtp_email' );
	function vnex_send_smtp_email( $phpmailer ) {
		$vnexoption = vnex_all_options();
		$phpmailer->isSMTP();
		if ($vnexoption['vnex_smtp'] == 1) {
			$phpmailer->Host       = sanitize_text_field($vnexoption['vnex_smtp_host']);
			$phpmailer->Port       =  sanitize_text_field($vnexoption['vnex_smtp_port']);
			$phpmailer->SMTPSecure = sanitize_text_field($vnexoption['vnex_smtp_ssl']);
			$phpmailer->From = sanitize_text_field($vnexoption['vnex_smtp_from_email']);
		} elseif ($vnexoption['vnex_smtp'] == 2) {
			$phpmailer->Host       = "smtp.gmail.com";
			$phpmailer->Port       =  465;
			$phpmailer->SMTPSecure = "ssl";
			$phpmailer->From = sanitize_text_field($vnexoption['vnex_smtp_from_email']);
		} elseif ($vnexoption['vnex_smtp'] == 3) {
			$phpmailer->Host       = "smtp.yandex.com";
			$phpmailer->Port       =  465;
			$phpmailer->SMTPSecure = "ssl";
			$phpmailer->From = sanitize_text_field($vnexoption['vnex_smtp_username']);
		};
		$phpmailer->SMTPAuth   = true;
		$phpmailer->Username   = sanitize_text_field($vnexoption['vnex_smtp_username']);
		$phpmailer->Password   = base64_decode(sanitize_text_field($vnexoption['vnex_smtp_password']));
		$phpmailer->FromName = sanitize_text_field($vnexoption['vnex_smtp_from_name']);
		$phpmailer->AddReplyTo($phpmailer->From, $phpmailer->FromName);
		if ($vnexoption['vnex_smtp_replyto']) {
		$phpmailer->AddAddress ( sanitize_text_field($vnexoption['vnex_smtp_replyto']), $phpmailer->FromName );
		};
	}
}

// Tab 07-Style
// Add custom scripts inside HEAD tag. You need to have a SCRIPT tag around scripts (theme tab)
if ($vnexoption['vnex_add_header']) {
	function vnex_add_header_code () {
        $vnexoption = vnex_all_options();
		echo stripslashes($vnexoption['vnex_add_header']);
	}
	add_action('wp_head', 'vnex_add_header_code');
}

// Add custom scripts inside FOOTER tag. You need to have a SCRIPT tag around scripts (theme tab)
if ($vnexoption['vnex_add_footer']) {
	function vnex_add_footer_code () {
        $vnexoption = vnex_all_options();
		echo stripslashes($vnexoption['vnex_add_footer']);
	}
	add_action('wp_footer', 'vnex_add_footer_code');
}

// Custom CSS (theme tab)
if ($vnexoption['vnex_html_custom_css'] || $vnexoption['vnex_html_custom_css_tablet'] || $vnexoption['vnex_html_custom_css_mobile']) {
	include plugin_dir_path( __FILE__ ) . 'inc/custom-css.php';
}

// Tab 08-security
// Disable back end access for non admin users (security tab)
if ($vnexoption['vnex_back_access'] == 1) {
	function redirect_non_admin_user(){
		if ( !defined( 'DOING_AJAX' ) && !current_user_can('administrator') ){
			wp_redirect( site_url() );  exit;
		} 
	}
	add_action( 'admin_init', 'redirect_non_admin_user' );
}

// Hide admin bar from front end for non admin (security tab)
if ($vnexoption['vnex_hide_admin_bar'] == 1) {
	add_action('admin_print_scripts-profile.php', 'hide_admin_bar_prefs');
	function hide_admin_bar_prefs() { ?>
	<style type="text/css">
		.show-admin-bar {display: none;} #wpadminbar { display:none; }
	</style>
	<?php
	}
	add_filter('show_admin_bar', '__return_false');
}
elseif ($vnexoption['vnex_hide_admin_bar'] == 2) {
	add_action('init', 'remove_admin_bar');
	function remove_admin_bar() {
	  if (!current_user_can('administrator') && !is_admin()) {
		add_action('admin_print_scripts-profile.php', 'hide_admin_bar_prefs');
		function hide_admin_bar_prefs() { ?>
		<style type="text/css">
			.show-admin-bar {display: none;} #wpadminbar { display:none; }
		</style>
		<?php
		}
		add_filter('show_admin_bar', '__return_false');
	  }
	}
}

// Remove admin bar & donate WPVN Team (security tab)
if ($vnexoption['vnex_copyright'] == 0) {
	function vnex_adminbar_menu( $meta = true ) {  
		global $wp_admin_bar;  
			if ( !is_user_logged_in() ) { return; }  
			if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }  
			$wp_admin_bar->add_menu( array(   
				'id'     => 'vnex',  
				'title' => __( '❤ Donate WP Extra', 'vnex' ),
				'href' => 'https://www.paypal.me/copvn',
				'meta'  => array( 'target' => '_blank' ) )
			);  
	}  
	add_action( 'admin_bar_menu', 'vnex_adminbar_menu', 150 );
}

// Customize the error message (security tab)
if ($vnexoption['vnex_admin_errors'] == 1) {
    function no_wordpress_errors()
    {
        $vnexoption = vnex_all_options();
        return sanitize_text_field($vnexoption['vnex_admin_message']);
    }
    add_filter( 'login_errors', 'no_wordpress_errors');
}

// Remove Logo / Version / Help (security tab)
if ($vnexoption['vnex_remove_version'] == 1) {
    function vnex_remove_version()
    {
        return '';
    }
    add_filter('the_generator', 'vnex_remove_version');
	function change_footer_admin () {return ' ';}
	add_filter('admin_footer_text', 'change_footer_admin', 9999);
	function change_footer_version() {return ' ';}
	add_filter( 'update_footer', 'change_footer_version', 9999);
	remove_action('wp_head', 'wp_generator');
	// remove version from rss
	add_filter('the_generator', '__return_empty_string');
	// remove version from scripts and styles
	function vnex_remove_version_scripts_styles($src) {
		if (strpos($src, 'ver=')) {
			$src = remove_query_arg('ver', $src);
		}
		return $src;
	}
	add_filter('style_loader_src', 'vnex_remove_version_scripts_styles', 9999);
	add_filter('script_loader_src', 'vnex_remove_version_scripts_styles', 9999);
	add_filter( 'get_current_screen', 'vnex_remove_help_tabs', 999, 3 );
	function vnex_remove_help_tabs($vnex_old_help, $screen_id, $screen){
		$screen->remove_help_tabs();
		return $vnex_old_help;
	}
	add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );
	function remove_wp_logo( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'wp-logo' );
	}
}

// Change Admin Login URL (security tab)
if ($vnexoption['vnex_admin_slug']) {
	include plugin_dir_path( __FILE__ ) . 'inc/login-slug.php';
}

// Disable XMLRPC (security tab) 
if ($vnexoption['vnex_disable_xmlrpc'] == 1) {
	add_filter('xmlrpc_enabled', '__return_false');
}

// Remove Menu & Disable the theme/plugin editor in Admin (security tab)
if ($vnexoption['vnex_remove_menu_tools'] == 1) {
	add_action( 'admin_init', 'remove_menu_pages_for_all_except_admin' );
		function remove_menu_pages_for_all_except_admin() {
		remove_menu_page( 'themes.php' );
		remove_menu_page( 'plugins.php' );
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'options-general.php' );
	}
    if (!defined('DISALLOW_FILE_EDIT'))
        define('DISALLOW_FILE_EDIT', true);
    if (!defined('DISALLOW_FILE_MODS'))
        define('DISALLOW_FILE_MODS', true);
}

// Remove menu admin
if ($vnexoption['vnex_remove_menu_admin']) {
	function vnex_enqueue_remove_menu_admin_script()
	{
		global $pagenow;
		if ($pagenow != 'nav-menus.php')
			return;
		wp_register_script( 'vnex_remove_menu_admin_script', plugins_url('js/remove-menu-admin.js', __FILE__ ), array( 'jquery' ) );
		wp_enqueue_script( 'vnex_remove_menu_admin_script' );
	}
	add_filter('admin_head', 'vnex_enqueue_remove_menu_admin_script');
}

// Tab 09-WooCommerce
// Disable the new WooCommerce Admin package in WooCommerce (WooCommerce tab)
if ($vnexoption['vnex_wc_disabled'] == 1) {
	add_filter( 'woocommerce_admin_disabled', '__return_true' );
}

if ($vnexoption['vnex_fs_nag'] == 1) {
	add_action( 'init', 'vnex_fsnag' );
	function vnex_fsnag() {
		remove_action( 'admin_notices', 'flatsome_maintenance_admin_notice' );
	}
}
?>