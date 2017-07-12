<?php
/**
 * @package WordPress
 * @subpackage Traveler Childtheme for Antigua Rentals & Services
 *
 * Rental details
 *
 * Created by Antigua Rentals & Services
 *
 */
if (isset($attr)) {
    // displays capacity, numbers of rooms and bathrooms
    $default = array(
        'item_col' => '',
        'title' => '',
        'font_size' => '4',
    );
    extract(wp_parse_args($attr, $default));

    $post_id = get_the_ID();

    $npax = (int) get_post_meta($post_id, 'rental_max_adult', true);
    $nbedrooms = (int) get_post_meta($post_id, 'ars_rental_num_bedrooms', true);
    $nbathrooms = (int) get_post_meta($post_id, 'ars_rental_num_bathrooms', true);

    $taxonomy = "rental_type";



    if (!empty(($npax + $nbedrooms + $nbathrooms))) {

        if (!empty($title)) {
            ?>
            <h<?php echo esc_attr($font_size) ?>><?php echo esc_html($title) ?></h<?php echo esc_attr($font_size) ?>>
            <?php
        }
        ?>
        <ul class="booking-item-features booking-item-features-sign mt15 clearfix">
            <?php
            if ($taxonomy and taxonomy_exists($taxonomy)) {
                $terms = get_the_terms($post_id, $taxonomy);
                if (!empty($terms)) {
                    ?><li  rel="tooltip" data-placement="top" title="" data-original-title="<?php echo esc_attr(__("Rental type:", ST_TEXTDOMAIN)); ?><?php
                        $i = 0;
                        foreach ($terms as $key2 => $value2) {
                            if ($i > 0) { echo ", ";}
                            ?><?php echo esc_attr($value2->name) ?><?php
                            $i++;
                        }
                        ?>">
                        <i class="fa fa-home"></i></li><?php
                    }
                }
                ?>
            <?php if ($npax > 0): ?>
                    <li rel="tooltip" data-placement="top" title="" data-original-title="<?php echo esc_attr(__("capacity", ST_TEXTDOMAIN) . ": " . $npax); ?>">
                                        <i class="fa fa-male"></i><span class="booking-item-feature-sign">x <?php echo $npax; ?></span>
                                    </li>
            <?php endif; ?>
            <?php if ($nbathrooms > 0): ?>
                <li rel="tooltip" data-placement="top" title="" data-original-title="<?php echo sprintf(ngettext("%d bathroom", "%d bathrooms", $nbathrooms), $nbathrooms); ?>">
                    <i class="im im-shower"></i>
                    <span class="booking-item-feature-sign">x <?php echo ($nbathrooms); ?></span>
                </li>
            <?php endif; ?>
            <?php if ($nbedrooms > 0): ?>
                <li  rel="tooltip" data-placement="top" title="" data-original-title="<?php echo sprintf(ngettext("%d bedroom", "%d bedrooms", $nbedrooms), $nbedrooms); ?>">
                    <i class="im im-bed"></i>
                    <span class="booking-item-feature-sign">x <?php echo $nbedrooms; ?></span>
                </li>
            <?php endif; ?>
        </ul>
        <?php
    }
}