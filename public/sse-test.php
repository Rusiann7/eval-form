<?php
// Set headers for SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Disable output buffering for real-time updates
if (ob_get_level() > 0) {
    ob_end_clean();
}

$counter = 0;
while (true) {
    // Send a message every 3 seconds
    echo "event: message\n"; // Optional: specify an event type
    echo "data: This is message number " . $counter . " from the server.\n\n";

    // Flush the output buffer to send data immediately
    flush();

    // Check if the client connection has been aborted
    if (connection_aborted()) {
        break;
    }

    $counter++;
    sleep(3); // Wait for 3 seconds before sending the next message
}