<?php
// - standalone json feed -
 
header('Content-Type:application/json');
 
// - grab wp load, wherever it's hiding -
if(file_exists('../../../../wp-load.php')) :
    include '../../../../wp-load.php';
else:
    include '../../../../../wp-load.php';
endif;
// - query -
//Get the category ID from the shortcode. If no shortcode category ID used, the shortcode defaults to 0 and the page displays all events.
$timeline_js3_cat = get_option('_timeline_js3_category');
// This is only used if timeline_js3_cat is not 0
$timeline_js3_page_id = get_option('_timeline_js3_page');

global $wpdb;
if($timeline_js3_cat === "0") {
$events = $wpdb->get_results( "SELECT *
FROM $wpdb->posts, $wpdb->postmeta m1
INNER JOIN $wpdb->postmeta m2
ON m1.post_id = m2.post_id
WHERE ($wpdb->posts.ID = m1.post_id AND $wpdb->posts.ID = m2.post_id)
AND post_status = 'publish'
AND (post_type ='event_type')
AND m1.meta_key = 'event_start_date' AND m2.meta_key = 'event_end_date'", OBJECT);
}
else {
$events = $wpdb->get_results( "SELECT *
FROM ($wpdb->postmeta m1, $wpdb->posts)
INNER JOIN $wpdb->term_relationships
ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
INNER JOIN $wpdb->term_taxonomy
ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
INNER JOIN $wpdb->postmeta m2
ON m1.post_id = m2.post_id
WHERE ($wpdb->posts.ID = m1.post_id AND $wpdb->posts.ID = m2.post_id)
AND (post_status = 'publish')
AND (post_type ='event_type')
AND (m1.meta_key = 'event_start_date' )
AND (m2.meta_key = 'event_end_date')
AND ($wpdb->term_taxonomy.taxonomy = 'category')
AND $wpdb->term_taxonomy.term_id IN ('" . $timeline_js3_cat . "')", OBJECT);
}
$site_title = get_bloginfo( 'name' );
$timeline_js3_page_title = get_the_title( $timeline_js3_page_id );

// For all event type items
// - loop -
if ($events):
global $post;
foreach ($events as $post):
setup_postdata($post);

$custom_event = get_post_custom(get_the_ID());
$event_start_date = $custom_event["event_start_date"][0];
$event_end_date = $custom_event["event_end_date"][0];
$event_headline_edit = get_edit_post_link( $post->ID );
$event_headline = "<a href='".get_permalink($post->ID)."'>".$post->post_title."</a>";
$attachments = get_attached_media( '', $post->ID );

//Check if user is logged in. If yes, show edit. If not, no edit.
if ( $user_ID ) {
$event_headline_edit = get_edit_post_link( $post->ID );
$event_headline_edit_href = "<a href='".$event_headline_edit."'>Edit</a>";
}
else {
$event_headline_edit = '';
$event_headline_edit_href = "";
}



//Use post thumbnails for Media image.
if ( has_post_thumbnail() ) {
	$attachment_id = get_post_thumbnail_id();
	$attachment_post = get_post($attachment_id);
	$attachment_caption = apply_filters ("the_content", $attachment_post->post_excerpt);
	$attachment_src = wp_get_attachment_url($attachment_id);
	$attachment_title = get_the_title($attachment_id);
}
else {
	$attachment_id = '';
	$attachment_alt = '';
	$attachment_caption = '';
	$attachment_description = '';
	$attachment_src = '';
	$attachment_title = '';
}

list($event_start_year, $event_start_month, $event_start_day) = explode("/", $event_start_date);

if ($event_end_date) {
list($event_end_year, $event_end_month, $event_end_day) = explode("/", $event_end_date);
}
else {
list($event_end_year, $event_end_month, $event_end_day) = explode("/", $event_start_date);
}

// - json event items -

$jsonevents[]= array(
		'start_date' => array (
				'year' => $event_start_year,
				'month' => $event_start_month,
				'day' => $event_start_day,
				),
		'end_date' => array (
				'year' => $event_end_year,
				'month' => $event_end_month,
				'day' => $event_end_day,
		),
		'media' => array (
				'caption' => $attachment_title,
				'credit' => $attachment_caption,
				'url' => $attachment_src,
				'thumb' =>$attachment_src,
				),
		'text' => array (
				'headline' => $event_headline,
				'text' => "<p>".$event_headline_edit_href."</p>".apply_filters ("the_content", $post->post_content),
		),
		
);
    
endforeach;
else :
endif;


$timelinejson=array(
		'title' => array(
				'text' => array (
						'headline' => $site_title,
						'text' => $timeline_js3_page_title.' Timeline',
				),
		),
"events" => $jsonevents,
);
 

echo json_encode($timelinejson);
?>
