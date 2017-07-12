<?php

/**
 * @since 1.1.3
 * List Rental Room
 * */
if (function_exists('vc_map')) {

    vc_map(array(
        'name' => __('ARS Rental Search', ST_TEXTDOMAIN),
        'base' => 'ars_rental_search',
        'content_element' => true,
        'show_settings_on_create' => true,
        'icon' => 'icon-st',
        'category' => 'Antigua R&S',
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Header text', ST_TEXTDOMAIN),
                'param_name' => 'header_title',
                'value' => __('Rental Search', ST_TEXTDOMAIN)
            ),
        ),
    ));
}

if (!function_exists('ars_rental_search_ft')) {
    function ars_rental_search_ft($attr) {
        
        $template = ARS_THEME_DIR . "/st_templates/ars_rental_search.php";
        
        if (file_exists($template)) {
            ob_start();
            include $template;
            $output = @ob_get_clean();
            return $output;
        }
    }
}

if (function_exists('st_reg_shortcode')) {
    st_reg_shortcode('ars_rental_search', 'ars_rental_search_ft');
}
