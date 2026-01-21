<?php

// Simple database check for Amadeus provider
try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=milestour', 'root', '');

    $stmt = $pdo->query('SELECT * FROM providers WHERE name="Amadeus" AND type="hotels"');
    $provider = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($provider) {
        echo "Current Amadeus provider configuration:\n";
        echo "ID: {$provider['id']}\n";
        echo "Name: {$provider['name']}\n";
        echo "Type: {$provider['type']}\n";
        echo "Endpoint: {$provider['endpoint']}\n";
        echo "Is Active: {$provider['is_active']}\n";
        echo "API Key set: " . (!empty($provider['api_key']) ? 'Yes' : 'No') . "\n";
        echo "API Secret set: " . (!empty($provider['api_secret']) ? 'Yes' : 'No') . "\n";

        // Test DNS resolution
        $testUrl = rtrim($provider['endpoint'], '/') . '/v1/security/oauth2/token';
        echo "\nTesting DNS resolution for: {$testUrl}\n";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $testUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD request only

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            echo "❌ DNS/Network error: {$error}\n";

            // Try alternative endpoints
            echo "\nTrying alternative endpoints:\n";
            $alternatives = [
                'https://test.api.amadeus.com',
                'https://api.amadeus.com'
            ];

            foreach ($alternatives as $altUrl) {
                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $altUrl . '/v1/security/oauth2/token');
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch2, CURLOPT_NOBODY, true);

                curl_exec($ch2);
                $altError = curl_error($ch2);
                curl_close($ch2);

                if (!$altError) {
                    echo "✅ Alternative works: {$altUrl}\n";
                    echo "💡 Suggested fix: UPDATE providers SET endpoint='{$altUrl}' WHERE name='Amadeus' AND type='hotels';\n";
                } else {
                    echo "❌ {$altUrl} also fails: {$altError}\n";
                }
            }
        } else {
            echo "✅ DNS resolution successful (HTTP {$httpCode})\n";
        }

    } else {
        echo "Amadeus provider not found in database\n";
    }

} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}