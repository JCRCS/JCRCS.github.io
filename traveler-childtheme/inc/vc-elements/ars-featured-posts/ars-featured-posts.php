<?php


if (function_exists('vc_map')) {

    $terms_list = array();
    $terms = get_terms(array(
        'taxonomy' => 'category',
        'hide_empty' => false,
    ));
    foreach ($terms as $key => $val) {
        $terms_list[$val->name] = $val->term_id;
    }

    vc_map(array(
        "name" => __("ARS Featured Posts", ST_TEXTDOMAIN),
        "base" => "ars_featured_posts",
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
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number of posts to show", ST_TEXTDOMAIN),
                "param_name" => "num_posts",
                "description" => "",
                "value" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                'type' => 'checkbox',
                "holder" => "div",
                "heading" => __("Categories", ST_TEXTDOMAIN),
                'param_name' => 'categories',
                'value' => $terms_list
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

if (!function_exists('ars_vc_featured_posts')) {

    function ars_vc_featured_posts($attr, $content = false) {
        $template = ARS_THEME_DIR . "/st_templates/vc_elements/ars_featured_posts.php";

        if (file_exists($template)) {
            ob_start();
            include $template;
            $output = @ob_get_clean();
            return $output;
        }
    }

}

if (st_check_service_available('st_rental') AND function_exists('st_reg_shortcode')) {
    st_reg_shortcode('ars_featured_posts', 'ars_vc_featured_posts');
}