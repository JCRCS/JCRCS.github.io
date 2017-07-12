<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.1.3
 * */
$paged = STInput::get('room_page', 1);
$item_id = get_the_ID();

// Rental Rooms info
$rental_rooms = get_post_meta($item_id, 'rental_bedrooms', true);

$default = array(
    'show_pictures' => 'Y',
    'show_facilities' => 'Y',
);
$settings = array_merge($default, $attr);
extract($settings);

if (!empty($rental_rooms)):
    ?><div class="row">
        <div class="col-xs-12">
            <h4><?php echo __('Bedroom Distribution', ST_TEXTDOMAIN); ?></h4>
        </div>
        <div class="col-xs-12 ars-rental-room-list clearfix" id="">
            <ul class="ars-rental-room-list-rooms">
                <?php
                foreach ($rental_rooms as $room):
                    ?>
                    <li class="ars-rental-room-list-rooms-item">
                        <?php
                        if ($show_pictures == 'Y'):
                            $gallery = explode(',', $room['gallery']);
                            $img_link = wp_get_attachment_image_src($gallery[0], 'full');
                            ?>

                            <div class="ars-rental-room-list-rooms-item-tn-container">
                                <div class="ars-rental-room-list-rooms-item-img-wrap st-popup-gallery booking-item-img-wrap">
                                    <a href="<?php echo (!empty($img_link[0])) ? $img_link[0] : '#' ?>" class="st-gp-item">
                                        <?php
                                        if (!empty($gallery[0])) {
                                            echo wp_get_attachment_image($gallery[0], array(360, 270, 'bfi_thumb' => TRUE));
                                        } else {
                                            echo st_get_default_image();
                                        }
                                        ?>
                                    </a>
                                    <?php
                                    $count = 0;
                                    if (!empty($gallery) and $gallery[0]) {
                                        $count += count($gallery);
                                    }
                                    if ($count) {
                                        echo '<div class="booking-item-img-num"><i class="fa fa-picture-o"></i>';
                                        echo esc_attr($count);
                                        echo '</div>';
                                    }
                                    ?>
                                    <div class="hidden">
                                        <?php
                                        if (!empty($gallery)) {
                                            $i = 0;
                                            foreach ($gallery as $value) {
                                                if ($i > 0) {
                                                    $img_link = wp_get_attachment_image_src($value, 'full');
                                                    if (isset($img_link[0])) {
                                                        echo "<a class='st-gp-item' href='{$img_link[0]}'></a>";
                                                    }
                                                }
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                        endif;
                        ?>
                        <div class="ars-rental-room-list-rooms-item-desc">
                            <h5 class="booking-item-title mt10"><?php echo $room['title'] ?></h5>
                            <ul class="booking-item-features booking-item-features-sign clearfix mt10">
                                <?php if (!empty($room['capacity'])): ?>
                                    <li rel="tooltip" data-placement="top" title="" data-original-title="<?php st_the_language('adults_occupany') ?>">
                                        <i class="fa fa-male"></i><span class="booking-item-feature-sign">x <?php echo esc_html($room['capacity']) ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php
                                if (!empty($room['beds'])):
                                    $beds = __('bebs', ST_TEXTDOMAIN);
                                    if (!empty($room['bedding'])) {
                                        $beds = "";
                                        foreach ($room['bedding'] as $bedtype) {
                                            if (!empty($beds)) {
                                                $beds .= ', ';
                                            }
                                            $term = get_term_by('id', $bedtype, 'room_bedding');
                                            $beds .= $term->name;
                                        }
                                    }
                                    ?>
                                    <li rel="tooltip" data-placement="top" title="" data-original-title="<?php echo $beds; ?>">
                                        <i class="im im-bed"></i><span class="booking-item-feature-sign">x <?php echo esc_html($room['beds']) ?></span>
                                    </li>
                                    <?php
                                endif;
                                // private bathroom?
                                if (!empty($room['en-suite_bathroom'] == 'on')):
                                    ?>
                                    <li rel="tooltip" data-placement="top" class="" title="" data-original-title="<?php echo __('En-suite Bathroom'); ?>">
                                        <i class="im im-shower"></i>
                                    </li>
                                    <?php
                                endif;
                                // other facilities
                                if (!empty($room['facilities']) AND $show_pictures == 'Y'):
                                    foreach ($room['facilities'] as $facilities) {
                                        $term = get_term_by('id', $facilities, 'room_facilities');
                                        $name = $term->name;
                                        ?>
                                        <li rel="tooltip" data-placement="top" class="" title="" data-original-title="<?php echo esc_html($name) ?>">
                                            <?php if (function_exists('get_tax_meta')): ?>
                                                <i class="<?php echo TravelHelper::handle_icon(get_tax_meta($facilities, 'st_icon')) ?>"></i>
                                            <?php else: ?>
                                                <span class="booking-item-feature-title"><?php echo esc_html($name) ?></span>
                                            <?php endif; ?>
                                        </li>
                                        <?php
                                    }
                                endif;
                                ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php



endif;