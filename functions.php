<?php
// アイキャッチ
add_theme_support('post-thumbnails');

// エディタ css
add_action('after_setup_theme', 'block_editor_css');
function block_editor_css() {
	add_theme_support('editor-styles');
	add_editor_style('page.css'); //サイトオリジナル
	add_editor_style('css/editor-style.css'); //エディタ専用
}

// WP version none
remove_action('wp_head','wp_generator');

// 絵文字機能の削除
function disable_emoji() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'disable_emoji' );

// カスタム投稿
add_action('init', 'create_post_type');
function create_post_type() {
    register_post_type('staff', [
        'labels' => [
            'name' => '従業員管理',
            'singular_name' => 'staff',
            'add_new_item' => '新規従業員を追加',
            'edit_item' => '従業員を編集',
            'all_items' => '従業員一覧'
        ],
        'public' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-id',
        'has_archive' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'supports' => [
            // 'title',
            // 'editor',
            'thumbnail',
            // 'author',
            // 'excerpt',
            // 'revisions'
        ]
    ]);
}

add_action('admin_menu', 'create_custom_fields');
function create_custom_fields() {
    add_meta_box(
        'staff_setting',
        '従業員情報',
        'insert_custom_fields',
        'staff',
        'normal'
    );
}
function insert_custom_fields() {
    global $post;
    $staff_name = get_post_meta($post->ID, 'staff_name', true);
    $staff_kana = get_post_meta($post->ID, 'staff_kana', true);
    $staff_post = get_post_meta($post->ID, 'staff_post', true);
    $staff_area = get_post_meta($post->ID, 'staff_area', true);
    $staff_from = get_post_meta($post->ID, 'staff_from', true);
    $staff_hobby = get_post_meta($post->ID, 'staff_hobby', true);
    $staff_ability = get_post_meta($post->ID, 'staff_ability', true);
    $staff_nickname = get_post_meta($post->ID, 'staff_nickname', true);
    $staff_boom = get_post_meta($post->ID, 'staff_boom', true);
    ?>
<form action="admin.php?page=site_settings" method="post">
    <div style="margin-bottom: 10px;">
        <label for="staff_name">従業員名</label>
        <input style="width:200px" type="text" id="staff_name" name="staff_name" value="<?= $staff_name ?>">
        <label for="staff_kana">フリガナ</label>
        <input style="width:200px" type="text" id="staff_kana" name="staff_kana" value="<?= $staff_kana ?>">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="staff_post">役職</label>
        <input style="width:250px" type="text" id="staff_post" name="staff_post" value="<?= $staff_post ?>">
    </div>
    <div style="margin-bottom: 20px;">
        <span>所属</span>
        <input type="radio" id="staff_area_none" name="staff_area" value="" <?= !$staff_area ? 'checked' : '' ?>>
        <label style="margin-right: 10px;" for="staff_area_none">未登録</label>
        <input type="radio" id="staff_area_tokyo" name="staff_area" value="東京" <?= $staff_area === '東京' ? 'checked' : '' ?>>
        <label style="margin-right: 10px;" for="staff_area_tokyo">東京</label>
        <input type="radio" id="staff_area_sendai" name="staff_area" value="仙台" <?= $staff_area === '仙台' ? 'checked' : '' ?>>
        <label style="margin-right: 10px;" for="staff_area_sendai">仙台</label>
        <input type="radio" id="staff_area_etc" name="staff_area" value="他" <?= $staff_area === '他' ? 'checked' : '' ?>>
        <label for="staff_area_etc">他</label>
    </div>
    <div style="margin-bottom: 10px;">
        <label for="staff_from">出身地</label>
        <input style="width:200px" type="text" id="staff_from" name="staff_from" value="<?= $staff_from ?>">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="staff_hobby">趣味</label>
        <input style="width:400px" type="text" id="staff_hobby" name="staff_hobby" value="<?= $staff_hobby ?>">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="staff_ability">特技</label>
        <input style="width:400px" type="text" id="staff_ability" name="staff_ability" value="<?= $staff_ability ?>">
    </div>
    <div style="margin-bottom: 10px;">
        <label for="staff_nickname">ニックネーム</label>
        <input style="width:200px" type="text" id="staff_nickname" name="staff_nickname" value="<?= $staff_nickname ?>">
    </div>
    <div style="margin-bottom: 0px;">
        <label for="staff_boom">最近ハマっているもの</label>
        <input style="width:400px" type="text" id="staff_boom" name="staff_boom" value="<?= $staff_boom ?>">
    </div>
</form>
<?php
}
add_action('save_post', 'save_custom_fields');
function save_custom_fields($post_id) {
    if (isset($_POST['staff_name'])) {
        $title = $_POST['staff_name'];
        update_post_meta($post_id, 'staff_name', $title);
        if (get_the_title($post_id) !== $title) {
            wp_update_post(['ID' => $post_id, 'post_title' => $title]);
        }
    }
    if (isset($_POST['staff_kana'])) {
        update_post_meta($post_id, 'staff_kana', $_POST['staff_kana']);
    }
    if (isset($_POST['staff_post'])) {
        update_post_meta($post_id, 'staff_post', $_POST['staff_post']);
    }
    if (isset($_POST['staff_area'])) {
        update_post_meta($post_id, 'staff_area', $_POST['staff_area']);
    }
    if (isset($_POST['staff_from'])) {
        update_post_meta($post_id, 'staff_from', $_POST['staff_from']);
    }
    if (isset($_POST['staff_hobby'])) {
        update_post_meta($post_id, 'staff_hobby', $_POST['staff_hobby']);
    }
    if (isset($_POST['staff_ability'])) {
        update_post_meta($post_id, 'staff_ability', $_POST['staff_ability']);
    }
    if (isset($_POST['staff_nickname'])) {
        update_post_meta($post_id, 'staff_nickname', $_POST['staff_nickname']);
    }
    if (isset($_POST['staff_boom'])) {
        update_post_meta($post_id, 'staff_boom', $_POST['staff_boom']);
    }
}

// アポラン取得　ショートコード
add_shortcode('aporan', 'aporan_func');
function aporan_func($atts) {
    // for ($i=1; $i <=6 ; $i++) { 
        
    // }
    $other_db = new wpdb('ossy', 'ossy0417', 'esna_aporan_data', '153.126.169.133');
    $other_db->show_errors();

    $month_views = ['今月', '先月', '先々月'];

    for ($i=0; $i<3; $i++) { 
        $now = new DateTime();
        $now->sub(DateInterval::createFromDateString($i.' month'));
        $year = $now->format('Y');
        $month = $now->format('m');

        $types = ['get', 'fin'];
        foreach($types as $type) {
            echo '<div class="aparan-date">'.$month_views[$i]." ".$now->format('Y年m月')." ";
            echo $type === 'get' ? '獲得' : '完了';
            echo 'ランキング</div>';
            $sql = "SELECT year, month, user_id, name, type, CAST(point_num AS DECIMAL(10,2)) AS point_num, CAST(minus AS DECIMAL(10,2)) AS minus, CAST(count AS DECIMAL(10,1)) AS count, CAST(time_num AS DECIMAL(10,0)) AS time_num FROM aporan_data WHERE year = {$year} AND month = {$month} AND type = '{$type}' ORDER BY point_num DESC";
            $result = $other_db->get_results($sql);
            if ($result) {
                if ($type === 'get') {
                    echo '<table><thead><tr><th style="width:50px;">順位</th><th>名前</th><th>獲得P</th><th>獲得件数</th><th>稼働時間</th></tr></thead><tbody>';
                } else {
                    echo '<table><thead><tr><th style="width:50px;">順位</th><th>名前</th><th>完了P</th><th>完了件数</th><th>マイナスP</th></tr></thead><tbody>';
                }
                $no = 1;
                $view_no = 1;
                $temp_point = NULL;
                foreach ($result as $value) {
                    $view_no = $temp_point !== $value->point_num ? $no : $view_no;
                    $time = $value->time_num > 0 ? $value->time_num / 60 : 0;
                    $minus = $value->minus == 0 ? '' : $value->minus;
                    echo '<tr class="rank_'.$view_no.'">';
                    echo '<td class="int">'.$view_no.'</td>';
                    echo '<td class="txt">'.$value->name.'</td>';
                    echo '<td class="int">'.$value->point_num.'</td>';
                    echo '<td class="int">'.$value->count.'</td>';
                    if ($type === 'get') {
                        echo '<td class="int">'.number_format($time, 1).' 時間</td>';
                    }
                    if ($type === 'fin') {
                        echo '<td class="int">'.$minus.'</td>';
                    }
                    echo '</tr>';
                    $temp_point = $value->point_num;
                    $no++;
                }
                echo '</tbody></table>';
            } else {
                echo '<div class="data-none">データがありません</div>';
            }
        }
    }
}
