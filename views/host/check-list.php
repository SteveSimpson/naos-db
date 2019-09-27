<?php
if ($format == 'text') {
    foreach($hosts as $host) {
        echo $host['fqdn'] . "\n";
    }
} else {
?>
<table class='table'>
<?php
foreach($hosts as $host) {
	echo "<tr><td><input type='checkbox'> ".$host['fqdn']."</td></tr>\n";
}
?>
</table>
<?php } ?>