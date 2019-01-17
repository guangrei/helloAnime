<?php
/**
 * Plugin Name: HelloAnime
 * Plugin URI: https://github.com/guangrei/helloAnime
 * Description: show random anime quote (Bahasa Indonesia) in wordpress dashboard
 * Version: 1.0.0
 * Author: grei
 * Author URI: https://ipynb.wordpress.com
 * License: GPL-3.0
 */

function hello_anime_get_quote() {
	
	$quote = unserialize(file_get_contents(__DIR__."/AnimeQuote.txt"));

	// randomly choose a line
	return wptexturize( $quote[ mt_rand( 0, $quote->count() - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later
function hello_anime() {
	$chosen = hello_anime_get_quote();
	echo "<p id='hanime'>$chosen</p>";
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'admin_notices', 'hello_anime' );

// We need some CSS to position the paragraph
function anime_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#hanime {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;		
		margin: 0;
		font-size: 11px;
	}
	</style>
	";
}

add_action( 'admin_head', 'anime_css' );
