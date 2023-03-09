<!DOCTYPE html>
<html>
<head>
	<title>Real-Time Clock</title>
	<style>
		body {
			text-align: center;
			font-size: 2em;
			margin-top: 100px;
		}
	</style>
</head>
<body>
	<h1 id="clock"></h1>

	<script>
		function updateTime() {
			var now = new Date();
            now.getTime();
			var hours = now.getHours();
			var minutes = now.getMinutes();
			var seconds = now.getSeconds();

			// Add leading zeros to the hours, minutes, and seconds
			hours = hours < 10 ? "0" + hours : hours;
			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			// Format the time as "hh:mm:ss"
			// var timeString = hours + ":" + minutes + ":" + seconds;
            var timeString = now.getTime();

			// Update the clock element with the new time
			document.getElementById("clock").innerHTML = timeString;
		}

		// Call updateTime every second to update the clock
		setInterval(updateTime, 1000);
	</script>
</body>
</html>