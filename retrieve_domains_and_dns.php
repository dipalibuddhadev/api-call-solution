<?php

// Define the API endpoint and key
$api_url = "https://api.recruitment.shq.nz";
$api_key = "h523hDtETbkJ3nSJL323hjYLXbCyDaRZ";
$client_id = 100;

// Function to retrieve domains
function getDomains($client_id, $api_key, $api_url) {
    $url = "$api_url/domains/$client_id?api_key=$api_key";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Function to retrieve DNS records for a zone
function getDNSRecords($zone_id, $api_key, $api_url) {
    $url = "$api_url/zones/$zone_id?api_key=$api_key";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Main function to retrieve and print domains and DNS records
function main() {
    global $client_id, $api_key, $api_url;

    // Retrieve domains
    $domains = getDomains($client_id, $api_key, $api_url);
    if (!$domains) {
        echo "Failed to retrieve domains.";
        return;
    }

    // Iterate through domains
    foreach ($domains as $domain) {
        echo "Domain: " . $domain['name'] . "\n";
        echo "DNS Records:\n";

        // Iterate through zones for each domain
        foreach ($domain['zones'] as $zone_id) {
            $dns_records = getDNSRecords($zone_id, $api_key, $api_url);
            if (!$dns_records) {
                echo "Failed to retrieve DNS records for zone $zone_id.\n";
                continue;
            }

            // Print DNS records
            foreach ($dns_records as $record) {
                echo "  " . $record . "\n";
            }
        }

        echo "\n";
    }
}

// Run the main function
main();

?>
