<?php
$col = 12 / $st_cars_of_row;

$info_price = STCars::get_info_price();
$price = $info_price['price'];
$count_sale = $info_price['discount'];
$price_origin = $info_price['price_origin'];

$item_id = get_the_ID();

$tax_html = "";
if (!empty($show_taxonomies)) {
    $taxonomies = explode(',', $show_taxonomies);
    $html = "";
    foreach ($taxonomies as $value) {
        $data_term = get_the_terms($item_id, $value, true);
        if (!empty($data_term)) {
            foreach ($data_term as $k => $v) {
                /*
                $icon = TravelHelper::handle_icon(get_tax_meta($v->term_id, 'st_icon', true));
                if (empty($icon)) {
                    $icon = "fa fa-cogs";
                }
                $html .= '<li title="" data-placement="top" rel="tooltip" data-original-title="' . esc_html($v->name) . '"><i class="' . $icon . '"></i></li>';
                 * 
                 */
                $html .= (!empty($html)?', ':'').esc_html($v->name);
            }
        }
    }
    $tax_html = '<small>'.$html.'</small>';
    // $tax_html = '<ul class="booking-item-features booking-item-features-small clearfix">' . balanceTags($html) . '</ul>';
}
?>

<div class="col-md-<?php echo esc_attr($col); ?> col-sm-6 st_fix_<?php echo esc_attr($st_cars_of_row); ?>_col style_box">
    <?php echo STFeatured::get_featured(); ?>
    <div class="thumb car">
        <header class="thumb-header">
            <?php
            if (!empty($count_sale)) {
                STFeatured::get_sale($count_sale);
            }

            $over_flow = '';
            if (!empty($current_page) and $current_page != "location") {
                $over_flow = 'style="overflow: initial";';
            }
            ?>
            <a href="<?php the_permalink() ?>" class="hover-img"  <?php echo esc_html($over_flow); ?>>
                <?php
                if (has_post_thumbnail() and get_the_post_thumbnail()) {
                    the_post_thumbnail(array(800, 600, 'bfi_thumb' => true));
                } else {
                    echo st_get_default_image();
                }
                ?><h5 class="hover-title hover-hold"><?php the_title() ?></h5>
            </a>
            <?php
            echo st_get_avatar_in_list_service($item_id, 40);
            ?>
        </header>
        <div class="row thumb-caption">
            <div class="col-sm-8">
            <?php
            $category = get_the_terms($item_id, 'st_category_cars');
            $cat_html = '';
            if (!is_wp_error($category) and ! empty($category) and is_array($category)) {
                foreach ($category as $k => $v) {
                    $cat_html .= $v->name . ' ,';
                }
                $cat_html = substr($cat_html, 0, -1);
                echo esc_html($cat_html);
            }
            ?>
            <div><?php echo $tax_html; ?></div>
            </div>
            <div class="col-sm-4 nopadding">
                <small>Average Price</small>
                <div class="price-tag">
                <?php if ($price_origin != $price) { ?>
                    <span class="text-small lh1em  onsale">
                        <?php echo TravelHelper::format_money($price_origin) ?>
                    </span>
                    <i class="fa fa-long-arrow-right"></i>
                <?php } ?>
                <?php
                if (!empty($price)) {
                    echo '<span class="text-darken mb0 text-color">' . TravelHelper::format_money($price) . '<small> /' . STCars::get_price_unit('label') . '</small></span>';
                }
                ?></div>
            </div>
            <div class="col-sm-12 text-center">
                        <a class="btn btn-primary" href="<?php the_permalink() ?>"><?php echo __('Request Booking', ST_TEXTDOMAIN); ?></a>
                    </div>
        </div>
    </div>
</div>