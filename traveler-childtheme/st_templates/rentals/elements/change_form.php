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
wp_enqueue_script('bootstrap-datepicker.js');
wp_enqueue_script('bootstrap-datepicker-lang.js');

if (!isset($field_size)) {
    $field_size = '';
}

$item_id = get_the_ID();

$adult_max = intval(get_post_meta($item_id, 'rental_max_adult', true));
$child_max = intval(get_post_meta($item_id, 'rental_max_children', true));

echo STTemplate::message();
global $post;

//check is booking with modal
$st_is_booking_modal = apply_filters('st_is_booking_modal', false);
$booking_period = get_post_meta($item_id, 'rentals_booking_period', true);
?>

<div class="booking-item-dates-change" data-booking-period="<?php echo $booking_period; ?>" data-post-id="<?php echo $item_id; ?>" id="">
    <form method="get" action="<?php echo get_the_permalink(); ?>#booking-rental-price-quote" id="form-booking-inpage">
        <?php
        if (!get_option('permalink_structure')) {
            echo '<input type="hidden" name="st_rental"  value="' . st_get_the_slug() . '">';
        }
        ?>
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
        <div class="message_box mb10"></div>
        <div class="row">
            <div class="input-daterange" data-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>">
                <div class="col-md-3">
                    <div class="form-group form-group-icon-left">
                        <label for="field-rental-start"><?php st_the_language('rental_check_in') ?></label>
                        <i class="fa fa-calendar input-icon"></i>
                        <input id="field-rental-start" required="required" placeholder="<?php echo TravelHelper::getDateFormatJs(__("Select date", ST_TEXTDOMAIN)); ?>" value="<?php echo STInput::post('start', STInput::get('start')); ?>" class="form-control required checkin_rental" name="start" type="text" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group form-group-icon-left">
                        <label for="field-rental-end"><?php st_the_language('rental_check_out') ?></label>
                        <i class="fa fa-calendar input-icon"></i>
                        <input id="field-rental-end" required="required" placeholder="<?php echo TravelHelper::getDateFormatJs(__("Select date", ST_TEXTDOMAIN)); ?>" value="<?php echo STInput::post('end', STInput::get('end')); ?>" class="form-control required checkout_rental" name="end" type="text" />
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <?php
                $old = STInput::post('adult_number', STInput::get('adult_number', 1));

                if (!$old) {
                    $old = 1;
                }
                ?>
                <div class="form-group form-group-<?php echo esc_attr($field_size) ?> form-group-select-plus">
                    <label for="field-rental-adult"><?php _e("People", ST_TEXTDOMAIN); //st_the_language('rental_adult');      ?></label>
                    <input pattern="[0-9]*"  min="1" max="<?php echo $adult_max; ?>" placeholder="Guests" value="<?php echo STInput::post('adult_number', STInput::get('adult_number')); ?>" id="field-rental-people" class="form-control " name="adult_number" type="number">
                    
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group form-group-<?php echo esc_attr($field_size); ?> form-group-select-plus">
                    <label for="field-submit-btn">&nbsp;</label>
                    <input class="btn btn-primary" value="<?php echo __('Get Price', ST_TEXTDOMAIN); ?>" type="submit">
                </div>
            </div>
            <!--
            <div class="col-sm-6">
            <?php
            $old = STInput::post('child_number', STInput::get('child_number', 0));
            ;
            ?>
                <div class="form-group form-group-<?php echo esc_attr($field_size) ?> form-group-select-plus">
                    <label for="field-rental-children"><?php st_the_language('rental_children') ?></label>
                    <div class="btn-group btn-group-select-num <?php if ($old >= 3 || $child_max < 3) echo 'hidden'; ?>" data-toggle="buttons">
            <?php
            if ($child_max <= 0)
                $child_max = 1;

            for ($i = 1; $i <= 4; $i ++):
                $name = '' . $i;
                if ($i == 4) {
                    $name = '' . ($i - 1) . '+';
                }
                ?>
                                                <label class="btn btn-primary <?php echo ($old == $i) ? 'active' : false; ?>">
                                                    <input type="radio" value="<?php echo $i; ?>" name="options" /><?php echo $name; ?>
                                                </label>
            <?php endfor; ?>
                    </div>
                    <select id="field-rental-children" class="form-control required <?php if ($old < 3 && $child_max >= 3) echo 'hidden'; ?>" name="child_number">
            <?php
            for ($i = 0; $i <= $child_max; $i++) {
                echo "<option " . selected($i, $old, false) . " value='{$i}'>{$i}</option>";
            }
            ?>
                    </select>
                </div>
            </div>
            -->
        </div>

    </form>
</div>
