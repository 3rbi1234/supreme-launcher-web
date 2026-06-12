<?php
// proxy.php - Simple proxy that WORKS on InfinityFree
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$url = isset($_GET['url']) ? $_GET['url'] : null;

if (!$url) {
    echo json_encode(['error' => 'No URL provided']);
    exit;
}

// Use file_get_contents with stream context
$options = [
    'http' => [
        'timeout' => 5,
        'method' => 'GET',
        'header' => "Accept: application/json\r\n"
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false
    ]
];

$context = stream_context_create($options);
$startTime = microtime(true);

$response = @file_get_contents($url, false, $context);
$ping = round((microtime(true) - $startTime) * 1000);

if ($response === false) {
    echo json_encode([
        'online' => false,
        'clients' => 0,
        'ping' => 0,
        'error' => 'Could not connect'
    ]);
    exit;
}

$data = json_decode($response, true);

if (!$data) {
    echo json_encode([
        'online' => false,
        'clients' => 0,
        'ping' => 0,
        'error' => 'Invalid response'
    ]);
    exit;
}

// Add ping to response
$data['_ping'] = $ping;

echo json_encode($data);
?>