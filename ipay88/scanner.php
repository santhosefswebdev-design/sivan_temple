<!DOCTYPE html>
<html>
	<head>
		<script src="https://raw.githubusercontent.com/mebjas/html5-qrcode/master/minified/html5-qrcode.min.js"></script>
	</head>
	<body>
		<div style="width: 500px" id="reader"></div>
		<script>
				
		function onScanSuccess(decodedText, decodedResult) {
			// Handle on success condition with the decoded text or result.
			console.log(`Scan result: ${decodedText}`, decodedResult);
			// ...
			html5QrcodeScanner.clear();
			// ^ this will stop the scanner (video feed) and clear the scan area.
		}

		function onScanError(errorMessage) {
			// handle on error condition, with error message
		}

		var html5QrcodeScanner = new Html5QrcodeScanner(
			"reader", { fps: 10, qrbox: 250 });
		html5QrcodeScanner.render(onScanSuccess, onScanError);
		</script>
	</body>
</html>