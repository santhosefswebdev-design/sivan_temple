<!doctype html>
<html lang="en-US" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:addthis="https://www.addthis.com/help/api-spec"  prefix="og: http://ogp.me/ns#" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
	<script src="https://rawgit.com/kabachello/jQuery-Scanner-Detection/master/jquery.scannerdetection.js" ></script>
	<script>
	$(document).scannerDetection({

	  //https://github.com/kabachello/jQuery-Scanner-Detection

		timeBeforeScanTest: 200, // wait for the next character for upto 200ms
		avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
		endChar: [13],
	  //preventDefault: true, //this would prevent text appearing in the current input field as typed 
		onComplete: function(barcode, qty){
	   
			alert(barcode);
			$('#userInput, #scannerInput').val('');
			$('#userInput').focus();
			/* setTimeout(function(){
				location.href= 'https://templeganesh.grasp.com.my/ipay88/new.php?barcode=' + barcode;
			}, 3500); */
		} // main callback function 
	});
	</script>
</head>

<body>
	<input id="userInput" type="hidden"  autofocus/>
	<br>
	<div class="test">

	   <input id="scannerInput" type="hidden" value="barcodescan" autofocus/>
	</div>
</body>
</html>
