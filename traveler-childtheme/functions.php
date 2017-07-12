<?php

define("ARS_THEME_DIR", dirname(__FILE__));

add_action('init', 'ars_add_metabox', 20);
add_action('init', 'ars_add_sidebar', 20);
add_action('init', 'ars_store_search_in_session', 20);


add_action('admin_menu', 'ars_admin_menu');

add_action('wp_footer', 'ars_ganalytics_tag');


if (!function_exists('ars_ganalytics_tag')) {

    function ars_ganalytics_tag() {
        require_once get_stylesheet_directory() . '/ganalytics.php';
    }

}

function modify_read_more_link() {
    return '</p>
                <p class="fp-readmore"><i class="fa fa-eye"></i> <a href="' . get_the_permalink() . '">' . __('Read More', ST_TEXTDOMAIN) . '</a>';
}

add_filter('the_content_more_link', 'modify_read_more_link');

function ars_admin_price_checker() {
    require_once get_stylesheet_directory() . '/admin/price_checker.php';
}

function ars_admin_menu() {
    add_menu_page('Antigua R&S', 'Price Calculator', 'manage_options', 'admin/price_checker.php', 'ars_admin_price_checker', 'dashicons-admin-generic', 50);
    //add_submenu_page('admin/price_checker.php', 'Antigua Rentals & Services Price Calculator', 'Price Calculator', 'manage_options', 'admin/price_checker.php');
}

add_action('init', 'ars_enqueue_icofont', 20);

if (!function_exists('ars_enqueue_icofont')) {

    function ars_enqueue_icofont() {
        wp_enqueue_style('icofont', get_template_directory_uri() . '/css/icofont.css');
    }

}

if (!function_exists('ars_get_tours_terms')) {

    function ars_get_tours_terms() {
        $options = array();
        $terms = get_terms(array('taxonomy' => 'st_tour_type'));

        foreach ($terms as $term) {
            $options[] = array(
                'label' => $term->name,
                'value' => $term->term_id,
            );
        }
        return $options;
    }

}
if (!function_exists('ars_add_sidebar')) {

    function ars_add_sidebar() {
        register_sidebar(array(
            'name' => __('Checkout Sidebar', ST_TEXTDOMAIN),
            'id' => 'checkout-sidebar',
            'description' => __('Widgets in this area will be shown on check-out pages.', ST_TEXTDOMAIN),
            'before_title' => '<h4>',
            'after_title' => '</h4>',
            'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
            'after_widget' => '</div>',
        ));
    }

}


if (!function_exists('ars_store_search_in_session')) {

    function ars_store_search_in_session() {
        if (isset($_REQUEST["s"])) {
            unset($_SESSION["search"]);
            $_SESSION["search"] = $_REQUEST;
        }
    }

}

if (!function_exists('ars_add_metabox')) {

    function ars_add_metabox() {
        /**  ARS Tour Prices * */
        $metabox[] = array(
            'id' => 'ars_tours_settings',
            'title' => __('Antigua Rentals Settings', ST_TEXTDOMAIN),
            'desc' => '',
            'pages' => array('st_tours'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'label' => __('Tour Required Client Information', ST_TEXTDOMAIN),
                    'id' => 'tours_clientinfo_tab',
                    'type' => 'tab'
                ),
                array(
                    'label' => __('Client Information Custom Fields', ST_TEXTDOMAIN),
                    'id' => 'tours_clientinfo',
                    'type' => 'list-item',
                    'settings' => array(
                        array(
                            'label' => __('Field Placeholder', ST_TEXTDOMAIN),
                            'id' => 'clientinfo_fieldplaceholder',
                            'type' => 'text',
                        ),
                        array(
                            'label' => __('Field Type', ST_TEXTDOMAIN),
                            'id' => 'clientinfo_fieldtype',
                            'type' => 'select',
                            'choices' => array(
                                array(
                                    'value' => 'text',
                                    'label' => __('Text', ST_TEXTDOMAIN)
                                ),
                                array(
                                    'value' => 'date-picker',
                                    'label' => __('Date', ST_TEXTDOMAIN)
                                ),
                                array(
                                    'value' => 'time-picker',
                                    'label' => __('Time', ST_TEXTDOMAIN)
                                ),
                                array(
                                    'value' => 'select',
                                    'label' => __('Dropdown menu', ST_TEXTDOMAIN)
                                ),
                                array(
                                    'value' => 'radio',
                                    'label' => __('Radio (one choice)', ST_TEXTDOMAIN)
                                ),
                                array(
                                    'value' => 'checkbox',
                                    'label' => __('Checkbox (multiple choice)', ST_TEXTDOMAIN)
                                ),
                            )
                        ),
                        array(
                            'label' => __('Select Field Options', ST_TEXTDOMAIN),
                            'id' => 'clientinfo_fieldoptions',
                            'type' => 'text',
                            'desc' => __('Options to choose from if select, radio or checkbox. Coma Seperated, ie: "Yes, No"', ST_TEXTDOMAIN),
                            'condition' => 'clientinfo_fieldtype:is(select),clientinfo_fieldtype:is(radio),clientinfo_fieldtype:is(checkbox)',
                            'operator' => 'or',
                        ),
                        array(
                            'id' => 'is_required',
                            'label' => __('Field required', ST_TEXTDOMAIN),
                            'type' => 'on-off',
                            'operator' => 'and',
                            'std' => 'on',
                        ),
                    ),
                ),
                array(
                    'label' => __('Tour Prices', ST_TEXTDOMAIN),
                    'id' => 'tours_prices_tab',
                    'type' => 'tab'
                ),
                array(
                    'label' => __('Prices by departure location', ST_TEXTDOMAIN),
                    'id' => 'tours_prices',
                    'type' => 'list-item',
                    'settings' => array(
                        array(
                            'label' => __('Select the origin for this price', ST_TEXTDOMAIN),
                            'id' => 'origin_post_id',
                            'desc' => __('Select Origin', ST_TEXTDOMAIN),
                            'placeholder' => __('Search for a location', ST_TEXTDOMAIN),
                            'type' => 'custom-post-type-select',
                            'post_type' => 'location',
                        ),
                        array(
                            'label' => __('Price valid from', ST_TEXTDOMAIN),
                            'desc' => __('Price valid from', ST_TEXTDOMAIN),
                            'id' => 'valid_from',
                            'type' => 'date-picker',
                        ),
                        array(
                            'label' => __('Price valid to', ST_TEXTDOMAIN),
                            'desc' => __('Price valid to', ST_TEXTDOMAIN),
                            'id' => 'valid_to',
                            'type' => 'date-picker',
                        ),
                        array(
                            'label' => __('Base Price', ST_TEXTDOMAIN),
                            'id' => 'base_price',
                            'type' => 'text',
                            'desc' => __('Base price for given number of pax and nights', ST_TEXTDOMAIN)
                        ),
                        array(
                            'label' => __('Base Price occupancy', ST_TEXTDOMAIN),
                            'desc' => __('Base number of pax for given base price', ST_TEXTDOMAIN),
                            'id' => 'base_pax',
                            'type' => 'numeric-slider',
                            'min_max_step' => '1,20,1',
                            'std' => 1,
                        ),
                        array(
                            'label' => __('Extra occupancy price', ST_TEXTDOMAIN),
                            'id' => 'extra_pax_price',
                            'type' => 'text',
                            'desc' => __('Price per extra given night or pax', ST_TEXTDOMAIN)
                        ),
                        array(
                            'label' => __('Price valid', ST_TEXTDOMAIN),
                            'id' => 'valid',
                            'type' => 'on-off',
                            'std' => 'on',
                        ),
                    ),
                ),
            ),
        );

        /**  ARS Rental Details * */
        $metabox[] = array(
            'id' => 'ars_rental_settings',
            'title' => __('Antigua Rentals Settings', ST_TEXTDOMAIN),
            'desc' => '',
            'pages' => array('st_rental'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'label' => __('Rental Details', ST_TEXTDOMAIN),
                    'id' => 'rental_details_tab',
                    'type' => 'tab'
                ),
                array(
                    'id' => 'ars_rental_num_bedrooms',
                    'label' => __('Number of bedrooms', ST_TEXTDOMAIN),
                    'desc' => __('Number of bedrooms', ST_TEXTDOMAIN),
                    'type' => 'numeric-slider',
                    'min_max_step' => '1,20,1',
                    'std' => 1
                ),
                array(
                    'id' => 'ars_rental_num_bathrooms',
                    'label' => __('Number of bathrooms', ST_TEXTDOMAIN),
                    'desc' => __('Number of bathrooms', ST_TEXTDOMAIN),
                    'type' => 'numeric-slider',
                    'min_max_step' => '1,20,1',
                    'std' => 1
                ),
                array(
                    'label' => __('Bedrooms', ST_TEXTDOMAIN),
                    'id' => 'rental_bedrooms',
                    'type' => 'list-item',
                    'settings' => array(
                        array(
                            'id' => 'gallery',
                            'type' => 'gallery',
                            'label' => __('Bedroom gallery', ST_TEXTDOMAIN),
                            'desc' => __('Upload room images to show to customers', ST_TEXTDOMAIN),
                        ),
                        array(
                            'id' => 'capacity',
                            'label' => __('Capacity', ST_TEXTDOMAIN),
                            'type' => 'numeric-slider',
                            'min_max_step' => '1,20,1',
                            'std' => 1
                        ),
                        array(
                            'id' => 'beds',
                            'label' => __('Number of beds', ST_TEXTDOMAIN),
                            'type' => 'numeric-slider',
                            'min_max_step' => '1,10,1',
                            'std' => 1
                        ),
                        array(
                            'id' => 'en-suite_bathroom',
                            'label' => __('En suite bathroom', ST_TEXTDOMAIN),
                            'type' => 'on-off',
                            'std' => 'off',
                        ),
                        array(
                            'id' => 'bedding',
                            'type' => 'checkbox',
                            'label' => __('Bedding', ST_TEXTDOMAIN),
                            'desc' => __('Select the bedding types available in this room', ST_TEXTDOMAIN),
                            'choices' => ars_get_taxonomy_options('rental_room', 'room_bedding'),
                        ),
                        array(
                            'id' => 'facilities',
                            'type' => 'checkbox',
                            'label' => __('Facilities', ST_TEXTDOMAIN),
                            'desc' => __('Select the facilities available in this room', ST_TEXTDOMAIN),
                            'choices' => ars_get_taxonomy_options('rental_room', 'room_facilities'),
                        ),
                    ),
                ),
                array(
                    'label' => __('Rental Prices', ST_TEXTDOMAIN),
                    'id' => 'rental_prices_tab',
                    'type' => 'tab'
                ),
                array(
                    'label' => __('Prices', ST_TEXTDOMAIN),
                    'id' => 'rental_prices',
                    'type' => 'list-item',
                    'settings' => array(
                        array(
                            'label' => __('Price valid from', ST_TEXTDOMAIN),
                            'desc' => __('Price valid from. No date = currently valid.', ST_TEXTDOMAIN),
                            'id' => 'valid_from',
                            'type' => 'date-picker',
                        ),
                        array(
                            'label' => __('Price valid to', ST_TEXTDOMAIN),
                            'desc' => __('Price valid to. No date = valid with no limit.', ST_TEXTDOMAIN),
                            'id' => 'valid_to',
                            'type' => 'date-picker',
                        ),
                        array(
                            'label' => __('Base Price', ST_TEXTDOMAIN),
                            'id' => 'base_price',
                            'type' => 'text',
                            'desc' => __('Base price for given number of pax (occupancy) and nights', ST_TEXTDOMAIN)
                        ),
                        array(
                            'label' => __('Base Price occupancy', ST_TEXTDOMAIN),
                            'desc' => __('Base price above is for this occupancy (number of pax, 0=price is for unit regardless of occupancy)', ST_TEXTDOMAIN),
                            'id' => 'base_pax',
                            'type' => 'numeric-slider',
                            'min_max_step' => '0,20,1',
                            'std' => 0,
                        ),
                        array(
                            'label' => __('Base Price nights', ST_TEXTDOMAIN),
                            'desc' => __('Base price above is for this number of nights', ST_TEXTDOMAIN),
                            'id' => 'base_nights',
                            'type' => 'numeric-slider',
                            'min_max_step' => '1,50,1',
                            'std' => 1,
                        ),
                        array(
                            'label' => __('Days this price applies on', ST_TEXTDOMAIN),
                            'desc' => __('This price will only apply on the following days (none selected = valid everyday)', ST_TEXTDOMAIN),
                            'id' => 'days',
                            'type' => 'checkbox',
                            'choices' => array(
                                array(
                                    'label' => __('Everyday (overrides the rest if selected)', ST_TEXTDOMAIN),
                                    'value' => '0'
                                ),
                                array(
                                    'label' => __('Monday', ST_TEXTDOMAIN),
                                    'value' => '1'
                                ),
                                array(
                                    'label' => __('Tuesday', ST_TEXTDOMAIN),
                                    'value' => '2'
                                ),
                                array(
                                    'label' => __('Wednesday', ST_TEXTDOMAIN),
                                    'value' => '3'
                                ),
                                array(
                                    'label' => __('Thursday', ST_TEXTDOMAIN),
                                    'value' => '4'
                                ),
                                array(
                                    'label' => __('Friday', ST_TEXTDOMAIN),
                                    'value' => '5'
                                ),
                                array(
                                    'label' => __('Saturday', ST_TEXTDOMAIN),
                                    'value' => '6'
                                ),
                                array(
                                    'label' => __('Sunday', ST_TEXTDOMAIN),
                                    'value' => '7'
                                ),
                            ),
                        ),
                        /*
                          array(
                          'label' => __('Extra night price', ST_TEXTDOMAIN),
                          'id' => 'extra_night_price',
                          'type' => 'text',
                          'desc' => __('Price per extra nights over base number of nights above', ST_TEXTDOMAIN)
                          ),
                          array(
                          'id' => 'extra_pax_price',
                          'label' => __('Extra occupancy', ST_TEXTDOMAIN),
                          'desc' => __('Price per extra pax over base occupancy above', ST_TEXTDOMAIN),
                          'type' => 'text',
                          ),
                          array(
                          'label' => __('Extra occupancy price type', ST_TEXTDOMAIN),
                          'type' => 'Extra occupancy price to be charged by night or per booking?',
                          'id' => 'extra_pax_type',
                          'type' => 'select',
                          'choices' => array(
                          array(
                          'label' => __('per Night', ST_TEXTDOMAIN),
                          'value' => 'N'
                          ),
                          array(
                          'label' => __('per Booking', ST_TEXTDOMAIN),
                          'value' => 'B'
                          ),
                          )
                          ),
                         * 
                         */
                        array(
                            'label' => __('Minimum stay', ST_TEXTDOMAIN),
                            'desc' => __('This price will only apply for this minimum of night. 0 = no minimum', ST_TEXTDOMAIN),
                            'id' => 'minimum_stay',
                            'type' => 'text',
                            'std' => 1,
                        ),
                        array(
                            'label' => __('Maximum stay', ST_TEXTDOMAIN),
                            'desc' => __('This price will only apply for this maximum of night. 0 = no maximum', ST_TEXTDOMAIN),
                            'id' => 'maximum_stay',
                            'type' => 'text',
                            'std' => 0,
                        ),
                        array(
                            'label' => __('Price valid', ST_TEXTDOMAIN),
                            'id' => 'valid',
                            'type' => 'on-off',
                            'std' => 'on',
                        ),
                    ),
                ),
                array(
                    'label' => __('Supplements', ST_TEXTDOMAIN),
                    'id' => 'rental_supplements',
                    'type' => 'list-item',
                    'settings' => array(
                        array(
                            'label' => __('Supplement valid from', ST_TEXTDOMAIN),
                            'desc' => __('Supplement valid for order confirmed from. No date = currently valid.', ST_TEXTDOMAIN),
                            'id' => 'sales_from',
                            'type' => 'date-picker',
                        ),
                        array(
                            'label' => __('Supplement valid to', ST_TEXTDOMAIN),
                            'desc' => __('Supplement valid for order confirmed to. No date = valid with no limit.', ST_TEXTDOMAIN),
                            'id' => 'sales_to',
                            'type' => 'date-picker',
                        ),
                        array(
                            'label' => __('Supplement valid for rental day between (start)', ST_TEXTDOMAIN),
                            'desc' => __('Supplement applies to a rental booking including these period starting from', ST_TEXTDOMAIN),
                            'id' => 'applies_from',
                            'type' => 'date-picker',
                        ),
                        array(
                            'label' => __('Supplement valid for rental day between (end)', ST_TEXTDOMAIN),
                            'desc' => __('Supplement applies to a rental booking including these period ending to', ST_TEXTDOMAIN),
                            'id' => 'applies_to',
                            'type' => 'date-picker',
                        ),
                        array(
                            'label' => __('Force minimum stay', ST_TEXTDOMAIN),
                            'desc' => __('Overrules minimum stay for any booking on these dates.', ST_TEXTDOMAIN),
                            'id' => 'obligatory_minimum_stay',
                            'type' => 'text',
                            'std' => 0,
                        ),
                        array(
                            'label' => __('Minimum stay', ST_TEXTDOMAIN),
                            'desc' => __('This Supplement will only apply for this minimum of night', ST_TEXTDOMAIN),
                            'id' => 'minimum_stay',
                            'type' => 'text',
                            'std' => 1,
                        ),
                        array(
                            'label' => __('Maximum stay', ST_TEXTDOMAIN),
                            'desc' => __('This Supplement will only apply for this maximum of night', ST_TEXTDOMAIN),
                            'id' => 'maximum_stay',
                            'type' => 'numeric-slider',
                            'min_max_step' => '0,365,1',
                            'std' => 0,
                        ),
                        array(
                            'id' => 'rate',
                            'label' => __('Supplement rate', ST_TEXTDOMAIN),
                            'desc' => __('Negative or positive value', ST_TEXTDOMAIN),
                            'type' => 'text',
                        ),
                        array(
                            'label' => __('Supplement type', ST_TEXTDOMAIN),
                            'type' => 'The supplement is per percent of total amount, per person, per night, per person pernight, or per booking',
                            'id' => 'type',
                            'type' => 'select',
                            'choices' => array(
                                array(
                                    'label' => __('Percent', ST_TEXTDOMAIN),
                                    'value' => 'PC'
                                ),
                                array(
                                    'label' => __('Per person', ST_TEXTDOMAIN),
                                    'value' => 'PP'
                                ),
                                array(
                                    'label' => __('Per night', ST_TEXTDOMAIN),
                                    'value' => 'PN'
                                ),
                                array(
                                    'label' => __('Per person per night', ST_TEXTDOMAIN),
                                    'value' => 'PPN'
                                ),
                                array(
                                    'label' => __('Per booking', ST_TEXTDOMAIN),
                                    'value' => 'PB'
                                ),
                            )
                        ),
                        array(
                            'label' => __('Days this supplement applies on', ST_TEXTDOMAIN),
                            'desc' => __('This supplement will only apply on the nightly rate on specific days (none selected = valid everyday)', ST_TEXTDOMAIN),
                            'id' => 'days',
                            'type' => 'checkbox',
                            'choices' => array(
                                array(
                                    'label' => __('Everyday (overrides the rest if selected)', ST_TEXTDOMAIN),
                                    'value' => '0'
                                ),
                                array(
                                    'label' => __('Monday', ST_TEXTDOMAIN),
                                    'value' => '1'
                                ),
                                array(
                                    'label' => __('Tuesday', ST_TEXTDOMAIN),
                                    'value' => '2'
                                ),
                                array(
                                    'label' => __('Wednesday', ST_TEXTDOMAIN),
                                    'value' => '3'
                                ),
                                array(
                                    'label' => __('Thursday', ST_TEXTDOMAIN),
                                    'value' => '4'
                                ),
                                array(
                                    'label' => __('Friday', ST_TEXTDOMAIN),
                                    'value' => '5'
                                ),
                                array(
                                    'label' => __('Saturday', ST_TEXTDOMAIN),
                                    'value' => '6'
                                ),
                                array(
                                    'label' => __('Sunday', ST_TEXTDOMAIN),
                                    'value' => '7'
                                ),
                            ),
                        ),
                        array(
                            'label' => __('Supplement valid', ST_TEXTDOMAIN),
                            'id' => 'valid',
                            'type' => 'on-off',
                            'std' => 'on',
                        ),
                    ),
                ),
                array(
                    'label' => __('Options', ST_TEXTDOMAIN),
                    'id' => 'rental_options',
                    'type' => 'list-item',
                    'settings' => array(
                        array(
                            'label' => __('Minimum stay', ST_TEXTDOMAIN),
                            'desc' => __('This option will only apply for this minimum of night', ST_TEXTDOMAIN),
                            'id' => 'minimum_stay',
                            'type' => 'text',
                            'std' => 1,
                        ),
                        array(
                            'label' => __('Maximum stay', ST_TEXTDOMAIN),
                            'desc' => __('This option will only apply for this maximum of night', ST_TEXTDOMAIN),
                            'id' => 'maximum_stay',
                            'type' => 'text',
                            'std' => 0,
                        ),
                        array(
                            'id' => 'rate',
                            'label' => __('Option rate', ST_TEXTDOMAIN),
                            'desc' => __('Negative or positive value', ST_TEXTDOMAIN),
                            'type' => 'text',
                        ),
                        array(
                            'label' => __('Option type', ST_TEXTDOMAIN),
                            'type' => 'The supplement is per percent of total amount, per person, per night, per person pernight, or per booking',
                            'id' => 'type',
                            'type' => 'select',
                            'choices' => array(
                                array(
                                    'label' => __('Percent', ST_TEXTDOMAIN),
                                    'value' => 'PC'
                                ),
                                array(
                                    'label' => __('Per person', ST_TEXTDOMAIN),
                                    'value' => 'PP'
                                ),
                                array(
                                    'label' => __('Per night', ST_TEXTDOMAIN),
                                    'value' => 'PN'
                                ),
                                array(
                                    'label' => __('Per person per night', ST_TEXTDOMAIN),
                                    'value' => 'PPN'
                                ),
                                array(
                                    'label' => __('Per booking', ST_TEXTDOMAIN),
                                    'value' => 'PB'
                                ),
                            )
                        ),
                        array(
                            'label' => __('Option valid', ST_TEXTDOMAIN),
                            'id' => 'valid',
                            'type' => 'on-off',
                            'std' => 'on',
                        ),
                    ),
                ),
            ),
        );
        ars_register_metabox($metabox);
    }

}

if (!function_exists('ars_get_location_name_from_id')) {

    function ars_get_location_name_from_id($post_id) {

        return get_the_title($post_id);
    }

}

if (!function_exists('ars_get_location_name_from_item_id')) {

    function ars_get_location_name_from_item_id($post_id = false) {
        $address = get_post_meta($post_id, 'address', true);
        if (!empty($address)) {
            return $address;
        }

        return TravelHelper::locationHtml($post_id);
    }

}
if (!function_exists('ars_get_taxonomy_options')) {

    function ars_get_taxonomy_options($post_type, $taxonomy) {
        $terms = get_terms($taxonomy, array(
            'hide_empty' => false,
        ));
        $options = array();
        foreach ($terms as $term) {
            $options[] = array(
                'label' => $term->name,
                'value' => $term->term_id,
            );
        };
        return $options;
    }

}


if (!function_exists('ars_cart_information')) {

    function ars_cart_information($st_booking_data) {

        if (!empty($st_booking_data['st_booking_id'])) {

            if (!empty($st_booking_data["origin_post_id"])) {
                $origin = get_the_title($st_booking_data["origin_post_id"]);
                if (!empty($origin)) {
                    echo '<p class="booking-item-description"><span><strong>' . __('From', ST_TEXTDOMAIN) . '</strong></span>: ' . $origin;
                    echo '<p class="booking-item-description"><span><strong>' . __('To', ST_TEXTDOMAIN) . '</strong></span>: ' . TravelHelper::locationHtml($st_booking_data['st_booking_id']);
                }
            }

            $custom_fields_prefix = "";
            if (!empty($st_booking_data['st_booking_post_type'])) {
                switch ($st_booking_data['st_booking_post_type']) {
                    case "st_tours": $custom_fields_prefix = "tours_";
                        break;
                }
            }
            $clientinfo_fields = get_post_meta($st_booking_data['st_booking_id'], $custom_fields_prefix . 'clientinfo', TRUE);

            if (!empty($clientinfo_fields)) {
                echo '
    <div class="cart_border_bottom"></div><p class="booking-item-description"><span><strong>Your travel information</strong></span><br>';

                foreach ($clientinfo_fields as $clientinfo_field) {

                    echo '<span>' . $clientinfo_field["title"] . '</span>: ';
                    if (!empty($st_booking_data['clientinfo_' . $clientinfo_field["clientinfo_fieldname"]])) {
                        echo '<strong>' . $st_booking_data['clientinfo_' . $clientinfo_field["clientinfo_fieldname"]] . '</strong>';
                    } else {
                        echo '<em>' . __('none', ST_TEXTDOMAIN) . '</em>';
                    }
                    echo '<br>';
                }
                echo '</p>';
            }
        }
    }

}

/* * * PRICE ** */


if (!function_exists('ars_save_post')) {

    function ars_save_post($post_id) {
        if (wp_is_post_revision($post_id)) {
            return;
        }
        $post_type = get_post_type($post_id);


        if ($post_type == 'st_tours') {
            $tours_clientinfo = get_post_meta($post_id, 'tours_clientinfo', true);

            if (is_array($tours_clientinfo) AND ! empty($tours_clientinfo)) {
                for ($i = 0; $i < count($tours_clientinfo); $i++) {
                    $tours_clientinfo[$i]['clientinfo_fieldname'] = strtolower(sanitize_file_name($tours_clientinfo[$i]['title']));
                }
                update_post_meta($post_id, 'tours_clientinfo', $tours_clientinfo);
            }

            $args = $_POST["tours_prices"];
            if (is_array($args) AND ! empty($args) AND ! empty($post_id)) {
                ars_price_db_update($post_id, $args);
                $price = ars_get_tour_best_price($post_id, 1);
                update_post_meta($post_id, 'price', $price);
                update_post_meta($post_id, 'adult_price', $price);
                update_post_meta($post_id, 'child_price', $price);
                update_post_meta($post_id, 'infant_price', $price);
            }
        } elseif ($post_type == 'st_rental') {
            $args = $_POST["rental_prices"];
            if (is_array($args) AND ! empty($args) AND ! empty($post_id)) {
                ars_price_db_update($post_id, $args);
            }
            $args = $_POST["rental_supplements"];
            if (is_array($args) AND ! empty($args) AND ! empty($post_id)) {
                ars_price_supplements_db_update($post_id, $args);
            }
            $args = $_POST["rental_options"];
            if (is_array($args) AND ! empty($args) AND ! empty($post_id)) {
                ars_price_options_db_update($post_id, $args);
            }
            // form all ARS price, update ST Rental Price
            $price = ars_get_rental_price_by_night($post_id, 1, null, true);
            update_post_meta($post_id, 'price', $price);

            // perform iCal sync
            $n = ars_sync_iCal_rental($item_id, 0);
        }
        return true;
    }

}
add_action('save_post', 'ars_save_post');


if (!function_exists(ars_sync_iCal_rental)) {

    function ars_sync_iCal_rental($item_id = 0, $expire = 3600) {

        if (empty($item_id)) {
            $item_id = get_the_ID();
        }

        $ical_source_url = trim(get_post_meta($item_id, 'st_rental_ical_source_url', true));
        $expire = (int) $expire;

        $n = 0;
        if ($expire > 0) {
            $iCal_last_sync = (int) get_post_meta($item_id, 'iCal_last_sync', true);
            if (($iCal_last_sync + $expire) > time()) { // Not yet time to update
                return $n;
            }
        }
        
        if (!empty($ical_source_url) AND filter_var($ical_source_url, FILTER_VALIDATE_URL)) {
            $ch = curl_init($ical_source_url);
            if (FALSE === $ch) {
                throw new Exception('failed to initialize');
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $content = curl_exec($ch);
            if (FALSE === $content) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
            curl_close($ch);

            // $content = file_get_contents($ical_source_url);
            if (!empty($content) AND stristr($content, "BEGIN:")) {
                preg_match("/TIMEZONE:(\S+)/", $content, $matches);
                if ($matches[1]) {
                    $tz = new DateTimeZone($matches[1]);
                }
                $data = explode("BEGIN:", $content);
                $events = array();

                foreach ($data as $key => $val) {
                    $event = explode("\n", $val);
                    if (!empty($event) AND trim($event[0]) == "VEVENT") {
                        foreach ($event as $value) {
                            $value = explode(":", trim($value));
                            if (!empty($value[1])) {
                                $events[$i][$value[0]] = $value[1];
                                if (stristr($value[0], "DTSTART")) {
                                    preg_match_all("/(\d{4})(\d{2})(\d{2})/", $value[1], $matches);
                                    $events[$i]['check_in'] = $matches[1][0] . "-" . $matches[2][0] . "-" . $matches[3][0];
                                }
                                if (stristr($value[0], "DTEND")) {
                                    preg_match_all("/(\d{4})(\d{2})(\d{2})/", $value[1], $matches);
                                    $events[$i]['check_out'] = $matches[1][0] . "-" . $matches[2][0] . "-" . $matches[3][0];
                                }
                            }
                        }
                        $i++;
                    }
                }
                $n = count($events);

                // UPDATE DB
                global $wpdb;
                foreach ($events as $event) {
                    if ($event['check_out'] > date("Y-m-d")) {
                        ars_update_availability($item_id, $event['check_in'], $event['check_out']);
                    }
                }
            }
            update_post_meta($item_id, 'iCal_last_sync', time());
        }
        return $n;
    }

}

if (!function_exists('ars_price_is_valid')) {

    function ars_price_is_valid($price, $date) {
        if ($price['valid'] == "on"
                AND ( empty($price['valid_to']) OR $price['valid_to'] >= $date)
                AND ( empty($price['valid_from']) OR $price['valid_from'] <= $date)) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('ars_get_tour_total_price')) {

    function ars_get_tour_total_price($tour_id, $origin_post_id, $passengers, $date) {
        $tour_prices = get_post_meta($tour_id, 'tours_prices', TRUE);
        $total_price = array(
            "title" => '',
            "price" => 0,
        );
        if (!empty($tour_prices) AND ! empty($origin_post_id)) {

            // Seek cheaper currently valid price
            foreach ($tour_prices as $tour_price) {
                $this_price = 0;
                if (ars_price_is_valid($tour_price, $date) AND $origin_post_id == $tour_price['origin_post_id']) {
                    $this_price = (int) $tour_price["base_price"];
                    if ($passengers > (int) $tour_price["base_pax"]) {
                        $extra_pax = $passengers - (int) $tour_price["base_pax"];
                        $this_price += $extra_pax * $tour_price["extra_pax_price"];
                    }
                }
                if (!empty($this_price) AND ( $this_price < $total_price OR $total_price == 0)) {
                    $total_price = array(
                        "title" => $tour_price['title'],
                        "price" => $this_price,
                    );
                }
            }

            return $total_price;
        }
    }

}

if (!function_exists('ars_get_tour_average_price')) {

    function ars_get_tour_average_price($price, $passengers) {

        $average_price = 0;
        if ($passengers < (int) $price['base_pax']) {
            $passengers = (int) $price['base_pax'];
        }
        if ($passengers > 0) {
            $average_price = ((int) $price['base_price'] + ((int) $price['extra_pax_price'] * ( $passengers - (int) $price['base_pax'] ) )) / $passengers;
        } else {
            $average_price = (int) $price['base_price'] / (int) $price['base_pax'];
        }
        return $average_price;
    }

}


if (!function_exists('ars_get_tour_best_prices')) {

    function ars_get_tour_best_prices($tour_id, $date = NULL) {
        $date = ars_date_parse($date);

        if (!$date) {
            $date = date("Y-m-d");
        }


        $tours_prices = get_post_meta($tour_id, 'tours_prices', TRUE);
        $max_people = (int) get_post_meta($tour_id, 'max_people', TRUE);

        $best_prices_by_origin = array();
        if (count($tours_prices) > 0 AND is_array($tours_prices)) {

            foreach ($tours_prices as $price) {
                $origin_post_id = $price['origin_post_id'];
                if (!isset($best_prices_by_origin[$origin_post_id])) {
                    $best_prices_by_origin[$origin_post_id] = 0;
                }
                // looking for best prices from now

                if (ars_price_is_valid($price, $date) AND ! empty($origin_post_id)) {
                    $price_from = ars_get_tour_average_price($price, $max_people);

                    if ((empty($best_prices_by_origin[$origin_post_id]) OR $best_prices_by_origin[$origin_post_id] > $price_from) AND ! empty($price_from)) {
                        $best_prices_by_origin[$origin_post_id] = $price_from;
                    }
                }
            }
        }
        return $best_prices_by_origin;
    }

}

if (!function_exists('ars_date_parse')) {

    function ars_date_parse($data) {

        $date = TravelHelper::convertDateFormat($data);

        if (is_int($date) AND $date >= time()) {
            $date = date("Y-m-d", $date);
        } elseif ($date) {
            $datetime_format = get_option('datetime_format');
            $date = strtotime($date);
            $date = date("Y-m-d", $date);
        }
        return $date;
    }

}



if (!function_exists('ars_get_tour_price_from_html')) {

    function ars_get_tour_price_from_html($tour_id) {
        global $wpdb;
        $sql = "SELECT
                    `base_price`,
                    `base_pax`,
                    `base_price`/`base_pax` as `price_pp`
                FROM
                        `{$wpdb->prefix}ars_prices`"
                . " WHERE `post_id` = " . (int) $tour_id . ""
                . " AND ( NOW() < `valid_to` OR `valid_to` = '0000-00-00' ) "
                . " AND ( NOW() > `valid_from` ) "
                . " AND `valid` = 1"
                . " ORDER BY `price_pp` ASC LIMIT 1 ";

        $price = $wpdb->get_results($sql);
        if (!empty($price)) {
            return '
            <span class="booking-item-price-from">' . __('prices from', ST_TEXTDOMAIN) . '</span>
            <span class="booking-item-price">' . TravelHelper::format_money($price[0]->price_pp) . '</span>'
                    . '<span class="booking-item-info-price">' . __('per person', ST_TEXTDOMAIN) . '</span><br>
            <span class="booking-item-info-price">' . ((int) $price[0]->base_pax > 1 ? sprintf(__('minimum %d people', ST_TEXTDOMAIN), $price[0]->base_pax) : '') . '</span>
            ';
        } else {
            return '';
        }
    }

}


if (!function_exists('ars_get_tour_base_price')) {

    function ars_get_tour_base_price($tour_id, $date = NULL) {
        $tours_prices = get_post_meta($tour_id, 'tours_prices', TRUE);
        if (!empty($tours_prices[0]['base_price'])) {
            return (int)$tours_prices[0]['base_price'];
        }
        return false;
    }

}

if (!function_exists('ars_get_tour_best_price')) {

    function ars_get_tour_best_price($tour_id, $date = NULL) {
        $best_price = 0;
        $best_prices = ars_get_tour_best_prices($tour_id, $date);
        foreach ($best_prices as $price) {
            if ($price < $best_price OR $best_price == 0) {
                $best_price = $price;
            }
        }
        return $best_price;
    }

}
#### SEARCH Transport #####
/*
  add_action('init', 'load_lib_transport');
  if (!function_exists('load_lib_transport')) {
  function load_lib_transport() {
  get_template_part('inc/class/class.transport');
  }
  }
 *
 * 
 */

#### PRICE ####

/* * ** DB **** */

if (!function_exists('ars_price_db_update')) {

    function ars_price_db_update($post_id, $args) {
        global $wpdb;
        $table = $wpdb->prefix . 'ars_prices';

        // clean up prices for post_id
        $wpdb->delete($table, array('post_id' => (int) $post_id));

        // insert new prices
        $data = array();
        foreach ($args as $price) {
            $data = array(
                "post_id" => $post_id,
            );
            foreach ($price as $key => $value) {
                if (stripos($key, "price_") === 0) {
                    $key = substr($key, 6);
                }
                if ($key == "valid") {
                    if ($value == "on") {
                        $value = 1;
                    } else {
                        $value = 0;
                    }
                }
                if ($key == "days" OR is_array($value)) {
                    if (in_array('0', $value) OR count($value) >= 7) {
                        $value = "";
                    } else {
                        $value = implode(',', $value);
                    }
                }
                $data[$key] = $value;
            }
            $insert = $wpdb->insert($table, $data);
            if (is_wp_error($insert)) {
                break;
            }
        }
        return true;
    }

}

if (!function_exists(ars_get_rental_availability)) {

    function ars_get_rental_availability($post_id, $check_in, $check_out) {

        $from = date('Y-m-d', $check_in);
        $to = date('Y-m-d', strtotime('-1 day', $check_out));
        global $wpdb;
        $sql = "SELECT SUM(1) as `unavailable` "
                . "FROM `{$wpdb->prefix}st_availability` "
                . "WHERE `status` = 'unavailable' "
                . " AND `post_id` = ".(int)$post_id
                . "AND `date` BETWEEN '$from' AND '$to' LIMIT 1 ";
        $result = $wpdb->get_results($sql);
        
        if (!empty($result[0]->unavailable)) {
            return false;
        }
        return true;
    }

}


if (!function_exists('ars_get_rental_price')) {

    function ars_get_rental_price($post_id, $check_in, $check_out, $pax = 0, $detailed = false) {
        $error = false;
        $message = "";
        $nights = NULL;

        // check capacity
        $capacity = (int) get_post_meta($post_id, 'rental_max_adult', true);
        if (empty($pax)) {
            $pax = $capacity;
        }
        if ($pax > $capacity) {
            $error = ($message = __("Number of pax exceeds capacity", ST_TEXTDOMAIN));
        }
        $minimum_nights = (int) get_post_meta($post_id, 'rentals_booking_min_day', true);
        $booking_min_day_diff = ($check_out - $check_in) / (60 * 60 * 24);
        if ($check_in >= $check_out) {
            $error = ($message = __("Dates are incoherent", ST_TEXTDOMAIN));
        } elseif ($booking_min_day_diff < $minimum_nights) {
            $error = ($message = vsprintf(__('Please book at least %d day(s) in total', ST_TEXTDOMAIN), $minimum_nights));
        }

        $check_in_date = date('Y-m-d', $check_in);
        $check_out_date = date('Y-m-d', $check_out);

        if (!$error) {
            // find best rate
            global $wpdb;
            $sql = "SELECT
                    `title`,
                    `valid_from`,
                    `valid_to`,
                    `days`,
                    `base_price`,
                    `base_nights`,
                    `base_pax`,
                    DATEDIFF('$check_out_date', '$check_in_date') as `nights`,
                    `base_price`/`base_nights` as `nightly_price`,
                    `base_price`/`base_nights`/$pax as `nightly_price_pp`

                FROM
                        `{$wpdb->prefix}ars_prices`"
                    . " WHERE `post_id` = " . (int) $post_id . ""
                    . " AND ( '$check_in_date' < `valid_to` OR `valid_to` = '0000-00-00' ) "
                    . " AND ( '$check_out_date' > `valid_from` OR `valid_from` = '0000-00-00' ) "
                    . " AND ( `base_pax` = 0 OR `base_pax` = $pax ) "
                    . " AND (`minimum_stay` = 0 OR `minimum_stay` <= DATEDIFF('$check_out_date', '$check_in_date') ) "
                    . " AND (`maximum_stay` = 0 OR `maximum_stay` >= DATEDIFF('$check_out_date', '$check_in_date'))"
                    . " AND `valid` = 1"
                    . " ORDER BY `nightly_price_pp` DESC, `nightly_price` DESC, `valid_from` ASC ";

            $prices = $wpdb->get_results($sql);

            $total_price = 0; // before supplements
            $final_price = 0; // after supplements
            $supplement_price = 0; // total supplements
            $price_breakdown = array(); // night by night

            if (!empty($prices)) {
                // we have several rates that apply, check each and every night
                $today = date_create($check_in_date);
                $continue = true;
                for ($i = 0; $continue; $i++) {
                    $today_price = 0;
                    foreach ($prices as $price) {
                        $days = "";
                        $nights = (int) $price->nights;
                        if (!empty($price->days)) {
                            $days = explode(',', $price->days);
                        }
                        if ((date_format($today, 'Y-m-d') >= $price->valid_from OR $price->valid_from == 0) AND ( date_format($today, 'Y-m-d') <= $price->valid_to OR $price->valid_to == 0)) {
                            // check if day applies
                            $today_wday = date_format($today, 'N');
                            if (( empty($today_price) OR (float) $price->nightly_price < $today_price )
                                    AND ( empty($days) OR in_array($today_wday, $days) )
                                    AND ( empty($price->base_pax) OR (int) $price->base_pax == $pax )) {
                                $today_price = (float) $price->nightly_price;
                            }
                        }
                    }
                    if (empty($today_price)) {
                        // no price today? => not a price for everyday, quit!
                        $error = ($message = "There wasn't a price found for each and every day");
                    }
                    $price_breakdown[date_format($today, 'Y-m-d')] = $today_price;
                    $total_price += $today_price;

                    date_add($today, date_interval_create_from_date_string('1 day'));
                    $continue = (date_format($today, 'Y-m-d') < $check_out_date);
                }
            } else {
                // no prices at all, quit
                $error = ($message = "No price was found");
            }

            $final_price += $total_price;

            // check supplements
            $sql = "SELECT
                    *,
                    IF ('$check_out_date'<`applies_to` AND '$check_in_date' > `applies_from`, DATEDIFF('$check_out_date', '$check_in_date'),
                    IF ('$check_out_date'<`applies_to` AND '$check_in_date' < `applies_from`, DATEDIFF('$check_out_date', `applies_from`),
                    IF ('$check_out_date'>`applies_to` AND '$check_in_date' < `applies_from`,  DATEDIFF(`applies_to`, `applies_from`), DATEDIFF(`applies_to`, '$check_in_date') ) ) ) as `nights_within`
                FROM
                        `{$wpdb->prefix}ars_prices_supplements`"
                    . " WHERE (`post_id` = " . (int) $post_id . " OR `post_id` = 0)"
                    . " AND (CURRENT_TIMESTAMP < `sales_to` OR `sales_to` = '0000-00-00') "
                    . " AND (CURRENT_TIMESTAMP > `sales_from` OR `sales_from` = '0000-00-00') "
                    . " AND ( '$check_in_date' < `applies_to` OR `applies_to` = '0000-00-00' ) "
                    . " AND ( '$check_out_date' > `applies_from` OR `applies_from` = '0000-00-00' ) "
                    . " AND ( ( (`minimum_stay` = 0 OR `minimum_stay` <= DATEDIFF('$check_out_date', '$check_in_date')) "
                    . " AND (`maximum_stay` = 0 OR `maximum_stay` >= DATEDIFF('$check_out_date', '$check_in_date')) ) OR `obligatory_minimum_stay` > 0  ) "
                    . " AND `valid` = 1"
                    . " ORDER BY `obligatory_minimum_stay` DESC";

            $supplements = $wpdb->get_results($sql);

            $price_supplements = array();

            if (!empty($supplements) AND ! $error) {
                for ($i = 0; $i < count($supplements); $i++) {
                    $supplement = $supplements[$i];
                    if (!empty(trim($supplements[$i]->days))) {
                        $supplement->days = explode(',', $supplements[$i]->days);
                    }
                    $supplement->days = null;

                    $price_supplements[$i] = array(
                        "title" => $supplement->title,
                        "total" => 0,
                    );
                    // is it forced obligatory minimum ?
                    // check minimum number of nights is within obligatory dates
                    if ((int) $supplement->obligatory_minimum_stay > 0 AND (int) $supplement->nights_within < (int) $supplement->obligatory_minimum_stay) {
                        // didn't pass
                        // return no price
                        $error = ($message = vsprintf("An obligatory supplement is imposing a minimum stay of %s nights between the %s and the %s ", array($supplement->obligatory_minimum_stay, date(TravelHelper::getDateFormat(), strtotime($supplement->applies_from)), date(TravelHelper::getDateFormat(), strtotime($supplement->applies_to)))));
                    } else { // applies check supplement type
                        if ($supplement->type == 'PB') { // FIXED supplement per booking
                            $price_supplements[$i]["total"] = $supplement->rate;
                        } elseif ($supplement->type == 'PP') { // FIXED supplement per pax
                            $price_supplements[$i]["total"] = $supplement->rate * $pax;
                        } else {
                            // apply supplements for all dates within
                            // only on specific days?

                            if (!empty($supplement->days)) {
                                $factor = 0;
                                foreach ($price_breakdown as $today => $price) { // everyday
                                    $today_wday = date('N', strtotime($today));
                                    if ($today >= $supplement->applies_from AND $today <= $supplement->applies_to AND in_array($today_wday, $supplement->days)) {
                                        $factor++;
                                    }
                                }
                                if ($supplement->type == 'PN') {
                                    $price_supplements[$i]["total"] = $supplement->rate * $factor;
                                } elseif ($supplement->type == 'PPN') {
                                    $price_supplements[$i]["total"] = $supplement->rate * $factor * $pax;
                                } else {
                                    foreach ($price_breakdown as $today => $price) { // everyday
                                        $today_wday = date('N', strtotime($today));
                                        if ($today >= $supplement->applies_from AND $today <= $supplement->applies_to AND in_array($today_wday, $supplement->days)) {
                                            $price_supplements[$i][$today] = (float) $price * $supplement->rate / 100;
                                            $price_supplements[$i]["total"] += $price_supplements[$i][$today];
                                        }
                                    }
                                }
                            } else {
                                if ($supplement->type == 'PN') {
                                    $price_supplements[$i]["total"] = $supplement->rate * (int) $supplement->nights_within;
                                } elseif ($supplement->type == 'PPN') {
                                    $price_supplements[$i]["total"] = $supplement->rate * (int) $supplement->nights_within * $pax;
                                } else {
                                    // applies percent of the price of each nights
                                    foreach ($price_breakdown as $today => $price) { // everyday
                                        if ($today >= $supplement->applies_from AND $today <= $supplement->applies_to) {
                                            $price_supplements[$i][$today] = (float) $price * $supplement->rate / 100;
                                            $price_supplements[$i]["total"] += $price_supplements[$i][$today];
                                        }
                                    }
                                }
                            }
                        }
                        $final_price += $price_supplements[$i]["total"];
                        $supplement_price += $price_supplements[$i]["total"];
                    }
                }
            }
        }
        $detailed_price = array(
            "status" => $error ? "error" : "OK",
            "message" => $message,
            "final_price" => $final_price,
            "supplement_price" => $supplement_price,
            "total_price" => $total_price,
            "price_breakdown" => $price_breakdown,
            "supplements" => $price_supplements,
            "check_in" => $check_in_date,
            "check_out" => $check_out_date,
            "nights" => $nights,
            "pax" => $pax,
        );

        if ($detailed) {
            return $detailed_price;
        } elseif (!$error) {
            return $final_price;
        }
        return false;
    }

}


if (!function_exists('ars_get_rental_price_by_night')) {

    function ars_get_rental_price_by_night($post_id, $nights, $date = null, $force = false) {
        $capacity = (int) get_post_meta($post_id, 'rental_max_adult', true);
        if (!$date) {
            $date = date("Y-m-d");
        }
        global $wpdb;
        $sql = "SELECT
                    (`base_price`/`base_nights`*" . (int) $nights . ") as `price`
                FROM
                        `{$wpdb->prefix}ars_prices`"
                . " WHERE `post_id` = " . (int) $post_id . ""
                . " AND ( '{$date}' < `valid_to` OR `valid_to` = '0000-00-00' ) "
                . " AND ( '{$date}' > `valid_from`) "
                 . ($force?
                        ""
                        :
                        " AND `minimum_stay` <= " . (int) $nights . " AND (`maximum_stay` >= " . (int) $nights . " OR `maximum_stay` = 0)")
                . " AND (`base_pax` = 0 OR `base_pax` = $capacity)"
                . " AND `valid` = 1"
                . " ORDER BY `price` ASC LIMIT 1 ";

        $results = $wpdb->get_results($sql);
        return $results[0]->price;
    }

}

if (!function_exists('ars_get_rental_price_from')) {

    function ars_get_rental_price_from($post_id, $check_in = '', $check_out = '', $pax = 0) {
        // check capacity
        $capacity = (int) get_post_meta($post_id, 'rental_max_adult', true);

        if (empty($pax)) {
            $pax = $capacity;
        }
        if (empty($check_in)) {
            $check_in = time();
        }
        if (empty($check_out)) {
            $check_out = time();
        }
        $check_in_date = date('Y-m-d', $check_in);
        $check_out_date = date('Y-m-d', $check_out);

        // 2017-04-03 cheaper price per night by property minimum stay

        $booking_min_day = intval(get_post_meta($post_id, 'rentals_booking_min_day', true));

        global $wpdb;
        $sql = "SELECT
                    `base_price`/`base_nights` as `nightly_price`
                FROM
                        `{$wpdb->prefix}ars_prices`"
                . " WHERE `post_id` = " . (int) $post_id . ""
                . " AND ( '$check_in_date' < `valid_to` OR `valid_to` = '0000-00-00' ) "
                . " AND ( '$check_out_date' > `valid_from` OR `valid_from` = '0000-00-00' ) "
                . " AND `minimum_stay` <= $booking_min_day"
                . " AND (`base_pax` = 0 OR `base_pax` = $capacity)"
                . " AND `valid` = 1"
                . " ORDER BY `nightly_price` ASC LIMIT 1 ";

        $results = $wpdb->get_results($sql);

        return $results[0]->nightly_price;
    }

}


if (!function_exists('ars_get_min_max_price')) {

    function ars_get_min_max_price($post_type = '', $args) {
        $defaults = array(
            'location_id' => 0,
            'check_in' => '',
            'check_out' => '',
            'pax' => 0,
        );

        $data = array_merge($defaults, $args);

        // check capacity
        if (isset($data['pax'])) {
            $pax = (int) $data['pax'];
        }
        if (!isset($data['check_in']) || empty($data['check_in'])) {
            $check_in = date('m/d/Y', strtotime("now"));
        } else {
            $check_in = TravelHelper::convertDateFormat(STInput::request('start'));
        }

        if (!isset($data['check_out']) || empty($data['check_out'])) {
            $check_out = date('m/d/Y', strtotime("+1 day"));
        } else {
            $check_out = TravelHelper::convertDateFormat(STInput::request('end'));
        }

        if (empty($check_in)) {
            $check_in = time();
        }
        if (empty($check_out)) {
            $check_out = time();
        }
        $check_in_date = date('Y-m-d', strtotime($check_in));
        $check_out_date = date('Y-m-d', strtotime($check_out));

        global $wpdb;

        if (!empty($data['location_id'])) {
            $from = ", `{$wpdb->prefix}st_location_relationships` as `lr`";
            $where = " AND `posts`.`ID` = `lr`.`post_id` AND `lr`.`location_from` = " . (int) $data['location_id'];
        } else {
            $from = "";
            $where = '';
        }

        if (!empty($post_type)) {
            $from .= ", `{$wpdb->prefix}posts` as `posts`";
            $where .= " AND `posts`.`post_type` = '$post_type' AND `post_status` = 'publish' AND `posts`.`ID` = `prices`.`post_id` ";
        }

        $sql = "SELECT
                    (`base_price`/`base_nights`*DATEDIFF('$check_out_date', '$check_in_date')) as `applicable_nightly_price`
                FROM
                        `{$wpdb->prefix}ars_prices` as `prices`"
                . $from
                . ' WHERE 1 '
                . $where
                . " AND ( '$check_in_date' < `valid_to` OR `valid_to` = '0000-00-00' ) "
                . " AND ( '$check_out_date' > `valid_from` OR `valid_from` = '0000-00-00' ) "
                . " AND ( `base_pax` = 0 OR `base_pax` = $pax ) "
                . " AND (`minimum_stay` = 0 OR `minimum_stay` <= DATEDIFF('$check_out_date', '$check_in_date') ) "
                . " AND (`maximum_stay` = 0 OR `maximum_stay` >= DATEDIFF('$check_out_date', '$check_in_date'))"
                . " AND `valid` = 1"
                . " ORDER BY `applicable_nightly_price` ";

        $min_results = $wpdb->get_results($sql . " ASC LIMIT 1 ");
        $max_results = $wpdb->get_results($sql . " DESC LIMIT 1 ");

        return array('price_min' => floor($min_results[0]->applicable_nightly_price), 'price_max' => ceil($max_results[0]->applicable_nightly_price));
    }

}

if (!function_exists('ars_price_supplements_db_update')) {

    function ars_price_supplements_db_update($post_id, $args) {
        global $wpdb;
        $table = $wpdb->prefix . 'ars_prices_supplements';

        // clean up prices for post_id
        $wpdb->delete($table, array('post_id' => (int) $post_id));

        // insert new prices
        $data = array();
        foreach ($args as $price) {
            $data = array(
                "post_id" => $post_id,
            );
            foreach ($price as $key => $value) {
                if ($key == "valid") {
                    if ($value == "on") {
                        $value = 1;
                    } else {
                        $value = 0;
                    }
                }
                if ($key == "days" OR is_array($value)) {
                    if (in_array('0', $value) OR count($value) >= 7) {
                        $value = "";
                    } else {
                        $value = implode(',', $value);
                    }
                }
                $data[$key] = $value;
            }
            $insert = $wpdb->insert($table, $data);
            if (is_wp_error($insert)) {
                break;
            }
        }
        return true;
    }

}

if (!function_exists('ars_price_options_db_update')) {

    function ars_price_options_db_update($post_id, $args) {
        global $wpdb;
        $table = $wpdb->prefix . 'ars_prices_options';

        // clean up prices for post_id
        $wpdb->delete($table, array('post_id' => (int) $post_id));

        // insert new prices
        $data = array();
        foreach ($args as $option) {
            $data = array(
                "post_id" => $post_id,
            );
            foreach ($option as $key => $value) {
                if ($key == "valid") {
                    if ($value == "on") {
                        $value = 1;
                    } else {
                        $value = 0;
                    }
                }
                $data[$key] = $value;
            }
            $insert = $wpdb->insert($table, $data);
            if (is_wp_error($insert)) {
                break;
            }
        }
        return true;
    }

}

#### DB ####

if (!function_exists('ars_register_metabox')) {

    function ars_register_metabox($custom_metabox) {
        /**
         * Register our meta boxes using the
         * ot_register_meta_box() function.
         */
        if (function_exists('ot_register_meta_box')) {
            if (!empty($custom_metabox)) {
                foreach ($custom_metabox as $value) {
                    ot_register_meta_box($value);
                }
            }
        }
    }

}

/**
 * Load all vc-elements from folder inc/vc-elements/
 * Traveler Child Theme for Antigua Rentals & Services
 *
 * */
if (!function_exists('ars_loadVcElements')) {

    function ars_loadVcElements() {
        $vcels = glob(dirname(__FILE__) . '/inc/vc-elements/*');
        if (!is_array($vcels) or empty($vcels)) {
            return false;
        }

        $dirs = array_filter($vcels, 'is_dir');

        if (!empty($dirs)) {
            foreach ($dirs as $key => $value) {
                $dirname = basename($value);
                $file = "inc/" . 'vc-elements/' . $dirname . '/' . $dirname;
                get_template_part($file);
            }
        }
        return true;
    }

}
if (class_exists('Vc_Manager')) {
    add_action('init', 'ars_loadVcElements', 30);
}

function ars_generaloptions_update($option, $old, $new) {
    global $wpdb;
    if (!is_array($new)) {
        return true;
    }
    if (isset($new['general_rental_supplements'])) {
        $table = $wpdb->prefix . 'ars_prices_supplements';

        // clean up prices for post_id
        $wpdb->delete($table, array('post_id' => 0));

        // insert new prices
        $data = array();
        foreach ($new['general_rental_supplements'] as $supplement) {
            $data = array(
                "post_id" => 0,
            );
            foreach ($supplement as $key => $value) {
                if ($key == "valid") {
                    if ($value == "on") {
                        $value = 1;
                    } else {
                        $value = 0;
                    }
                }
                if ($key == "days" OR is_array($value)) {
                    if (in_array('0', $value) OR count($value) >= 7) {
                        $value = "";
                    } else {
                        $value = implode(',', $value);
                    }
                }
                $data[$key] = $value;
            }
            $insert = $wpdb->insert($table, $data);
        }
    }
    if (isset($new['general_rental_options'])) {
        $table = $wpdb->prefix . 'ars_prices_options';

        // clean up prices for post_id
        $wpdb->delete($table, array('post_id' => 0));

        // insert new prices
        $data = array();
        foreach ($new['general_rental_options'] as $option) {
            $data = array(
                "post_id" => 0,
            );
            foreach ($option as $key => $value) {
                if ($key == "valid") {
                    if ($value == "on") {
                        $value = 1;
                    } else {
                        $value = 0;
                    }
                }
                $data[$key] = $value;
            }
            $insert = $wpdb->insert($table, $data);
        }
    }
}

function ars_saveoption_hook() {
    add_action('updated_option', 'ars_generaloptions_update', 10, 3);
}

add_action('init', 'ars_saveoption_hook');

function ars_update_availability($post_id, $from, $to, $available = 'unavailable', $price = 0) {
    // source iCal, $TO excluded as is CHECK OUT date
    global $wpdb;
    $post_type = get_post_type($post_id);
    // clean up
    $sql = "DELETE FROM `" . $wpdb->prefix . 'st_availability' . "`"
            . "WHERE `post_id` = $post_id "
            . "AND `date` >= '$from' "
            . "AND `date` < '$to' "
            . "";
    $wpdb->get_results($sql);

    $date = new DateTime($from);
    for ($date; $date->format("Y-m-d") < $to; $date->add(new DateInterval('P1D'))) {
        $data = array(
            'post_id' => $post_id,
            'post_type' => $post_type,
            'date' => $date->format("Y-m-d"),
            'price' => $price,
            'status' => $available,
        );
        $table = $wpdb->prefix . 'st_availability';
        $wpdb->insert($table, $data);
    }
}

function ars_breadcrumbs_single($sep) {

    $post_type = get_post_type(the_post());

    if ($post_type == 'st_cars') {
        $search_result_page = st()->get_option('cars_search_result_page');
    }
    if ($post_type == 'st_tours') {
        // check type
        $tour_type = get_post_meta(get_the_ID(), 'type_tour');
        if ($tour_type == 'airport_transfer' OR $tour_type == 'transportation') {
            $search_result_page = st()->get_option('transport_search_result_page');
        } else {
            $search_result_page = st()->get_option('tours_search_result_page');
        }
    }
    if ($post_type == 'st_rental') {
        $search_result_page = st()->get_option('rental_search_result_page');
    }

    $link = get_the_permalink($search_result_page);
    if (!empty($_SESSION["st_search"])) {
        $link = add_query_arg($_SESSION["st_search"], $link);
    }
    var_dump($link);
    echo '<li><a href="' . $link . '">' . get_the_title($search_result_page) . '</a></li>';
}

// add_action('st_single_breadcrumb', 'ars_breadcrumbs_single', 12);
