<?php

/**
 * @since 1.1.3
 * List Rental Room
 * */
if (function_exists('vc_map')) {

    vc_map(array(
        'name' => __('ARS List Rental Room', ST_TEXTDOMAIN),
        'base' => 'ars_list_rental_room',
        'content_element' => true,
        'show_settings_on_create' => true,
        'icon' => 'icon-st',
        'category' => 'Antigua R&S',
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => __('Header text', ST_TEXTDOMAIN),
                'param_name' => 'header_title',
                'value' => __('Bedroom Distribution', ST_TEXTDOMAIN)
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Show Pictures', ST_TEXTDOMAIN),
                'param_name' => 'show_pictures',
                'value' => array(
                    __('Yes', ST_TEXTDOMAIN) => 'Y',
                    __('No', ST_TEXTDOMAIN) => 'N',
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Show Facilities', ST_TEXTDOMAIN),
                'param_name' => 'show_facilities',
                'value' => array(
                    __('Yes', ST_TEXTDOMAIN) => 'Y',
                    __('No', ST_TEXTDOMAIN) => 'N',
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Posts per page', ST_TEXTDOMAIN),
                'param_name' => 'post_per_page',
                'value' => 12
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Order by', ST_TEXTDOMAIN),
                'param_name' => 'order_by',
                'value' => array(
                    __('--Select--', ST_TEXTDOMAIN) => '',
                    __('none', ST_TEXTDOMAIN) => 'none',
                    __('ID', ST_TEXTDOMAIN) => 'ID',
                    __('Name', ST_TEXTDOMAIN) => 'name',
                    __('Date', ST_TEXTDOMAIN) => 'date',
                    __('Random', ST_TEXTDOMAIN) => 'rand'
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Order', ST_TEXTDOMAIN),
                'param_name' => 'order',
                'value' => array(
                    __('--Select--', ST_TEXTDOMAIN) => '',
                    __('Ascending', ST_TEXTDOMAIN) => 'asc',
                    __('Descending', ST_TEXTDOMAIN) => 'desc'
                )
            ),
        ),
    ));
}

if (!function_exists('ars_list_rental_room_ft')) {
    function ars_list_rental_room_ft($attr, $content = false) {
        $template = ARS_THEME_DIR . "/st_templates/vc_elements/ars_rental_rooms/ars_list_rental_room.php";
        
        if (file_exists($template)) {
            ob_start();
            include $template;
            $output = @ob_get_clean();
            return $output;
        }
    }
}

if (function_exists('st_reg_shortcode')) {
    st_reg_shortcode('ars_list_rental_room', 'ars_list_rental_room_ft');
}
