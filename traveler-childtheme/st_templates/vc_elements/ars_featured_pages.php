<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

extract($attr);

// get features pages
query_posts(array(
    'post_type' => 'page',
    'meta_key' => 'is_featured',
    'meta_value' => 'on',
    ));


    ?>
<div class="row featured-pages">
<?php
if ($title) {
    if (!$font_size) {
        $font_size = "3";
    }
    
    ?>
    <div class="fp-title"><h<?php echo $font_size; ?>><i class="fa fa-info-circle fa-2"></i> <?php echo $title; ?></h<?php echo $font_size; ?>></div>
<?php
}
?>
<ul class="">
<?php
if (have_posts()) {
    while (have_posts()) {
        the_post(); 
        ?><li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
</li>
        <?php
    }
}
wp_reset_query();

?>
</ul>
</div>