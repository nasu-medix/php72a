<?php

if($_SERVER["REQUEST_METHOD"] != "POST") {
  header('Location: https:/google.co.jp');
  exit;
}
$SECRET_KEY = 'test.iprimo';
$header     = getallheaders();
$post_data  = file_get_contents('php://input');
$hmac       = hash_hmac('sha1', $post_data, $SECRET_KEY);

if (isset($header['X-Hub-Signature']) && $header['X-Hub-Signature'] === 'sha1='.$hmac) {
  $payload = json_decode($post_data, true);
  if ($payload['ref'] == 'refs/heads/master') {
    exec('id 2>&1', $output, $return_var);
    var_dump($output);
    $process = proc_open("su - root -c git pull", [["pipe", "r"], ["pipe", "w"]], $pipes);
    if (is_resource($process)) {
      fwrite($pipes[0], 'password');
      $cmd_result = stream_get_contents($pipes[1]);
      fclose($pipes[0]);
      proc_close($process);
      var_dump($cmd_result);
    }
  }
}
