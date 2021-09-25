<?php get_header(); ?>
<div class="wrap">
    <?php get_template_part('include/_side'); ?>
    <main class="main">
        <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
        <div class="main-title" style="background-image: url(<?= $url ?>)">
            <h1><?php echo get_the_title(); ?></h1>
        </div>
        <section class="main-content">
            <?php echo get_the_content(); ?>
        </section>
    </main>
</div>
<?php get_footer(); ?>