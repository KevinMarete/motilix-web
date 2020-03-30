<?php
  require_once('../assets/vendor/php-email-form/JSONDB.php');

  use Jajo\JSONDB;
  
  $json_db = new JSONDB(__DIR__.'/../assets/json');
  $json_file = 'interest.json';
  // $email = $_POST['email'];
  $phone = $_POST['phone'];
  $post_data = [
    // 'name' => $_POST['name'],
    // 'email' => $email,
    'phone' => $phone,
    // 'make' => $_POST['make'],
    // 'model' => $_POST['model'],
    // 'yom' => $_POST['yom'],
    'service' => $_POST['service'],
  ];
  $match_data = ['phone' => $phone];

  //Check for duplicates
  $match = $json_db->select('*')->from($json_file)->where($match_data, 'AND')->get();
  if($match)
  {
    $json_db->update($post_data)->from($json_file)->where($match_data)->trigger();
  }
  else
  {
    $json_db->insert($json_file, $post_data);
  }
  //Show response
  $interested = $json_db->select( '*' )->from($json_file)->get();
  echo json_encode(['status' => 'success', 'msg' => 'Your interest#'.sizeof($interested).' has been acknowledged!']);
?>