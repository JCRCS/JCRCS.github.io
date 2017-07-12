<?php

/*
  Template Name: iCal importer
 */

$item_id = (int) $_GET["item_id"];

if (!empty($item_id)) {
    $args = array('p' => $item_id);
    $expire = 0;
} else {
    $args = array();
    $expire = 3600;
}
$args = array_merge($args, array(
    'post_type' => 'st_rental',
    'meta_key' => 'st_rental_ical_source_url',
    'meta_value' => ' ',
    'meta_compare' => '!=',
    'posts_per_page' => -1
    )
);
$the_query = new WP_Query($args);
var_dump($the_query);
if ($the_query->have_posts()) {
    while ($the_query->have_posts()) {
        $the_query->the_post();
        $item_id = get_the_ID();
        
        $n = ars_sync_iCal_rental ($item_id, $expire);
        
        echo "$n events found and updated for " . get_the_title() . "\n";
    }
} else {
    echo 'nothing to do here';
}
/* Restore original Post Data */
wp_reset_postdata();
