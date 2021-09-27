<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/staff.css?<?= time() ?>">

<div class="wrap">
    <?php get_template_part('include/_side'); ?>
    <main class="main">
        <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
        <div class="main-title" style="background-image: url(<?= $url ?>)">
            <h1><?php echo get_the_title(); ?></h1>
        </div>
        <div class="main-message">
            <?php echo get_the_content(); ?>
        </div>
        <section class="main-staff">
            <?php
            $staffs = get_posts(['post_type' => 'staff', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => -1]);
            foreach ($staffs as $staff): ?>
            <div class="staff-bloc">
                <?php $url = wp_get_attachment_url( get_post_thumbnail_id($staff->ID) ); ?>
                <div class="staff-img" style="background-image: url(<?= $url ?>)">
                </div>
                <div class="staff-text">
                    <div class="staff-post"><?= $staff->staff_post ?></div>
                    <div class="staff-name"><?= $staff->staff_name ?><span><?= $staff->staff_kana ?></span></div>
                    <?php if ($staff->staff_area): ?>
                        <div class="staff-detail staff-area">所属：<?= $staff->staff_area ?></div>
                    <?php endif; ?>
                    <?php if ($staff->staff_from): ?>
                        <div class="staff-detail staff-from">出身地：<?= $staff->staff_from ?></div>
                    <?php endif; ?>
                    <?php if ($staff->staff_hobby): ?>
                        <div class="staff-detail staff-hobby">趣味：<?= $staff->staff_hobby ?></div>
                    <?php endif; ?>
                    <?php if ($staff->staff_ability): ?>
                        <div class="staff-detail staff-ability">特技：<?= $staff->staff_ability ?></div>
                    <?php endif; ?>
                    <?php if ($staff->staff_nickname): ?>
                        <div class="staff-detail staff-nickname">ニックネーム：<?= $staff->staff_nickname ?></div>
                    <?php endif; ?>
                    <?php if ($staff->staff_boom): ?>
                        <div class="staff-detail staff-boom">最近ハマっているもの：<?= $staff->staff_boom ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </section>
    </main>
</div>
<?php get_footer(); ?>