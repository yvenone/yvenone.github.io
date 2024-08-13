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

// Retrieve the User-Agent of the visitor
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

// Check if the User-Agent matches any known bot User-Agent
if (in_array($user_agent, $robot_user_agents)) {
    // Content for bots
    echo '<h1>Here goes the content intended for the Search Engines</h1>';
} else {
    // Content for regular users
    echo '<h1>Here goes the content intended for the website visitor</h1>';
}

?>
