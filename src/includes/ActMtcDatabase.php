<?php

include_once dirname(__DIR__).'\src\lib\db_connection.php';
include_once dirname(__DIR__).'\src\lib\functions.php';

function getAccount($account){
  $response = [];
  
  try{
    list($data, $error) = $data = connect();
    $response = getAccountsMetrics($data, $account);
  }catch(Exception $e){
    $response = array(
      'error'=> $e->getMessage()
    );
    return $response;
  }
  return $response;
}

function getData($filter){
  $response = [];
  
  try{
    list($data, $error) = $data = connect();
    $response = getAll($data, $filter);
  }catch(Exception $e){
    $response = array(
      'error'=> $e->getMessage()
    );
    return $response;
  }
  
  return $response;
}