<?php

if($_SERVER["REQUEST_METHOD"] != "POST") {
  header('Location: https:/google.co.jp');
  exit;
}

$LOG_FILE   = dirname(__FILE__).'/hook.log';
$SECRET_KEY = 'test.iprimo';
$header     = getallheaders();
$post_data  = file_get_contents('php://input');
$hmac       = hash_hmac('sha1', $post_data, $SECRET_KEY);

if (isset($header['X-Hub-Signature']) && $header['X-Hub-Signature'] === 'sha1='.$hmac) {
  $payload = json_decode($post_data, true);
  if ($payload['ref'] == 'refs/heads/master') {
    exec('git pull', $output, $return_var);
    file_put_contents($LOG_FILE, date("[Y-m-d H:i:s]")." ".$payload['ref']." git pulled: ".$payload['after']." ".$payload['commits'][0]['message']. " / " . $return_var . " : " .implode("/", $output) . "\n", FILE_APPEND|LOCK_EX);
  }
}
