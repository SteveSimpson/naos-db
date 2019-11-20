<?php 
$printed = [];

echo "## Generated on: " . date("Y-m-d H:i:s") . "\n";

if ($header) {
    echo $header->value . "\n";
}

foreach($hosts as $host) {
    if (!array_key_exists($host['network_name']."4", $printed)) {
        echo "\n## IPv4 - " . $host['network_name'] . "\n";
        $printed[$host['network_name']."4"] = 1;
    }
    echo str_pad($host['ipv4'], 15) . " " . $host['fqdn'] ." " . $host['hostname'] ;
    
    foreach ($cnames as $cname) {
        if ($cname['target'] == $host['fqdn']) {
            echo " " . $cname['cname'] . "." . $cname['domain'];
        }
    }
    
    echo "\n";
}

foreach($hosts as $host) {
    if (!array_key_exists($host['network_name']."6", $printed)) {
        echo "\n## IPv6 - " . $host['network_name'] . "\n";
        $printed[$host['network_name']."6"] = 1;
    }
    echo str_pad($host['ipv6'], 39) . " " . $host['fqdn'] ." " . $host['hostname'] . "\n";
}

if ($footer) {
    echo $footer->value . "\n";
}