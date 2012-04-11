<?php
/* 
	prevents seeing a blank page for the custom post type
	page is accessible through the search
*/
$post_url = get_post_meta( $post->ID, 'wrc_award_url', true );
if(empty($post_url)){
	header("Location: " . site_url());
} else {
	header("Location: " . $post_url);
}
die();