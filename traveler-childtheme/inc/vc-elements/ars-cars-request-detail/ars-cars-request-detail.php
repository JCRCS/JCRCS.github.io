<?php

if (!st_check_service_available('st_cars')) {
    return;
}
if (function_exists('vc_map')) {
    vc_map(array(
        "name" => __("ARS Car Request Detail", ST_TEXTDOMAIN),
        "base" => "ars_car_request_details",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => 'Antigua R&S',
        "params" => array(
        )
    ));
}

if (!function_exists('ars_vc_car_request_details')) {

    function ars_vc_car_request_details($attr, $content = false) {

        wp_enqueue_script('magnific.js');

        $default = array(
            'drop-off' => __('none', ST_TEXTDOMAIN),
            'pick-up' => __('none', ST_TEXTDOMAIN),
            'location_id_drop_off' => '',
            'location_id_pick_up' => '',
        );

        $_REQUEST = wp_parse_args($_REQUEST, $default);


        if (!empty($_REQUEST['pick-up-date'])) {
            $pick_up_date = $_REQUEST['pick-up-date'];
        } else {
            $pick_up_date = date(TravelHelper::getDateFormat(), strtotime("now"));
        }
        if (!empty($_REQUEST['pick-up-time'])) {
            $pick_up_time = $_REQUEST['pick-up-time'];
        } else {
            $pick_up_time = "12:00 AM";
        }
        if (STInput::request("location_id_pick_up")) {
            $address_pick_up = get_the_title(STInput::request("location_id_pick_up"));
        } else {
            $address_pick_up = STInput::request('pick-up');
        }
        if (!empty($_REQUEST['st_google_location_pickup'])) {
            $address_pick_up = STInput::request('st_google_location_pickup', '');
        }
        $pick_up = '<h5>' . st_get_language('car_pick_up') . ':</h5>
        <p><i class="fa fa-map-marker box-icon-inline box-icon-gray"></i>' . $address_pick_up . '</p>
        <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i>' . $pick_up_date . '</p>
        <p><i class="fa fa-clock-o box-icon-inline box-icon-gray"></i>' . $pick_up_time . '</p>';

        if (!empty($_REQUEST['drop-off-date'])) {
            $drop_off_date = $_REQUEST['drop-off-date'];
        } else {
            $drop_off_date = $pick_up_date = date(TravelHelper::getDateFormat(), strtotime("+1 day"));
        }

        if (!empty($_REQUEST['drop-off-time'])) {
            $drop_off_time = $_REQUEST['drop-off-time'];
        } else {
            $drop_off_time = "12:00 AM";
        }
        if (STInput::request('location_id_drop_off')) {
            $address_drop_off = get_the_title(STInput::request('location_id_drop_off'));
        } elseif (STInput::request('drop_off')) {
            $address_drop_off = STInput::request('drop_off');
        } else {
            $address_drop_off = $address_pick_up;
        }
        if (!empty($_REQUEST['st_google_location_dropoff'])) {
            $address_drop_off = STInput::request('st_google_location_dropoff', '');
        }
        $drop_off = '   <h5>' . st_get_language('car_drop_off') . ':</h5>
                        <p><i class="fa fa-map-marker box-icon-inline box-icon-gray"></i>' . $address_drop_off . '</p>
                        <p><i class="fa fa-calendar box-icon-inline box-icon-gray"></i>' . $drop_off_date . '</p>
                        <p><i class="fa fa-clock-o box-icon-inline box-icon-gray"></i>' . $drop_off_time . '</p>';

        $logo = get_post_meta(get_the_ID(), 'cars_logo', true);
        if (is_numeric($logo)) {
            $logo = wp_get_attachment_url($logo);
        }
        if (!empty($logo)) {
            $logo = '<img src="' . bfi_thumb($logo, array('width' => '120',
                        'height' => '120'
                    )) . '" alt="logo" />';
        }
        $about = get_post_meta(get_the_ID(), 'cars_about', true);
        if (!empty($about)) {
            $about = ' <h5>' . st_get_language('car_about') . '</h5>
                      <p>' . get_post_meta(get_the_ID(), 'cars_about', true) . '</p>';
        }


        return '<div class="booking-item-deails-date-location border-main">
                        <ul>
                            <li>' . $pick_up . '</li>
                            <li>' . $drop_off . '</li>
                        </ul>
                        <a href="#search-dialog" data-effect="mfp-zoom-out" class="btn btn-primary popup-text" href="#">' . st_get_language('change_location_and_date') . '</a>
                    </div>';
    }

}

if (st_check_service_available('st_cars') AND function_exists('st_reg_shortcode')) {
    st_reg_shortcode('ars_car_request_details', 'ars_vc_car_request_details');
}