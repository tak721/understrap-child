<?php
/**
 * The Script for Widget on Toppage.
 * Event(Right)
 */
global $post;
$tmp_post = $post;
?>
<ul>
<?php
$get_posts_args = array(
	'category__in' => array( 4, 7 ),  // 表示カテゴリー変更時はここのIDを変更
	'numberposts' => 5,
	'order' => 'DESC',
	'orderby' => 'date'
);
$postslist = get_posts( $get_posts_args );
foreach ( $postslist as $post ) {
?>
    <li>・<a href=<?php echo get_permalink( $post->ID ); ?>><?php echo $post->post_title; ?></a><br />
<div align="right">(<?php echo the_time('Y/m/d'); ?>)</div></li>
<?php
}
?>
</ul>
<?php
$post = $tmp_post;
?>
