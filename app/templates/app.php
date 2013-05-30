<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Front</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<style>
		html, body {margin: 0; padding: 0; background-color: #444;}
		.container {position: relative; width: 100%;}
		.main {margin: 0 auto; position: relative; width: 581px; height: 100%;}
		iframe {height: 100%; background-color: #fff;}
	</style>
</head>
<body>
	<div class="container">
		<div class="main">
			<iframe id="main-frame" width="581" src="sharePage" frameborder="0" scrolling="no"></iframe>
		</div>
	</div>
	<script>
		$(function(){
			var button = 'button#share';
			var iframe = '#main-frame';
			$(iframe).load( function(){
				$(this).contents().find(button).on('click',function() {
					$(iframe).attr('src','getCoupon');
				});
			});
		});
	</script>
</body>
</html>