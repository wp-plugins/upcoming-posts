=== Upcoming Posts ===
Contributors: MrLive158
Visit link: http://mrlive.org/
Tags: scheduled, post,upcoming,future,draft,upcoming posts,upcoming post
Requires at least: 2.6
Tested up to: 2.7
Stable tag: 1.2.2

A nice plugin which creates a widget which shows your scheduled posts or drafts with excerpt and more infos.

== Description ==

It is good to update your blog regularly. But sometimes it is better to let your readers know exactly what and when you will post something. So I develop this plug-in for whom wants the readers be more curious about his blog. 

Features
1. Help you to show cheduled posts or drafts.
2. Configure in the widget: the number of posts; show the excerpt; the time format; a specific category.
3. Make your own style by editing `ucp.css` and `ucp_widget.php` files.

== Installation ==

1. Unzip into your wp-content/plugins directory & active through the "Plugins" menu in Dashboard.
2. Visit the "Widgets" menu and add it into your sidebar with proper choices.

== Frequently Asked Questions ==

= How can I find the Cat_ID to show posts in a specific category in ver 1.2.1? =

You can easily find it in "Dashboard\Posts\Categories" area, move the mouse over the category name and you will see something like "categories.php?action=edit&cat_ID=180", that's the point. Another way is to install a plug-in can show all the ID number (I am sure it exists)

= If my themes does not support widget, what can I do? =
1. The simpliest, widgetize your themes, u can search how to do it on the internet.
2. Download the ver 1.2.2 and use the function :
ucp_show(’the title here - it should be blank’,
‘the id of the specific cat if u want or leave it blank’,
‘number of posts to show’,
‘if no post’,
‘time style’,
‘if you want to show time’,
‘if u want to show cat’,
‘if u want to show excerp’,
‘if u want to switch to’ )

For example:
< ?php ucp_show('','','3','No post','d.m.Y','true',
'true', 'false','false'); ?>

== Screenshots ==

1. The control widget 1.2.1
2. An example 1.2.1



