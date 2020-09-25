<?php 
$printed = [];

echo "## Generated on: " . date("Y-m-d H:i:s") . "\n";

foreach($hosts as $host) {
    if($host['ipv4'] != "") {
        if (!array_key_exists($host['network_name']."4", $printed)) {
            echo "\n## IPv4 - " . $host['network_name'];
            
            $printed[$host['network_name']."4"] = 1;
            
            foreach ($nets as $net) {
                if ($net->network_name == $host['network_name']) {
                    echo "\n##  " . $net->range4 . " /" . $net->mask4 . " (" . $net->netmask . ")";
                }
            }
            
            echo "\n";
        }
        echo str_pad($host['ipv4'], 15) . " " . $host['fqdn'] ." " . $host['hostname'] ;
        
        echo "\n";
    }
}
