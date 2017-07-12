<?php

/**
 * @since 1.1.3
 * List Rental Room
 * */
if (function_exists('vc_map')) {

    vc_map(array(
        'name' => __('ARS Rental Price', ST_TEXTDOMAIN),
        'base' => 'ars_rental_price',
        'content_element' => true,
        'show_settings_on_create' => true,
        'icon' => 'icon-st',
        'category' => 'Antigua R&S',
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Header text', ST_TEXTDOMAIN),
                'param_name' => 'header_title',
                'value' => __('Rental Price', ST_TEXTDOMAIN)
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
        ),
    ));
}

if (!function_exists('ars_rental_price_ft')) {
    function ars_rental_price_ft($attr, $content = false) {
        $template = ARS_THEME_DIR . "/st_templates/rentals/elements/price.php";
        
        if (file_exists($template)) {
            ob_start();
            include $template;
            $output = @ob_get_clean();
            return $output;
        }
    }
}

if (function_exists('st_reg_shortcode')) {
    st_reg_shortcode('ars_rental_price', 'ars_rental_price_ft');
}
