<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental form book
 *
 * Created by ShineTheme
 *
 */
if (!isset($field_size)) {
    $field_size = '';
}

$item_id = get_the_ID();

$adult_max = intval(get_post_meta($item_id, 'rental_max_adult', true));
$child_max = intval(get_post_meta($item_id, 'rental_max_children', true));

echo STTemplate::message();

//check is booking with modal
$st_is_booking_modal = apply_filters('st_is_booking_modal', false);
$booking_period = get_post_meta($item_id, 'rentals_booking_period', true);

$pax = (int) STInput::request('adult_number');
$check_in = STInput::request('start');
$check_out = STInput::request('end');

$nights = STDate::date_diff(strtotime(TravelHelper::convertDateFormat($check_in)), strtotime(TravelHelper::convertDateFormat($check_out)));

$ars_price = false;
if (!empty($check_in)) {
    $ars_price = ars_get_rental_price($item_id, strtotime(TravelHelper::convertDateFormat($check_in)), strtotime(TravelHelper::convertDateFormat($check_out)), $pax, true);
    $ars_availability = ars_get_rental_availability($item_id, strtotime(TravelHelper::convertDateFormat($check_in)), strtotime(TravelHelper::convertDateFormat($check_out)));
    
    if ($ars_price AND $ars_price["status"] == "OK" AND $ars_availability) {
        ?><div class="booking-item-dates-change" id="booking-rental-price-quote" data-booking-period="<?php echo $booking_period; ?>" data-post-id="<?php echo $item_id; ?>">
            <form method="post" action="#booking-rental-price-quote" id="form-booking-inpage">
                <?php
                $orgin_price = $ars_price["total_price"];
                $new_price = $ars_price["final_price"];
                $is_sale = ($ars_price["supplement_price"] < 0);
                if (!get_option('permalink_structure')) {
                    echo '<input type="hidden" name="st_rental"  value="' . st_get_the_slug() . '">';
                }
                ?>
                <input type="hidden" name="action" value="rental_add_cart">
                <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                <input type="hidden" name="adult_number" value="<?php echo $pax; ?>">
                <input type="hidden" name="start" value="<?php echo $check_in; ?>">
                <input type="hidden" name="end" value="<?php echo $check_out; ?>">
                <input type="hidden" name="child_number" value="0">
                <div class="row">
                    <div class="col-md-12">
                        <h5><?php echo __('Your reservation for', ST_TEXTDOMAIN); ?></h5>
                    </div>
                    <div class="col-md-8">
                        <h3><?php echo get_the_title($item_id); ?></h3>
                        <span class="booking-dates"><?php echo vsprintf(__('from %s to %s (%d nights)', ST_TEXTDOMAIN), array($check_in, $check_out, $nights)); ?></span>
                        <span class="booking-pax"><?php echo sprintf(__('for %d guests', ST_TEXTDOMAIN), $pax); ?></span>
                    </div>
                    <div class="col-md-4 text-right">
                        <p class="booking-item-header-price">
                            <?php
                            if ($is_sale) {
                                echo "<span class='booking-item-old-price'>" . TravelHelper::format_money($orgin_price) . "</span>";
                            }
                            ?><span class="text-lg"><?php echo TravelHelper::format_money($new_price) ?></span></p><?php
                            if (!$st_is_booking_modal):
                                echo STRental::rental_external_booking_submit();
                            else:
                                ?>
                            <p><a href="#rental_booking_<?php echo $item_id ?>" onclick="return false" class="btn btn-primary btn-st-add-cart" data-target=#rental_booking_<?php echo $item_id ?>  data-effect="mfp-zoom-out" ><?php st_the_language('rental_book_now') ?> <i class="fa fa-spinner fa-spin"></i></a></p>
                        <?php
                        endif;
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                        $extra_price = get_post_meta($item_id, 'extra_price', true);
                        ?>
                        <?php if (is_array($extra_price) && count($extra_price)): ?>
                            <?php
                            $extra = STInput::request("extra_price");
                            if (!empty($extra['value'])) {
                                $extra_value = $extra['value'];
                            }
                            ?>
                            <label ><?php echo __('Extra', ST_TEXTDOMAIN); ?></label>
                            <table class="table">
                                <?php foreach ($extra_price as $key => $val): ?>
                                    <tr>
                                        <td width="80%">
                                            <label for="<?php echo $val['extra_name']; ?>" class="ml20"><?php echo $val['title'] . ' (' . TravelHelper::format_money($val['extra_price']) . ')'; ?></label>
                                            <input type="hidden" name="extra_price[price][<?php echo $val['extra_name']; ?>]" value="<?php echo $val['extra_price']; ?>">
                                            <input type="hidden" name="extra_price[title][<?php echo $val['extra_name']; ?>]" value="<?php echo $val['title']; ?>">
                                        </td>
                                        <td width="20%">
                                            <select style="width: 100px" class="form-control app" name="extra_price[value][<?php echo $val['extra_name']; ?>]" id="">
                                                <?php
                                                $max_item = intval($val['extra_max_number']);
                                                if ($max_item <= 0)
                                                    $max_item = 1;
                                                for ($i = 0; $i <= $max_item; $i++):
                                                    $check = "";
                                                    if (!empty($extra_value[$val['extra_name']]) and $i == $extra_value[$val['extra_name']]) {
                                                        $check = "selected";
                                                    }
                                                    ?>
                                                    <option  <?php echo esc_html($check) ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
        <?php
    } elseif (!$ars_availability) {
        echo "<div class='alert alert-danger' id='booking-rental-price-quote'>
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"" . __('Close', ST_TEXTDOMAIN) . "\"><span aria-hidden=\"true\">&times;</span></button>
                This property is not available at the selected dates.
        </div>";
    } elseif ($ars_price) {
        echo "<div class='alert alert-danger' id='booking-rental-price-quote'>
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"" . __('Close', ST_TEXTDOMAIN) . "\"><span aria-hidden=\"true\">&times;</span></button>
                {$ars_price["message"]}
        </div>";
    }
}
if ($st_is_booking_modal) {
    ?>
    <div class="mfp-with-anim mfp-dialog mfp-search-dialog mfp-hide" id="rental_booking_<?php echo $item_id ?>">
        <?php echo st()->load_template('rental/modal_booking'); ?>
    </div>
    <?php
}