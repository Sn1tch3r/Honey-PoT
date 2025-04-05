<?php
$log_file = 'honeypot_logs.txt';
$redirect_url = 'https://example.com'; 
$secret_param = 'admin'; 
$log_data = array(
    'timestamp' => date('Y-m-d H:i:s'),
    'ip_address' => $_SERVER['REMOTE_ADDR'],
    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
    'request_method' => $_SERVER['REQUEST_METHOD'],
    'request_uri' => $_SERVER['REQUEST_URI'],
    'query_string' => $_SERVER['QUERY_STRING'],
    'referrer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
    'post_data' => file_get_contents('php://input'),
    'headers' => getallheaders()
);

if(isset($_GET[$secret_param]) || isset($_POST[$secret_param])) {
    $log_data['honeypot_triggered'] = true;
}

$log_entry = json_encode($log_data, JSON_PRETTY_PRINT) . "\n\n";
file_put_contents($log_file, $log_entry, FILE_APPEND);

header("Location: $redirect_url");
exit();
?>

