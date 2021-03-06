# Timeline JS3 for Wordpress
Contributors: kcyarn
Tags: timeline, html5, json
Requires at least: 4.1
Tested up to: 4.2.4
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html

Integrates Timeline JS3 into WordPress and provides the ability to sort timeline events by category.

## Description
This plugin integrates Knightlab's Timeline JS3, currently in beta, into Wordpress. The Timeline Event post type allows users to create their timeline events just like any other Wordpress post with a 9999 BC to 9999 AD date picker for the event start and end date. At present, leaving the end date empty sets the end date equal to the start date. Timelines are displayed on pages via a shortcode and are filterable by category.

Notice: This plugin has not been reviewed. It is NOT intended for production sites.

Features:
Option to filter timeline events by category.
Display event featured image on the timeline.
Fullscreen timelines template.

Note: Timeline JS3 is presently under development. Features may change. JSON may change. You can always try this plugin with the latest, greatest version from Timeline JS3's github https://github.com/NUKnightLab/TimelineJS3, but please be aware it may or may not work.

## Installation
1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the WordPress plugins page.
3. Copy page-timeline-template.php to your theme's main folder.
4. Go to Timeline > Events to create new events.
5. Create your timeline page. The title displays on your timeline along with the word "Timeline".
6. Include shortcode [timeline_js3_wp] in your timeline page to display all events. Include shorctode [timeline_js3_wp category="2"] to display all events in the category with the id 2 and so on. Hint: Go to Categories under Timeline in WordPress admin and hover over category's edit link. The id number's in the url as tag_ID=#.
7. Set the Page Template to Fullscreen Timeline Page Template.

Thanks to KnightLab for all their hard work on Timeline, Timeline JS3, and their other projects!
