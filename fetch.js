const form = document.querySelector('form');
form.addEventListener('submit', (event) => {
	event.preventDefault(); // prevent the form from submitting

	const input = document.querySelector('#video-url');
	const videoUrl = input.value;

	// fetch the server-side script with the video URL as a query parameter
	fetch('download.php?videoUrl=' + encodeURIComponent(videoUrl))
		.then(response => {
			// handle the response (in this example, we assume the server returns the video as a blob)
			return response.blob();
		})
		.then(blob => {
			// create a URL object from the blob and initiate the download
			const url = URL.createObjectURL(blob);
			const a = document.createElement('a');
			a.href = url;
			a.download = 'video.mp4';
			document.body.appendChild(a);
			a.click();
			a.remove();
			URL.revokeObjectURL(url);
		})
		.catch(error => {
			console.error(error);
			alert('An error occurred while downloading the video.');
		});
});
