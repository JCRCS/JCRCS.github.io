<?php
/*
  Template Name: Pop-up
 */

$page_id = (int)st()->get_option('page_terms_conditions');
query_posts( array('page_id' => $page_id ));

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if (!function_exists('_wp_render_title_tag')): ?>
            <title><?php wp_title('|', true, 'right') ?></title>
        <?php endif; ?>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class($bclass); ?>>
        <?php do_action('before_body_content') ?>

        <div class="container">
            <h1 class="page-title"><?php the_title() ?></h1>
            <div class="row mb20">
                <div class="col-sm-12">
                    <?php
                    while (have_posts()) {
                        the_post();
                        ?>
                        <div <?php post_class() ?>>
                            <div class="entry-content">
                                <?php
                                the_content();
                                ?>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
        <?php do_action('st_before_footer'); ?>
        <?php do_action('st_after_footer'); ?>
    </body>
</html>
<?php wp_reset_query(); ?>


