<?php
if (!class_exists('STRental')) {
    return false;
}

if (!isset($field_size)) {
    $field_size = 'md';
}

$id_page = st()->get_option('rental_search_result_page');

if (!empty($id_page)) {
    $link_action = get_the_permalink($id_page);
} else {
    $link_action = home_url('/');
}
$st_direction = !empty($st_direction) ? $st_direction : "horizontal";

$default = array(
    'st_list_form' => '',
    'st_style_search' => 'style_1',
    'st_direction' => 'horizontal',
    'st_box_shadow' => 'no',
    'st_show_labels' => 'yes',
    'st_search_tabs' => 'yes',
    'st_title_search' => '',
    'field_size' => ''
);

if (isset($data)) {
    extract($data = wp_parse_args($data, $default));
} else {
    extract($data = $default);
}
?>
<div class="search-tabs search-tabs-bg ars-rental-search <?php
if ($st_box_shadow == 'no')
    echo 'no-boder-search';
else
    echo 'booking-item-dates-change';
?>">
    <div class="tabbable">
        <div class="tab-content">
            <?php if ($st_show_labels == 'yes'): ?><h2 class='mb20'><?php echo esc_html($st_title_search) ?></h2><?php endif; ?>
            <form role="search" method="get" class="search main-search" action="<?php echo esc_url($link_action) ?>">
                <?php if (empty($id_page)): ?>
                    <input type="hidden" name="post_type" value="st_rental">
                    <input type="hidden" name="s" value="">
                <?php endif ?>
                <?php echo TravelHelper::get_input_multilingual_wpml() ?>
                <div class="row">
                    <?php
                    $fields = array(
                        array(
                            "title" => "",
                            "name" => "location",
                            "layout_col" => 12,
                            "layout_col2" => 12,
                            "placeholder" => "Choose destination",
                            "is_required" => "on",
                        ),
                        array(
                            "title" => "",
                            "name" => "checkin",
                            "layout_col" => 4,
                            "layout_col2" => 4,
                            "placeholder" => "Check-in",
                            "is_required" => "off",
                        ),
                        array(
                            "title" => "",
                            "name" => "checkout",
                            "layout_col" => 4,
                            "layout_col2" => 4,
                            "placeholder" => "Check-out",
                            "is_required" => "off",
                        ),
                        array(
                            "title" => "",
                            "name" => "people",
                            "layout_col" => 4,
                            "layout_col2" => 4,
                            "placeholder" => "Guests",
                            "is_required" => "off",
                        ),
                        array(
                            "title" => "Number of Rooms",
                            "name" => "room_num",
                            "layout_col" => 4,
                            "layout_col2" => 4,
                            "placeholder" => "Rooms",
                            "is_required" => "off",
                        ),
                    );
                    foreach ($fields as $value) {
                        if (!isset($value['name'])) {
                            continue;
                        }
                        $name = $value['name'];
                        if ($name == 'google_map_location') {
                            $name = 'location';
                        }
                        $size = '4';
                        if (!empty($st_style_search) and $st_style_search == "style_1") {
                            $size = $value['layout_col'];
                        } else {
                            if ($value['layout_col2']) {
                                $size = $value['layout_col2'];
                            }
                        }

                        if ($st_direction == 'vertical') {
                            $size = '12';
                        }
                        $size_class = " col-md-" . $size . " col-lg-" . $size . " col-sm-12 col-xs-12 ";
                        ?>
                        <div class="<?php echo esc_attr($size_class); ?>">
                            <?php echo st()->load_template('rental/elements/search/field_' . $name, false, array('data' => $value, 'field_size' => $field_size, 'location_name' => 'location_name', 'st_direction' => $st_direction, 'args' => $data)) ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class=" col-md-3 col-lg-3 col-sm-3 col-xs-3">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-primary btn-<?php echo esc_attr($field_size) ?>" type="submit"><?php st_the_language('search_for_rental') ?></button></div>
                </div>


                <?php
                $option = st()->get_option('allow_rental_advance_search');
                $fields = st()->get_option('rental_advance_search_fields');
                if ($option == 'on' and ! empty($fields) AND ! is_home()) {
                    ?>
                    <div class="search_advance">
                        <div class="expand_search_box form-group form-group-<?php echo esc_attr($field_size); ?>">
                            <span class="expand_search_box-more"> <i class="btn btn-primary fa fa-plus mr10"></i><?php echo __("Advanced Search", ST_TEXTDOMAIN); ?></span>
                            <span class="expand_search_box-less"> <i class="btn btn-primary fa fa-minus mr10"></i><?php echo __("Advanced Search", ST_TEXTDOMAIN); ?></span>
                        </div>
                        <div class="view_more_content_box">
                            <div class="row">
                                <?php
                                if (!empty($fields)) {
                                    foreach ($fields as $key => $value) {
                                        if (!isset($value['name']) OR $value['name'] == 'price_slider' OR $value['name'] == 'room_num'){
                                            continue;
                                        }
                                        $name = $value['name'];
                                        if ($name == 'google_map_location') {
                                            $name = 'location';
                                        }
                                        $size = '4';
                                        if (!empty($st_style_search) and $st_style_search == "style_1") {
                                            $size = $value['layout_col'];
                                        } else {
                                            if ($value['layout_col2']) {
                                                $size = $value['layout_col2'];
                                            }
                                        }

                                        if ($st_direction == 'vertical') {
                                            $size = '12';
                                        }
                                        $size_class = " col-md-" . $size . " col-lg-" . $size . " col-sm-12 col-xs-12 ";
                                        ?>
                                        <div class="<?php echo esc_attr($size_class); ?>">
                                            <?php echo st()->load_template('rental/elements/search/field_' . $name, false, array('data' => $value, 'field_size' => $field_size, 'location_name' => 'location_name', 'st_direction' => $st_direction)) ?>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </form>
        </div>
    </div>
</div>