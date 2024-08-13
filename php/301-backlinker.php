<?php
// Define the User-Agent strings to check for
$bot_agents = [
    'SemrushBot',
    'AhrefsBot',
    'Googlebot',
    'bingbot'
];

// Get the User-Agent of the visitor
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Check if the User-Agent matches any of the bot agents
foreach ($bot_agents as $bot) {
    if (stripos($user_agent, $bot) !== false) {
        // Redirect to the specified URL if a match is found
        header("Location: https://yvenone.github.io");
        exit();
    }
}
?>
