<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/aporan.css?<?= time() ?>">

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
        <section class="main-aporan">
            <?php $now = date('Ym'); ?>
            <?= do_shortcode('[aporan date='.$now.']') ?>
        </section>
    </main>
</div>
<?php get_footer(); ?>