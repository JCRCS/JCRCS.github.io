<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
extract($attr);

if (!empty($categories)) {
    $categories = explode(',', $categories);
    query_posts(array(
        'category__in' => $categories,
        'posts_per_page' => $num_posts,
    ));
} else {
    query_posts(array(
        'posts_per_page' => $num_posts,
    ));
}

        ?>
<div class="row featured-posts">
    <?php
if ($title) {
    if (!$font_size) {
        $font_size = "3";
    }
    
    ?>
    <div class="fp-title"><h<?php echo $font_size; ?>><i class="fa fa-newspaper-o fa-2"></i> <?php echo $title; ?></h<?php echo $font_size; ?>></div>
<?php
}
?>
    <?php
if (have_posts()) {
    while (have_posts()) {
        the_post(); 
        ?>
        <div class="featured-post-item">
            <div class="col-md-2" style="padding-left: 0">
                <div class="fp-tn"><a href="<?php the_permalink(); ?>" class=""><?php the_post_thumbnail('thumbnail'); ?></a></div>
        </div>
            <div class="col-md-10" style="padding: 0">
                <h4 class="fp-title"><a href="<?php the_permalink(); ?>" class=""><?php the_title(); ?></a></h4>
                    <p class="fp-published"><i class="fa fa-calendar"></i><a href="<?php the_permalink()?>"> <?php echo sprintf(__('Published on %s', ST_TEXTDOMAIN), get_the_time(get_option('date_format'))); ?></a></p>
                <p class="fp-excerpt"><?php the_content('Read More'); ?></p>
            </div>
        </div>
        <?php
    }
}
wp_reset_query();
$link = get_permalink(get_option('page_for_posts'));
        ?>
    <div class="fp-link"><a href="<?php echo $link; ?>" class="btn btn-small btn-primary"><?php echo __('Read more news and highlights', ST_TEXTDOMAIN); ?></a></div>
</div>