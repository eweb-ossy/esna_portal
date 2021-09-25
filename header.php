<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); wp_title('|', true, 'left'); ?></title>
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/base.css?<?= time() ?>" />
    <?php wp_head(); ?>
</head>
<body>
<!-- <header class="header">ヘッダー</header> -->