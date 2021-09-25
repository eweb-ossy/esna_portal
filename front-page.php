<?php get_header(); ?>
<div class="wrap">
    <?php get_template_part('include/_side'); ?>
    <main class="main">
        <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
        <div class="main-title" style="background-image: url(<?= $url ?>)">
            <h1>株式会社ESNAgrp<br>ポータルサイト</h1>
        </div>
        <div class="main-message"><?php echo get_the_content(); ?></div>
        <div class="top-menu">
            <?php 
            $pages = get_pages(['parent'=>0, 'sort_column' => 'menu_order']);
            foreach ($pages as $page): ?>
            <?php if ($page->post_name === 'top') {
                continue;
            } ?>
            <div class="bloc">
                <a href="<?php echo get_page_link($page->ID); ?>">
                    <?php $url = wp_get_attachment_url( get_post_thumbnail_id($page->ID) ); ?>
                    <div class="top-menu-img">
                        <div class="img" style="background-image: url(<?= $url ?>)"></div>
                    </div>
                    <div class="top-menu-title"><?= $page->post_title ?></div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>
<?php get_footer(); ?>