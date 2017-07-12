<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$lat = get_post_meta(get_the_ID(), 'map_lat', true);
$lng = get_post_meta(get_the_ID(), 'map_lng', true);
$zoom = get_post_meta(get_the_ID(), 'map_zoom', true);

$location_center = '[' . $lat . ',' . $lng . ']';
$data_map = array();
$data_map[0]['id'] = get_the_ID();
$data_map[0]['name'] = get_the_title();
$data_map[0]['post_type'] = get_post_type();
$data_map[0]['lat'] = $lat;
$data_map[0]['lng'] = $lng;

if ($location_center == '[,]')
    $location_center = '[0,0]';
if ($show_circle == 'no') {
    $range = 0;
}

$data_tmp = array(
    'location_center' => $location_center,
    'zoom' => $zoom,
    'data_map' => $data_map,
    'height' => 500,
    'style_map' => 'normal',
    'number' => $number,
    'range' => $range,
);
$data_tmp['data_tmp'] = $data_tmp;
extract($data_tmp);

wp_enqueue_script('detailed-map');
?>

<div class="map_single">
    <div id="gmap_wrapper" class="st_list_map">
        <div class="content_map" style="height: <?php echo esc_html($height) ?>px">
            <div id="list_map" class="gmap3" style="height: <?php echo esc_html($height) ?>px; width: 100%"></div>
        </div>
        <div class="st-gmap-loading-bg"></div>
        <div id="st-gmap-loading"><?php _e('Loading Maps', ST_TEXTDOMAIN); ?>
            <div class="spinner spinner_map ">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <div class="gmap-controls hidden">
            <input type="text" id="google-default-search" name="google-default-search" placeholder="<?php _e('Google Maps Search', ST_TEXTDOMAIN); ?>" value="" class="advanced_select  form-control">
        </div>
    </div>
    <div class="data_content hidden">
        <?php
        $data_map[0]['content_html'] = str_ireplace("'", '"', $data_map[0]['content_html']);
        echo balanceTags($data_map[0]['content_html']);
        ?>
    </div>
    <?php
    $data_map = json_encode($data_map, JSON_FORCE_OBJECT);
    $data_style_map = '[{featureType: "road.highway",elementType: "geometry",stylers: [{ hue: "#ff0022" },{ saturation: 60 },{ lightness: -20 }]}]';
    $street_views = get_post_meta(get_the_ID(), "enable_street_views_google_map", true);
    ?>
    <div class="hidden st_detailed_map"  
         data-data_show='<?php echo str_ireplace(array("'"), '\"', $data_map); ?>'
         data-map_height = '<?php echo str_ireplace(array("'"), '\"', esc_html($height)); ?>' 
         data-style_map = '<?php echo str_ireplace(array("'"), '\"', balanceTags($data_style_map)) ?>'
         data-type_map = '<?php echo str_ireplace(array("'"), '\"', get_post_meta(get_the_ID(), 'map_type', true)) ?>'
         data-street_views = '<?php echo str_ireplace(array("'"), '\"', esc_html($street_views)) ?>'

         data-height = "<?php echo esc_attr($height); ?>"
         data-location_center = "<?php echo esc_attr($location_center); ?>"
         data-zoom = "<?php echo esc_attr($zoom); ?>"
         data-range = "<?php echo esc_attr($range); ?>">&nbsp;</div> 
</div>
