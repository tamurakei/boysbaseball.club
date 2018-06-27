<?php
/*
Plugin Name: Change http:// -> https://
Plugin URI: http://www.shikumilab.jp
Version: 1.0
Description: replace http:// -> https://
Author: Shikumilab.jp
Author URI: http://www.shikumilab.jp
*/

function change_http_to_https ( $content ) {
	str_replace("http://","https://",$content);
	return $content ;
}
add_filter( 'the_content', 'change_http_to_https' );
