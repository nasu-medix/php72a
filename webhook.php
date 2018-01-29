<?php

if($_SERVER["REQUEST_METHOD"] != "POST") {
  header('Location: https:/google.co.jp');
  exit;
}

$SECRET_KEY = 'test.iprimo';
$header     = getallheaders();
$hmac       = hash_hmac('sha1', $post_data, $SECRET_KEY);

if (isset($header['X-Hub-Signature']) && $header['X-Hub-Signature'] === 'sha1='.$hmac) {
  exec('git pull');
}
