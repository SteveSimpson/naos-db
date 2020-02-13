<?php
if ($format == 'text') {
    foreach($hosts as $host) {
        if ($host['fqdn'] != "") {
            echo $host['fqdn'] . "\n";
        }
    }
} else {
?>
<table class='table'>
<?php
foreach($hosts as $host) {
    if ($host['fqdn'] != "") {
    	echo "<tr><td><input type='checkbox'> ".$host['fqdn']."</td></tr>\n";
    }
}
?>
</table>
<?php } ?>