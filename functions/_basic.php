<?php 

// PHPメモリー
ini_set('memory_limit', '256M');

remove_action( 'wp_head', 'wp_generator' ); //WordPressのバージョン情報
remove_action( 'wp_head', 'rsd_link' ); //外部アプリケーションから情報を取得するタグ
remove_action( 'wp_head', 'wlwmanifest_link' ); //Windows Live Writer用のタグ
remove_action( 'wp_head', 'index_rel_link' ); //現在の文書に対する「索引」であることを示すタグ
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); //「?p=投稿ID」形式のデフォルトパーマリンクタグ

//「link rel=next」等のタグ
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

//フィード関連のタグ
remove_action( 'wp_head', 'feed_links', 2);
remove_action( 'wp_head', 'feed_links_extra', 3);

//絵文字関連タグ
remove_action( 'wp_head', 'print_emoji_detection_script', 7);
remove_action( 'admin_print_scripts', 'print_emoji_detection_script');
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles');
add_filter( 'emoji_svg_url', '__return_false' );


// 管理画面
//

// アイキャッチ 使用
add_theme_support('post-thumbnails');

// エディタ css
add_action('after_setup_theme', 'block_editor_css');
function block_editor_css() {
	add_theme_support('editor-styles');
	add_editor_style('page.css'); //サイトオリジナル
	add_editor_style('css/editor-style.css'); //エディタ専用
}

// 投稿メニュー 非表示
function remove_menus () {
    global $menu;
    remove_menu_page( 'edit.php' );
}
add_action('admin_menu', 'remove_menus');