<?php

if (function_exists('vc_map')) {

    $list_location = TravelerObject::get_list_location();
    $list_location_data[__('-- Select --', ST_TEXTDOMAIN)] = '';
    if (!empty($list_location)) {
        foreach ($list_location as $k => $v) {
            $list_location_data[$v['title']] = $v['id'];
        }
    }

    vc_map(
            array(
                "name" => __("ARS Flights", ST_TEXTDOMAIN),
                "base" => "ars_flights",
                "content_element" => true,
                "icon" => "icon-st",
                "category" => 'Antigua R&S',
                "params" => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Title", ST_TEXTDOMAIN),
                        "param_name" => "title",
                        "description" => "",
                        "value" => "",
                    ),
                    array(
                        "type" => "attach_image",
                        "holder" => "div",
                        "heading" => __("Image", ST_TEXTDOMAIN),
                        "param_name" => "image",
                        "description" => "",
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Origin", ST_TEXTDOMAIN),
                        "param_name" => "origin",
                        "description" => "",
                        "value" => $list_location_data
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Destination", ST_TEXTDOMAIN),
                        "param_name" => "destination",
                        "description" => "",
                        "value" => $list_location_data
                    ),
                    array(
                        "type" => "textfield",
                        'admin_label' => true,
                        "heading" => __("Duration", ST_TEXTDOMAIN),
                        "param_name" => "duration",
                        "description" => "",
                        'value' => '',
                    ),
                    array(
                        "type" => "textfield",
                        'admin_label' => true,
                        "heading" => __("Price", ST_TEXTDOMAIN),
                        "param_name" => "price",
                        "description" => "",
                        'value' => '',
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Ticket type", ST_TEXTDOMAIN),
                        "param_name" => "ticket",
                        "description" => "",
                        "value" => array(
                            "One-way" => 'ow',
                            "Round-trip" => 'rt',
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        'admin_label' => true,
                        "heading" => __("Schedule", ST_TEXTDOMAIN),
                        "param_name" => "schedule",
                        "description" => "",
                        'value' => 'Daily',
                    ),
                    array(
                        "type" => "textfield",
                        'admin_label' => true,
                        "heading" => __("Departure information", ST_TEXTDOMAIN),
                        "param_name" => "departure",
                        "description" => "",
                        'value' => '',
                    ),
                    array(
                        "type" => "textfield",
                        'admin_label' => true,
                        "heading" => __("Arrival information", ST_TEXTDOMAIN),
                        "param_name" => "arrival",
                        "description" => "",
                        'value' => '',
                    ),
                ),
            )
    );
}

if (!function_exists('ars_vc_flights')) {

    function ars_vc_flights ($attr, $content = false) {
        $template = ARS_THEME_DIR . "/st_templates/flights/flights.php";

        if (file_exists($template)) {
            ob_start();
            include $template;
            $output = @ob_get_clean();
            return $output;
        }
    }

}

if (function_exists('st_reg_shortcode')) {
    st_reg_shortcode('ars_flights', 'ars_vc_flights');
}