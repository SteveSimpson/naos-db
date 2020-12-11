<?php
/**
 * @var string $logoImage 
 * @var string $logoText 
 */

if (isset($logoImage) && $logoImage) {
    $logo = '<img src="'.$logoImage.'" alt="Logo" />';
} elseif (isset($logoText) && $logoText) {
    $logo = $logoText;
} else {
    $logo = '<img src="images/interface/logo.gif" alt="Logo" />';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Web Interface Monitoring</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="robots" content="noindex, nofollow" />
	<link rel="stylesheet" type="text/css" href="stylesheets/interface/common.css" />
</head>
<body>
	<div id="top_left">
		<h1><?=$logo ?></h1>
	</div>
	<div id="top_right">
		<p><a href="https://www.nagios.org/" target="_blank"><img src="images/interface/nagios.gif" alt="Nagios" /></a></p>
	</div>
</body>

</html>