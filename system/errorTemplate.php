<!Doctype html>
<html>
	<head>
	<title>Zeus Framework Error</title>
	</head>
	<body>
		<div style="background: #000; color: #f00; font-size:16;">The Zeus Framework Encountered the Error</div>
		<div>
			<ul>
				<li>On line <?php echo $errline; ?> of <?php echo $errfile; ?> : <?php echo $errstr; ?></li>
			</ul>
		</div>
		<div>
			<strong>Stack Trace:</strong><br />
			<pre>
			<?php
				print_r(debug_backtrace());
			?>
			</pre>
		</div>
	</body>
</html>