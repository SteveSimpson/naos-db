<?php

$printed = [];

$dns = [];

$ipv4 = [];

$ipv4net = [];

foreach($hosts as $host) {
    $dnsdomain = substr($host['fqdn'], (strpos($host['fqdn'],'.') +1) );
    
    $dns[$dnsdomain] = $dnsdomain;
    
    $net4parts = explode(".", $host['ipv4']);
    if (is_array($net4parts) && count($net4parts) == 4) {
        $net4 = $net4parts[0] . "." .  $net4parts[1] . "." .  $net4parts[2];
        
        $ipv4[$net4][$net4parts[3]] = $host['fqdn'];
    }
    
    
    $net6parts = explode(":", $host['ipv6']);
    if (is_array($net6parts) && count($net6parts) >= 5) {
        $net6 = $net6parts[0] . ":" .  $net6parts[1] . ":" .  $net6parts[2] . ":" .  $net6parts[3];
        
        for ($i=0; $i<4; $i++) {
            array_shift($net6parts);
        }
        
        $host6 = trim(implode(":",$net6parts), ":");
        
        $ipv6[$net6][$host6] = $host['fqdn'];
    }
    
}

foreach($cnames as $cname) {
    $dns[$cname['domain']] = $cname['domain'];
}

/*
foreach($hosts as $host) {
    $dnsdomain = substr($host['fqdn'], (strpos($host['fqdn'],'.') +1) );
    
    if (!array_key_exists($dnsdomain, $printed)) {
        //echo "\n## IPv4 - " . $host['network_name'] . "\n";
        $printed[$dnsdomain] = 1;
        echo "\n\$ORIGIN " .$dnsdomain . "\n";
    }
    echo str_pad($host['hostname'], 15) . " in      a  " . $host['ipv4'] . "\n";
}
*/
foreach($dns as $name) {
    echo "\$ORIGIN " .$name . "\n";
    
    $count = 0;
    foreach($hosts as $host) {
        if (($host['hostname'].".".$name == $host['fqdn']) && (strlen($host['ipv4']) > 6)) {
            echo str_pad($host['hostname'], 15) . " IN      A  " . $host['ipv4'] . "\n";
            $count++;
        }
    }
    if ($count > 0) { echo "\n"; }
    
    $count = 0;
    foreach($hosts as $host) {
        if (($host['hostname'].".".$name == $host['fqdn']) && (strlen($host['ipv6']) > 6)) {
            echo str_pad($host['hostname'], 15) . " IN   AAAA  " . $host['ipv6'] . "\n";
            $count++;
        }
    }
    if ($count > 0) { echo "\n"; }
    
    foreach($cnames as $cname) {
        if ($cname['domain'] == $name) {
            echo str_pad($cname['cname'], 15) . " IN  CNAME  " . $cname['target'] . ".\n";
        }
    }

    echo "\n\n";
}

ksort($ipv4);
foreach($ipv4 as $net=>$data) {
    echo "## " . $net . ".0\n" ;
    foreach($data as $last => $fqdn) {
        echo str_pad($last, 5) . "IN   PTR   " . $fqdn . ".\n";
    }
    
    echo "\n\n";
}

ksort($ipv6);
foreach($ipv6 as $net=>$data) {
    echo "## " . $net . "::/64\n" ;
    foreach($data as $last => $fqdn) {
        echo str_pad($last, 21) . "IN   PTR   " . $fqdn . ".\n";
    }
    
    echo "\n\n";
}
