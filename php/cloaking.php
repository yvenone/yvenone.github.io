<?php

// Updated list of User-Agent strings for various bots
$robot_user_agents = array(
    'Googlebot', 
    'Slurp', 
    'bingbot', 
    'AhrefsBot', 
    'SemrushBot', 
    'DuckDuckBot', 
    'Baiduspider',
    'YandexBot',
    'Sogou',
    'Exabot',
    'Facebot',
    'ia_archiver'
);

// Updated list of IP address ranges (CIDR) for various bots
$robot_ip_ranges = array(
    '66.249.64.0/19',   // Googlebot
    '64.233.160.0/19',  // Googlebot
    '72.14.192.0/18',   // Googlebot
    '74.125.0.0/16',    // Googlebot
    '209.85.128.0/17',  // Googlebot
    '216.239.32.0/19',  // Googlebot
    '207.46.0.0/16',    // Bingbot
    '40.77.167.0/24',   // Bingbot
    '157.55.39.0/24',   // Bingbot
    '157.55.0.0/16',    // Bingbot
    '195.93.153.0/24',  // AhrefsBot
    '192.115.134.0/24', // AhrefsBot
    // Add more ranges as needed
);

// Retrieve the User-Agent and IP address of the visitor
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$ip_address = $_SERVER['REMOTE_ADDR'] ?? '';

// Function to check if an IP is within a CIDR range
function ip_in_range($ip, $range) {
    list($subnet, $mask) = explode('/', $range);
    return (ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == ip2long($subnet);
}

// Function to check if IP is in any of the defined ranges
function check_ip($ip, $ranges) {
    foreach ($ranges as $range) {
        if (ip_in_range($ip, $range)) {
            return true;
        }
    }
    return false;
}

// Check if the User-Agent or IP address matches the known bots
if (in_array($user_agent, $robot_user_agents) || check_ip($ip_address, $robot_ip_ranges)) {
    // Content for bots
    echo '<h1>Here goes the content intended for the Search Engines</h1>';
} else {
    // Content for regular users
    echo '<h1>Here goes the content intended for the website visitor</h1>';
}

?>
