<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

// フロントページウィジェット_お知らせ
add_filter( 'widget_text', function( $ret ) {
	$php_file = 'widget_news';

	if( strpos( $ret, '[' . $php_file . ']' ) !== false ) {
		add_shortcode( $php_file, function() use ( $php_file ) {
			get_template_part( $php_file );
		});

		ob_start();
		do_shortcode( '[' . $php_file . ']' );
		$ret = ob_get_clean();
	}

	return $ret;
}, 99 );
// フロントページウィジェット_イベント
add_filter( 'widget_text', function( $ret ) {
	$php_file = 'widget_event';

	if( strpos( $ret, '[' . $php_file . ']' ) !== false ) {
		add_shortcode( $php_file, function() use ( $php_file ) {
			get_template_part( $php_file );
		});

		ob_start();
		do_shortcode( '[' . $php_file . ']' );
		$ret = ob_get_clean();
	}

	return $ret;
}, 99 );

// ウィジェットエリア作成
$sidebars = array(1, 2, 3);
foreach($sidebars as $number) {
     register_sidebar(array(
          'name' => 'ウィジェット ' . $number,
          'id' => 'widget_id00' . $number,
        //   'before_widget' => '<div class="widget">',
        //   'after_widget' => '</div>',
        //   'before_title' => '<h3>',
        //   'after_title' => '</h3>'
     ));
}

// 子テーマスタイルシート優先設定
add_action( 'wp_enqueue_scripts', 'enqueue_my_styles' );
function enqueue_my_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); // 親テーマのcss
    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/style_custom.css', array('parent-style')); // 子テーマのcss
}

// ページタイトルのタクソノミー表示を消す
add_filter('get_the_archive_title', function ($title) {
	if( is_category() ) {
        $title = single_cat_title( '', false );
    }
    return $title;
    // return preg_replace('/^\w+: /', '', $title);
});