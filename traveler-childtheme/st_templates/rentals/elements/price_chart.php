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

$default = array(
    "title" => "",
    "font_size" => "3",
    "chart_data" => "1:night,7:week,30:month",
);
$data = array_merge($default, $attr);

extract($data);

$chart_data = explode(",", $chart_data);

if (!empty($title)) {
    ?>
    <h<?php echo esc_attr($font_size) ?>>
        <?php echo esc_html($title); ?>
    </h<?php echo esc_attr($font_size) ?>>
    <?php
}
?>
<div class="rental-price-chart">
    <h6><?php echo __("Average Prices", ST_TEXTDOMAIN); ?></h6>
        <ul class="rental-price-chart-table">
            <?php
            foreach ($chart_data as $col) {
                $rows = explode(":", $col);
                $nights = (int) $rows[0];
                $label = $rows[1];
                // get the price
                $price = ars_get_rental_price_by_night($item_id, $nights);
                if (!empty($price)) {
                    ?><li>
                        <div class="rental-price-chart-table-label"><span><?php echo $label; ?></span></div>
                        <div class="rental-price-chart-table-price"><span><?php echo TravelHelper::format_money($price); ?></span></div>
                    </li><?php
        }
        
    }
            ?>
        </ul>
</div>
