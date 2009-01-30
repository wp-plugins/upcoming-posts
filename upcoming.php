<?php
/*
Plugin Name: Upcoming Posts
Plugin URI: http://mrlive.org/2009/01/plugin-dau-tay-upcoming-posts/
Version: 1.1
Description: Create a widget which shows all of your scheduled posts to notice your readers for coming back intime.
Author: MrLive
Author URI: http://mrlive.org
*/
function ucp_headaction()
{
	echo '<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/'.PLUGINDIR.'/'.dirname( plugin_basename(__FILE__) ).'/ucp.css" type="text/css" />';
}

function ucp_control_gen($ucp_title, $ucp_num, $ucp_nopost, $show_cat, $show_excerpt,$just_draft)  /* setup */
{
?>
<p>
	<label for="ucp-title"><?php _e('Title:'); ?>
		<input class="widefat" id="ucp-title" name="ucp-title" type="text" value="<?php echo attribute_escape($ucp_title); ?>"	/>
	</label>
</p>
<p>
	<label for="ucp-num"><?php _e('Number of posts to show:'); ?>
		<input class="widefat" id="ucp-num" name="ucp-num" type="text" value="<?php echo attribute_escape($ucp_num); ?>"	/>
	</label>
</p>
<p>
	<label for="ucp_nopost"><?php _e('If no post:'); ?>
		<input class="widefat" id="ucp-nopost" name="ucp-nopost" type="text" value="<?php echo attribute_escape($ucp_nopost); ?>"	/>
	</label>
</p>
<p>
	<label for="show-cat">
		<input class="checkbox" type="checkbox"
			id="show-cat" name="show-cat"
			<?php echo $show_cat ? 'checked="checked"' : ''; ?>
		/>
		<?php _e('Show more info (time&cat)'); ?>
	</label>
</p>
<p>
	<label for="show-excerpt">
		<input class="checkbox" type="checkbox"
			id="show-excerpt" name="show-excerpt"
			<?php echo $show_excerpt ? 'checked="checked"' : ''; ?>
		/>
		<?php _e('Show excerpt'); ?>
	</label>
</p>
<p>
	<label for="just-draft">
		<input class="checkbox" type="checkbox"
			id="just-draft" name="just-draft"
			<?php echo $just_draft ? 'checked="checked"' : ''; ?>
		/>
		<?php _e('Just show only draft'); ?>
	</label>
</p>
<input type="hidden"   id="ucp-widget-submit" name="ucp-widget-submit"   value="1"/>
<?php
}

function ucp_control() {
	$options = $newoptions = get_option('ucp_content_gen');
	if ($_POST['ucp-widget-submit']) {
			$newoptions['ucp-title'] = strip_tags(stripslashes($_POST['ucp-title']));
			$newoptions['ucp-num'] = strip_tags(stripslashes($_POST['ucp-num']));
			$newoptions['ucp-nopost'] = strip_tags(stripslashes($_POST['ucp-nopost']));
			$newoptions['show-cat'] = isset($_POST['show-cat']);
			$newoptions['show-excerpt'] = isset($_POST['show-excerpt']);
			$newoptions['just-draft'] = isset($_POST['just-draft']);
	}

	if ($options != $newoptions) {
		$options = $newoptions;
		update_option('ucp_content_gen', $options);
	}

	ucp_control_gen(
		$options['ucp-title'],
		$options['ucp-num'],
		$options['ucp-nopost'],
		$options['show-cat'],
		$options['show-excerpt'],
		$options['just-draft']);
}


function ucp_content_gen($args)  /* show content */
{
	extract($args);
	$options = get_option('ucp_content_gen');
	$ucp_title =empty($options['ucp-title']) ?
		__('Upcoming Posts') :
		$options['ucp-title'];
	$ucp_num =empty($options['ucp-num']) ?
		__('2') :
		$options['ucp-num'];
	$ucp_nopost =empty($options['ucp-nopost']) ?
		__('I am thinking about it...') :
		$options['ucp-nopost'];
	$show_cat = $options['show-cat'] ? true: false;
	$show_excerpt = $options['show-excerpt'] ? true: false;
	$just_draft = $options['just-draft'] ? true: false;
	echo $before_widget ;
	echo $before_title . $ucp_title . $after_title;
	?>
	<span id="ucp_content">
	<?php
	if ($just_draft) {
	/* just show draft */
	$takethem = new WP_Query("post_status=draft&order=ASC&showposts=$ucp_num");
	if ($takethem->have_posts()) { 
		while ($takethem->have_posts()) :$takethem->the_post();	$do_not_duplicate = $post->ID;?>
				<ul>
					<li>
						<?php if ($show_cat) {?><strong><?php the_category(', ');?></strong><br/><?php the_title(); } 
						else {the_title(); } ?><br/>	
					<span class="ucp_excerpt"><?php if ($show_excerpt) {the_excerpt();} ?></span>
					</li>
				</ul>
	<?php endwhile; } 
	else { ?>
					<ul>
						<li><?php echo $ucp_nopost; ?></li>
					</ul>	
	<?php }
	}
	else
	{
/* show future */
		$takethem = new WP_Query("post_status=future&order=ASC&showposts=$ucp_num");
	if ($takethem->have_posts()) { 
		while ($takethem->have_posts()) :$takethem->the_post();	$do_not_duplicate = $post->ID;?>
				<ul>
					<li>
						<?php if ($show_cat) { ?><strong><?php the_time('d/m');?>:<?php the_category(', ');?></strong><br/><?php the_title();}
						else {the_title(); } ?>
						<span class="ucp_excerpt"><?php if ($show_excerpt) {the_excerpt();} ?></span>
					</li>
				</ul>
	<?php endwhile; } 
	else { ?>
					<ul>
						<li><?php echo $ucp_nopost; ?></li>
					</ul>	
	<?php } 
	}
	?>
	</span> 
	<?php
	echo $after_widget;
}

function ucp_init() /* register */
{
	register_sidebar_widget(__('Upcoming Posts'),'ucp_content_gen');
	register_widget_control(__('Upcoming Posts'),'ucp_control');
}
add_action("plugins_loaded", "ucp_init");
add_action("wp_head","ucp_headaction");

?>
