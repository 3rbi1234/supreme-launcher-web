<?php
// test.php - Diagnose server connection issues
echo "<h1>Server Connection Test</h1>";

$servers = [
    'en' => ['ip' => '207.180.229.160', 'port' => '30120'],
    'de' => ['ip' => '2.70.217.223', 'port' => '30120']
];

foreach ($servers as $key => $server) {
    $url = "http://{$server['ip']}:{$server['port']}/dynamic.json";
    
    echo "<h2>Testing: $key - $url</h2>";
    
    // Check if curl is available
    if (!function_exists('curl_init')) {
        echo "<p style='color:red'>❌ cURL is NOT enabled on this server!</p>";
        continue;
    }
    
    // Try with curl
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "<p>HTTP Code: <b>$httpCode</b></p>";
    if ($error) {
        echo "<p style='color:red'>❌ cURL Error: $error</p>";
    }
    if ($response) {
        echo "<p style='color:green'>✅ Response received!</p>";
        $data = json_decode($response, true);
        if ($data) {
            echo "<p>Players: <b>" . ($data['clients'] ?? 'N/A') . "</b></p>";
        }
    }
    
    // Try file_get_contents as fallback
    echo "<p>Trying file_get_contents...</p>";
    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
    $fgcResponse = @file_get_contents($url, false, $ctx);
    if ($fgcResponse) {
        echo "<p style='color:green'>✅ file_get_contents worked!</p>";
    } else {
        echo "<p style='color:orange'>⚠️ file_get_contents failed (this is normal if allow_url_fopen is off)</p>";
    }
    
    echo "<hr>";
}

echo "<h2>PHP Info:</h2>";
echo "<p>cURL enabled: " . (function_exists('curl_init') ? '✅ Yes' : '❌ No') . "</p>";
echo "<p>allow_url_fopen: " . (ini_get('allow_url_fopen') ? '✅ Yes' : '❌ No') . "</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
?>