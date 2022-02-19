<?php 

// アポラン取得　ショートコード
add_shortcode('aporan', 'aporan_func');
function aporan_func($atts) {
    $other_db = new wpdb('ossy', 'ossy0417', 'esna_aporan_data', '153.126.169.133');
    $other_db->show_errors();

    // echo '<p>調整中</p>';
    // exit;

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
            $sql = "SELECT `year`, `month`, `user_id`, `name`, `type`, CAST(`point_num` AS DECIMAL(10,2)) AS `point_num`, CAST(`minus` AS DECIMAL(10,2)) AS `minus`, CAST(`count` AS DECIMAL(10,1)) AS `count`, CAST(`time_num` AS DECIMAL(10,0)) AS `time_num`, `ranking`, `rank`, `company` FROM `aporan_data` WHERE `year` = {$year} AND `month` = {$month} AND `type` = '{$type}' AND `company` != 'ESNAパートナー' ORDER BY 'ranking' ASC";
            $result = $other_db->get_results($sql);
            if ($result) {
                if ($type === 'get') {
                    echo '<table><thead><tr><th style="width:50px;">順位</th><th>アポインター名</th><th>獲得P</th><th>平均P</th><th>件数</th><th>平均数</th><th>稼働時間</th><th>ランク</th><th>会社</th></tr></thead><tbody>';
                } else {
                    echo '<table><thead><tr><th style="width:50px;">順位</th><th>名前</th><th>完了P</th><th>完了件数</th><th>マイナスP</th></tr></thead><tbody>';
                }
                $temp_point = NULL;
                foreach ($result as $value) {
                    $time = $value->time_num > 0 ? $value->time_num / 60 : 0;
                    $minus = $value->minus == 0 ? '' : $value->minus;
                    echo "<tr class='rank_{$value->ranking}'>";
                        echo "<td class='int'>{$value->ranking}</td>"; // 順位
                        echo "<td class='txt'>{$value->name}</td>"; // アポインター名
                        echo "<td class='int'>{$value->point_num}</td>"; // 獲得P
                        echo "<td class='int'></td>"; // 平均P
                        echo "<td class='int'>{$value->count}</td>"; // 件数
                        echo "<td class='int'></td>"; // 平均数
                        echo "<td class='int'>{$time} h</td>"; // 稼働時間
                        echo "<td class='txt'>{$value->rank} h</td>"; // ランク
                        echo "<td class='txt'>{$value->company} h</td>"; // 会社
                        if ($type === 'get') {
                            echo '<td class="int">'.number_format($time, 1).' h</td>';
                        }
                        if ($type === 'fin') {
                            echo '<td class="int">'.$minus.'</td>';
                        }
                    echo '</tr>';
                    $temp_point = $value->point_num;
                }
                echo '</tbody></table>';
            } else {
                echo '<div class="data-none">データがありません</div>';
            }
        }
    }
}