<?php

function connect(){

  // Set environment variable MONGO_DATABASE with your url connection

  $urlConnection = $_SERVER['MONGO_DATABASE'];
  try {
    $data = new MongoDB\Client($urlConnection);
    return array($data, null);
  } catch (MongoDB\Driver\Exception $e) {
    return array(null, $e);
  }
}