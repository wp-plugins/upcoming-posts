<?php
/*
Plugin Name: Upcoming Posts
Plugin URI: http://mrlive.org/2009/01/plugin-dau-tay-upcoming-posts/
Version: 1.2.1
Description: Create a widget which shows all of your scheduled posts to notice your readers for coming back intime.
Author: MrLive
Author URI: http://mrlive.org
*/
function ucp_headaction()
{
	echo '<link rel="stylesheet" href="'.get_bloginfo('wpurl').'/'.PLUGINDIR.'/'.dirname( plugin_basename(__FILE__) ).'/ucp.css" type="text/css" />';
}

function ucp_control_gen($ucp_title, $ucp_catid, $ucp_num, $ucp_nopost, $ucp_time ,$show_time, $show_cat, $show_excerpt,$just_draft)  /* setup */
{
?>
<p>
	<label for="ucp-title"><?php _e('Title:'); ?>
		<input class="widefat" id="ucp-title" name="ucp-title" type="text" value="<?php echo attribute_escape($ucp_title); ?>"	/>
	</label>
</p>
<p>
	<label for="ucp-catid"><?php _e('Specific Cat_ID <br/>(leave blank to show all):'); ?>
		<input class="widefat" id="ucp-catid" name="ucp-catid" type="text" value="<?php echo attribute_escape($ucp_catid); ?>"	/>
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
	<label for="ucp_time"><?php _e('Time format:'); ?>
		<input class="widefat" id="ucp-time" name="ucp-time" type="text" value="<?php echo attribute_escape($ucp_time); ?>"	/>
	</label>
</p>
<p>
	<label for="show-time">
		<input class="checkbox" type="checkbox"
			id="show-time" name="show-time"
			<?php echo $show_time ? 'checked="checked"' : ''; ?>
		/>
		<?php _e('Show Timestamp'); ?>
	</label>
</p>
<p>
	<label for="show-cat">
		<input class="checkbox" type="checkbox"
			id="show-cat" name="show-cat"
			<?php echo $show_cat ? 'checked="checked"' : ''; ?>
		/>
		<?php _e('Show Category'); ?>
	</label>
</p>
<p>
	<label for="show-excerpt">
		<input class="checkbox" type="checkbox"
			id="show-excerpt" name="show-excerpt"
			<?php echo $show_excerpt ? 'checked="checked"' : ''; ?>
		/>
		<?php _e('Show Excerpt'); ?>
	</label>
</p>
<p>
	<label for="just-draft">
		<input class="checkbox" type="checkbox"
			id="just-draft" name="just-draft"
			<?php echo $just_draft ? 'checked="checked"' : ''; ?>
		/>
		<?php _e('Switch to Drafted Posts'); ?>
	</label>
</p>
<input type="hidden"   id="ucp-widget-submit" name="ucp-widget-submit"   value="1"/>
<?php
}

function ucp_control() {
	$options = $newoptions = get_option('ucp_content_gen');
	if ($_POST['ucp-widget-submit']) {
			$newoptions['ucp-title'] = strip_tags(stripslashes($_POST['ucp-title']));
			$newoptions['ucp-catid'] = strip_tags(stripslashes($_POST['ucp-catid']));
			$newoptions['ucp-num'] = strip_tags(stripslashes($_POST['ucp-num']));
			$newoptions['ucp-nopost'] = strip_tags(stripslashes($_POST['ucp-nopost']));
			$newoptions['ucp-time'] = strip_tags(stripslashes($_POST['ucp-time']));
			$newoptions['show-time'] = isset($_POST['show-time']);
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
		$options['ucp-catid'],
		$options['ucp-num'],
		$options['ucp-nopost'],
		$options['ucp-time'],
		$options['show-time'],
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
	$ucp_catid =empty($options['ucp-catid']) ?
		__('') :
		$options['ucp-catid'];
	$ucp_num =empty($options['ucp-num']) ?
		__('2') :
		$options['ucp-num'];
	$ucp_nopost =empty($options['ucp-nopost']) ?
		__('I am thinking about it...') :
		$options['ucp-nopost'];
	$ucp_time =empty($options['ucp-time']) ?
		__('d.m.Y') :
		$options['ucp-time'];
	$show_time = $options['show-time'] ? true: false;
	$show_cat = $options['show-cat'] ? true: false;
	$show_excerpt = $options['show-excerpt'] ? true: false;
	$just_draft = $options['just-draft'] ? true: false;
	echo $before_widget ;
	echo $before_title . $ucp_title . $after_title;
	include(PLUGINDIR.'/'.dirname( plugin_basename(__FILE__) ).'/ucp_widget.php');
	echo $after_widget;
}

function ucp_show($ucp_title, $ucp_catid, $ucp_num, $ucp_nopost, $ucp_time ,$show_time, $show_cat, $show_excerpt,$just_draft) {
	echo $before_widget ;
	echo $before_title . $ucp_title . $after_title;
	include(PLUGINDIR.'/'.dirname( plugin_basename(__FILE__) ).'/ucp_widget.php');
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
