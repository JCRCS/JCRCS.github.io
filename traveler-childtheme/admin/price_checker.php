<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
wp_enqueue_style('jjquery-ui.theme.min.css', get_template_directory_uri() . '/css/admin/jquery-ui.min.css');
wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.js');


$post_id = (int) $_REQUEST['post_id'];
$pax = (int) $_REQUEST['pax'];
$check_in = $_REQUEST['check_in'];
$check_out = $_REQUEST['check_out'];

if (empty(strtotime($check_in))) {
    $check_in = "";
}

if (empty(strtotime($check_out))) {
    $check_out = "";
}
?>


<div class="wrap">
    <h1>Antigua Rental & Services</h1>
    <h2>Property Price Calculator</h2>
    <form method="post" action="">
        <?php settings_fields('general'); ?>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="post_id"><?php _e('Property') ?></label></th>
                <td>
                    <?php
                    $posts = get_posts(array(
                        'post_type' => 'st_rental',
                        'posts_per_page' => -1,
                        'orderby' => 'post_title',
                        'post_status' => 'publish',
                    ));
                    $options = "";
                    foreach ($posts as $post) {
                        $selected = ($post_id == $post->ID) ? 'selected="selected"' : '';
                        $options .= '<option value="' . $post->ID . '" ' . $selected . '>' . $post->post_title . '</option>';
                    }
                    ?>
                    <select name="post_id" id="post_id"><?php echo $options; ?></select></td>
            </tr>
            <tr>
                <th scope="row"><label for="pax"><?php _e('Pax') ?></label></th>
                <td>
                    <?php
                    $options = "";
                    for ($i = 1; $i < 40; $i++) {
                        $selected = ($i == $pax) ? 'selected="selected"' : '';
                        $options .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                    }
                    ?>
                    <select name="pax" id="pax"><?php echo $options; ?></select></td>
            </tr>
            <tr>
                <th scope="row"><?php _e('Dates') ?></label></th>
                <td>
                    <script>
                        jQuery(document).ready(function ($) {
                            $("#check_in").datepicker({dateFormat: "yy-mm-dd"});
                            $("#check_out").datepicker({dateFormat: "yy-mm-dd"});
                        });
                    </script>
                    Check in <input type="text" name="check_in" id="check_in" value="<?php echo esc_attr($check_in) ?>" />
                    Check out <input type="text" name="check_out" id="check_out" value="<?php echo esc_attr($check_out) ?>" />


                </td>
            </tr>
            <tr>
                <td>
                    <?php submit_button('Get Price'); ?>
                </td>
            </tr>
            <tr>
                <th>Price quote</th>
                <td>
                    <p>
                        <?php
                        $price = ars_get_rental_price($post_id, strtotime($check_in), strtotime($check_out), $pax, true);
                        if (!empty($price)) {
                            if ($price["status"] == "OK") {
                                echo "Final price: <strong>" . round($price["final_price"], 2)."</strong>";
                            } else {
                                ?>Error: <?php echo $price["message"];
                            }
                            ?></p><p>RAW PRICING REPORT</p><p><pre><?php
                            var_dump($price);
                        }
                        ?></pre></p>
                </td>
            </tr>
        </table>
    </form>
</div>

