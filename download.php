<?php

$video_id = 'VIDEO_ID_HERE'; // Replace VIDEO_ID_HERE with the YouTube video ID
$download_url = 'https://www.youtube.com/watch?v=' . $video_id;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $download_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$response = curl_exec($ch);
curl_close($ch);

if(preg_match('/[a-zA-Z0-9_-]{11}/', $download_url, $matches)) {
    $video_id = $matches[0];
}
$download_link = 'https://www.youtube.com/get_video_info?video_id='.$video_id.'&el=detailpage&ps=default&eurl=&gl=US&hl=en';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $download_link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

parse_str($response, $data);
$streams = $data['url_encoded_fmt_stream_map'];
$streams = explode(',',$streams);

foreach ($streams as $stream) {
    parse_str($stream, $stream_data);
    $url = urldecode($stream_data['url']);
    $type = explode(';', $stream_data['type']);
    $type = $type[0];
    $ext = str_replace('video/','',$type);
    $title = $data['title'].'.'.$ext;
    $title = str_replace(' ','_',$title);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    $file = fopen($title, 'w');
    fwrite($file, $response);
    fclose($file);
}

echo 'Video Downloaded Successfully!';

?>
