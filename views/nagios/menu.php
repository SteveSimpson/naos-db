<?php
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Web Interface Monitoring</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="robots" content="noindex, nofollow" />
	<link rel="stylesheet" type="text/css" href="stylesheets/interface/menu.css" />
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/menu.js"></script>
</head>
<body>
	<div id="menu">
	<?php 
	$class = "menuli_style1";
	foreach($model as $header=>$data) {
	    echo "		<h2>$header</h2>\n";
	    echo "		<ul>\n";
	    foreach ($data as $row) {
	        echo "			<li class='$class'>\n";
	        foreach ($row as $key=>$link) {
	            $link = urlencode($link);
	            echo "<a href='$link' target='main'>$key</a> ";
	        }
	        
	        if ($class == "menuli_style1") {
	            $class = "menuli_style2";
	        } else {
	            $class = "menuli_style1";
	        }
	        echo "			</li>\n";
	    }
	    echo "		</ul>\n";
	}
	?>
	</div>
</body>
</html>
	
	
	