<?php 
$printed = [];

foreach($hosts as $host) {
    if (!array_key_exists($host['network_name']."4", $printed)) {
        echo "\n## IPv4 - " . $host['network_name'] . "\n";
        $printed[$host['network_name']."4"] = 1;
    }
    echo str_pad($host['ipv4'], 15) . " " . $host['fqdn'] ." " . $host['hostname'] . "\n";
}

foreach($hosts as $host) {
    if (!array_key_exists($host['network_name']."6", $printed)) {
        echo "\n## IPv6 - " . $host['network_name'] . "\n";
        $printed[$host['network_name']."6"] = 1;
    }
    echo str_pad($host['ipv6'], 39) . " " . $host['fqdn'] ." " . $host['hostname'] . "\n";
}
