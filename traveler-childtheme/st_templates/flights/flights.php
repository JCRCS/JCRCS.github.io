<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$defaults = array(
    "schedule" => 'Daily',
    "ticket" => 'ow',
);
$attr = array_merge($attr, $defaults);
extract($attr);

$link = get_permalink(st()->get_option('flights_booking_request_page'));
?>

<div class="">
    <div class="thumb flight">
        <header class="thumb-header">
            <div class="hover-img"><?php 
                if ($image){
                    echo wp_get_attachment_image($image, array(800, 600, 'bfi_thumb' => true));
                } else {
                ?><img class="attachment-800x600x1 size-800x600x1 wp-post-image" src="/wp-content/uploads/2017/04/PlaneHack.png" alt="" height="619" width="1000"><?php
                } ?><h5 class="hover-title hover-hold"><?php echo $title; ?></h5>
            </div>
        </header>
        <div class="thumb-caption" style="background-color: #f7f5f2; padding: 4px;">
            <div class="row">
                <div class="col-md-12"><span class="small" style="width: 26px; display: inline-block;">from</span> <i class="fa fa-location-arrow"></i> <?php echo get_the_title($origin); ?></div>
                <div class="col-md-12"><span class="small" style="width: 26px; display: inline-block;">to</span> <i class="fa fa-location-arrow"></i> <?php echo get_the_title($destination); ?></div>

                <div class="col-sm-8">
                    <p class="small">
                        <?php
                        if (!empty($schedule)) {
                            echo '<i class="fa fa-calendar"></i> ' . $schedule . '<br>';
                        }
                        if (!empty($duration)) {
                            echo '<i class="fa fa-clock-o"></i> ' . $duration . '<br>';
                        }
                        if (!empty($ticket)) {
                            if ($ticket == 'OW') {
                                $ticket = 'One-way';
                            } else {
                                $ticket = 'Round-trip';
                            }
                            echo '<i class="fa fa-ticket"></i> ' . $ticket . '<br>';
                        }
                        if (!empty($departure)) {
                            echo '<i class="fa fa-plane"></i> Departure ' . $departure . '<br>';
                        }
                        if (!empty($arrival)) {
                            echo '<i class="fa fa-plane"></i> Arrival ' . $arrival . '<br>';
                        }
                        ?>
                        <i class="fa fa-check-square-o"></i> Passport Required<br>
                    </p>
                </div>
                <div class="col-sm-4">
                    <small><p>price</p></small>
                    <div class="price-tag">
                        <span class="text-darken mb0 text-color"><?php
                        if (!empty($price)) {
                            // <i class="fa fa-money"></i> 
                            echo '' . TravelHelper::format_money($price) . '<br>';
                        }
                        ?></span></div>
                </div>
                <div class="col-md-12">
                    <p style="text-align: center;"><a class="btn btn-primary" href="<?php echo add_query_arg(array('flightrequest' => $title), $link); ?>"><?php echo __('Request Booking', ST_TEXTDOMAIN); ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>