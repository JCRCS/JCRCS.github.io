<?php

if (!st_check_service_available('st_cars')) {
    return;
}
if (function_exists('vc_map')) {
    $param = array(
        array(
            "type" => "textfield",
            'admin_label' => true,
            "heading" => __("List ID in Car", ST_TEXTDOMAIN),
            "param_name" => "st_ids",
            "description" => __("Ids separated by commas", ST_TEXTDOMAIN),
            'value' => "",
        ),
        //        array(
        //            "type"        => "dropdown" ,
        //            "holder"      => "div" ,
        //            "heading"     => __( "Select Taxonomy" , ST_TEXTDOMAIN ) ,
        //            "param_name"  => "taxonomy" ,
        //            "description" => "" ,
        //            "value"       => st_list_taxonomy( 'st_cars' ) ,
        //        ) ,
        array(
            "type" => "textfield",
            'admin_label' => true,
            "heading" => __("Number cars", ST_TEXTDOMAIN),
            "param_name" => "st_number_cars",
            "description" => "",
            'value' => 4,
        ),
        array(
            "type" => "dropdown",
            'admin_label' => true,
            "heading" => __("Order By", ST_TEXTDOMAIN),
            "param_name" => "st_orderby",
            "description" => "",
            'edit_field_class' => 'vc_col-sm-6',
            'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by(
                    array(
                        __('Sale', ST_TEXTDOMAIN) => 'sale',
                        __('Featured', ST_TEXTDOMAIN) => 'featured',
                    )
            ) : array(),
        ),
        array(
            "type" => "dropdown",
            'admin_label' => true,
            "heading" => __("Order", ST_TEXTDOMAIN),
            "param_name" => "st_order",
            'value' => array(
                __('--Select--', ST_TEXTDOMAIN) => '',
                __('Asc', ST_TEXTDOMAIN) => 'asc',
                __('Desc', ST_TEXTDOMAIN) => 'desc'
            ),
            'edit_field_class' => 'vc_col-sm-6',
        ),
        array(
            "type" => "dropdown",
            'admin_label' => true,
            "heading" => __("Items per row", ST_TEXTDOMAIN),
            "param_name" => "st_cars_of_row",
            'edit_field_class' => 'vc_col-sm-12',
            "value" => array(
                __('--Select--', ST_TEXTDOMAIN) => '',
                __('Four', ST_TEXTDOMAIN) => 4,
                __('Three', ST_TEXTDOMAIN) => 3,
                __('Two', ST_TEXTDOMAIN) => 2,
            ),
        ),
        array(
            "type" => "st_list_location",
            'admin_label' => true,
            "heading" => __("Location", ST_TEXTDOMAIN),
            "param_name" => "st_location",
            "description" => __("Location", ST_TEXTDOMAIN)
        ),
    );

    $list_tax = TravelHelper::get_object_taxonomies_service('st_cars');
    if (!empty($list_tax)) {
        $tax = array();
        foreach ($list_tax as $label => $name) {
            $tax[$name] = $label;
        }
        $param[] = array(
            'type' => 'checkbox',
            'admin_label' => true,
            'heading' => 'Taxonomies to display',
            'param_name' => 'show_taxonomies',
            'value' => $tax
        );
    }

    vc_map(array(
        "name" => __("ARS Cars List", ST_TEXTDOMAIN),
        "base" => "ars_cars_list",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => 'Antigua R&S',
        "params" => $param
    ));
}

if (!function_exists('ars_vc_cars_list')) {

    function ars_vc_cars_list($attr) {
        global $st_search_args;

        $param = array(
            'st_ids' => '',
            'show_taxonomies' => '',
            'st_number_cars' => 4,
            'st_order' => '',
            'st_orderby' => '',
            'st_cars_of_row' => 4,
            'st_location' => '',
            'only_featured_location' => 'no',
        );

        $data = wp_parse_args($attr, $param);

        extract($data);
        $st_search_args = $data;
        $query = array(
            'post_type' => 'st_cars',
            'posts_per_page' => $st_number_cars,
            'order' => $st_order,
            'orderby' => $st_orderby
        );

        $st_search_args['featured_location'] = STLocation::inst()->get_featured_ids();

        $cars = STCars::get_instance();
        $cars->alter_search_query();
        global $wp_query;
        query_posts($query);
        $txt = '';
        $template = ARS_THEME_DIR . "/st_templates/vc_elements/ars_cars_list.php";
        while (have_posts()) {
            the_post();
            ob_start();
            include $template;
            $txt .= @ob_get_clean();
        }
        wp_reset_query();
        $cars->remove_alter_search_query();
        $st_search_args = null;
        return '<div class="row row-wrap">' . $txt . '</div>';
    }

}

if (st_check_service_available('st_cars') AND function_exists('st_reg_shortcode')) {
    st_reg_shortcode('ars_cars_list', 'ars_vc_cars_list');
}