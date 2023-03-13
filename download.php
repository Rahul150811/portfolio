<?php
// Set the video ID
$video_id = "YOUR_VIDEO_ID_HERE";

// Set the API key
$api_key = "AIzaSyD3brMXXIj0FfBTNNxlA0FSivejVTZ171w";

// Set the endpoint URL
$url = "https://www.googleapis.com/youtube/v3/videos?id=".$video_id."&key=".$api_key."&part=snippet";

// Get the video information using cURL
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($curl);
curl_close($curl);

// Parse the JSON response
$data = json_decode($response, true);

// Get the video title and URL
$title = $data["items"][0]["snippet"]["title"];
$url = "https://www.youtube.com/watch?v=".$video_id;

// Set the download headers
header("Content-Type: video/mp4");
header("Content-Disposition: attachment; filename=".$title.".mp4");

// Download the video using cURL
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curl, CURLOPT_TIMEOUT, 600);
$data = curl_exec($curl);
curl_close($curl);

// Output the video data
echo $data;
?>
