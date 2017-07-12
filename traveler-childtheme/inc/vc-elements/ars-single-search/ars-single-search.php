<?php

if (function_exists('vc_map')) {
    vc_map(array(
        "name" => __("ARS Single Search", ST_TEXTDOMAIN),
        "base" => "ars_single_search",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Antigua R&S",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title form search", ST_TEXTDOMAIN),
                "param_name" => "ars_title_search",
                "description" => "",
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Select form search", ST_TEXTDOMAIN),
                "param_name" => "ars_liars_form",
                "description" => "",
                'value' => array(
                    __('--Select--', ST_TEXTDOMAIN) => '',
                    __('Transport', ST_TEXTDOMAIN) => 'transport'
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Form's direction", ST_TEXTDOMAIN),
                "param_name" => "ars_direction",
                "description" => "",
                'value' => array(
                    __('--Select--', ST_TEXTDOMAIN) => '',
                    __('Vertical form', ST_TEXTDOMAIN) => 'vertical',
                    __('Horizontal form', ST_TEXTDOMAIN) => 'horizontal'
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style", ST_TEXTDOMAIN),
                "param_name" => "ars_style_search",
                "description" => "",
                'value' => array(
                    __('--Select--', ST_TEXTDOMAIN) => '',
                    __('Large', ST_TEXTDOMAIN) => 'style_1',
                    __('Normal', ST_TEXTDOMAIN) => 'style_2',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show box shadow", ST_TEXTDOMAIN),
                "param_name" => "ars_box_shadow",
                "description" => "",
                'value' => array(
                    __('--Select--', ST_TEXTDOMAIN) => '',
                    __('No', ST_TEXTDOMAIN) => 'no',
                    __('Yes', ST_TEXTDOMAIN) => 'yes'
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Field Size", ST_TEXTDOMAIN),
                "param_name" => "field_size",
                "description" => "",
                'value' => array(
                    __('--Select--', ST_TEXTDOMAIN) => '',
                    __('Large', ST_TEXTDOMAIN) => 'lg',
                    __('Normal', ST_TEXTDOMAIN) => 'sm',
                )
            ),
        )
    ));
}

if (!function_exists('ars_vc_single_search')) {

    function ars_vc_single_search($attr, $content = false) {
        return true;
        
        $data = shortcode_atts(
                array(
            'ars_liars_form' => '',
            'ars_style_search' => 'style_1',
            'ars_direction' => 'horizontal',
            'ars_box_shadow' => 'no',
            'ars_search_tabs' => 'yes',
            'ars_title_search' => '',
            'field_size' => 'lg',
            'active' => 1
                ), $attr, 'ars_single_search');
        extract($data);

        $template = ARS_THEME_DIR . "/st_templates/transport/elements/single-search.php";

        if (file_exists($template)) {
            ob_start();
            include $template;
            $output = @ob_get_clean();
            return $output;
        }
    }

}

if (st_check_service_available('st_tours') AND function_exists('st_reg_shortcode')) {
    st_reg_shortcode('ars_single_search', 'ars_vc_single_search');
}