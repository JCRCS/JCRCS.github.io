<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Rental price
 *
 * Created by ShineTheme
 *
 */
$default = array(
    'align' => 'right'
);
if (isset($attr)) {
    extract(wp_parse_args($attr, $default));
} else {
    extract($default);
}

$check_in = '';
$check_out = '';
$pax = 0;
$post_id = get_the_ID();
if (isset($_REQUEST['adult_number'])) {
    $pax = (int) $_REQUEST['adult_number'];
}
if (!isset($_REQUEST['start']) || empty($_REQUEST['start'])) {
    $check_in = date('m/d/Y', strtotime("now"));
} else {
    $check_in = TravelHelper::convertDateFormat(STInput::request('start'));
}

if (!isset($_REQUEST['end']) || empty($_REQUEST['end'])) {
    $check_out = date('m/d/Y', strtotime("+1 day"));
} else {
    $check_out = TravelHelper::convertDateFormat(STInput::request('end'));
}

$ars_price = ars_get_rental_price($post_id, strtotime($check_in), strtotime($check_out), $pax, true);
if ($ars_price["status"] == "OK") {
    $orgin_price = $ars_price["total_price"];
    $new_price = $ars_price["final_price"];
    $is_sale = ($ars_price["supplement_price"] < 0);
} else {
    $price_from = ars_get_rental_price_from($post_id);
}
?>

<p class="booking-item-header-price">

    <?php
    if ($is_sale) {
        echo "<span class='booking-item-old-price'>" . TravelHelper::format_money($orgin_price) . "</span>";
    }
    if ($ars_price["status"] == "OK") {
        ?><span class="text-lg"><?php echo TravelHelper::format_money($new_price) ?></span></p><?php
    } else {
        ?> <span class="text-lg"><?php echo TravelHelper::format_money($price_from) ?></span></p><?php
    }
