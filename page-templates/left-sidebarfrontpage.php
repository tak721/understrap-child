<?php
/**
 * Template Name: Left Sidebar Layout
 *
 * This template can be used to override the default template and sidebar setup
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<?php get_template_part( 'sidebar-templates/sidebar', 'left' ); ?>

			<div
				class="<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>col-md-8<?php else : ?>col-md-12<?php endif; ?> content-area"
				id="primary">

				<main class="site-main" id="main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

					<?php endwhile; // end of the loop. ?>

                    <!-- フロントページ用ウィジェットエリア追加 -->
                    <?php if(is_active_sidebar('widget_id001')) : ?>
                    <div class="row">
                        <aside>
                        <?php if(is_active_sidebar('widget_id001')) : ?>
                            <?php if(is_active_sidebar('widget_id002')) : ?>
                                <div class="col-sm-6 col-12">
                            <?php else: ?>
                                <div class="col-12">
                            <?php endif; ?>
                                <ul id="front_widget">
                                    <?php dynamic_sidebar('widget_id001'); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if(is_active_sidebar('widget_id002')) : ?>
                            <div class="col-sm-6 col-12">
                                <ul id="front_widget">
                                    <?php dynamic_sidebar('widget_id002'); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        </aside>
                    </div>
                    <?php endif; ?>
                    <!-- ここまで　フロントページ用ウィジェット -->

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>
