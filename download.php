<?php

if(isset($_POST['video_url'])){
	
	// Get video URL from form input
	$video_url = $_POST['video_url'];
	
	// Extract video ID from URL
	$video_id = '';
	$url_parts = parse_url($video_url);
	parse_str($url_parts['query'], $query_params);
	if(isset($query_params['v'])){
		$video_id = $query_params['v'];
	}else{
		$video_id = basename($url_parts['path']);
	}
	
	// Construct download URL
	$download_url = "https://www.youtube.com/watch?v=$video_id";
	
	// Set file name for downloaded video
	$file_name = "$video_id.mp4";
	
	// Download video
	if(file_put_contents($file_name, file_get_contents($download_url))){
		echo "Video downloaded successfully!";
	}else{
		echo "Error downloading video.";
	}
}
?>
