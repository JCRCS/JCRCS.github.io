<?php

if (!st_check_service_available('st_rental')) {
    return;
}
if (function_exists('vc_map')) {
    vc_map(array(
        "name" => __("ARS Rental Price Chart ", ST_TEXTDOMAIN),
        "base" => "ars_rental_price_chart",
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
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Font Size", ST_TEXTDOMAIN),
                "param_name" => "font_size",
                "description" => "",
                "value" => array(
                    __('--Select--', ST_TEXTDOMAIN) => '',
                    __("H1", ST_TEXTDOMAIN) => '1',
                    __("H2", ST_TEXTDOMAIN) => '2',
                    __("H3", ST_TEXTDOMAIN) => '3',
                    __("H4", ST_TEXTDOMAIN) => '4',
                    __("H5", ST_TEXTDOMAIN) => '5',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Chart Data", ST_TEXTDOMAIN),
                "param_name" => "chart_data",
                "description" => "List of days:label combinations, eg 1:night,7:week,30:month",
                "value" => "1:night,7:week,30:month",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Item Size", ST_TEXTDOMAIN),
                "param_name" => "item_col",
                "description" => "",
                "value" => array(
                    __('--Select--', ST_TEXTDOMAIN) => '',
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                    7 => 7,
                    8 => 8,
                    9 => 9,
                    10 => 10,
                    11 => 11,
                    12 => 12,
                ),
            )
        )
    ));
}

if (!function_exists('ars_vc_rental_price_chart')) {

    function ars_vc_rental_price_chart($attr, $content = false) {

        $template = ARS_THEME_DIR . "/st_templates/rentals/elements/price_chart.php";

        if (file_exists($template)) {
            ob_start();
            include $template;
            $output = @ob_get_clean();
            return $output;
        }
    }

}

if (st_check_service_available('st_rental') AND function_exists('st_reg_shortcode')) {
    st_reg_shortcode('ars_rental_price_chart', 'ars_vc_rental_price_chart');
}