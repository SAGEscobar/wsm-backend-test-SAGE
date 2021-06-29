<?php


  function getAll(&$connection){
    $accountsData = $connection->selectDatabase('demo-db')->Accounts->aggregate([
      ['$match'=> ["status"=> 'ACTIVE']],
      ['$addFields'=> [
        'temp'=>[[ 'clicks'=> 0, 'spend'=> 0, 'impressions'=> 0, 'costPerClick'=>0]]
      ]],
      ['$lookup'=> [  // Join Metrics collection to the query by matching the accountId
         'from'=> "Metrics",
         'let'=> [ 'acct'=> '$accountId' ],
         'pipeline'=> [
                [ '$match'=>[ '$expr'=> ['$eq' => ['$accountId', '$$acct']] ]],
                [ '$project'=> [ // if some field don't exist, will be set to 0
                      "clicks"=> ['$ifNull'=> ['$clicks', 0]],
                      "spend"=> ['$ifNull'=> ['$spend', 0]],
                      "impressions"=> ['$ifNull'=> ['$impressions', 0]], 
                 ]],
                 // Verify if clicks exists, if exist divide the fields, else, set the new field to 0
                 ['$addFields'=> ["costPerClick"=> ['$cond'=> [ 'if'=> [ '$lt'=> [ '$clicks', 1 ] ], 'then'=> 0, 'else'=> ['$divide'=> ['$spend', '$clicks']]]]]],
                 ['$group'=> 
                 [
                  '_id'=> '$$acct',
                  'clicks'=> ['$sum'=> '$clicks'],
                  'spend'=> ['$sum'=> '$spend'],
                  'impressions'=> ['$sum'=> '$impressions'],
                  'costPerClick'=> ['$sum'=> '$costPerClick'],
                 ]]
             ],
         'as'=> "mrt",
       ]],
       ['$project'=> [
        'accountName'=> '$accountName',
        'accountId'=> '$accountId',
        'temp'=>'$temp',
        'temp2'=> ['$arrayElemAt'=> [ '$mrt', -1 ] ],
       ]],
       ['$project'=> [
        'accountName'=> '$accountName',
        'accountId'=> '$accountId',
        'Metrics'=> ['$ifNull'=> ['$temp2', ['$arrayElemAt'=> [ '$temp', -1 ] ]] ],
       ]],
      
       
    ]);
    return $accountsData;
}

  function getAccountsMetrics(&$connection, $account){
    $accountData = $connection->selectDatabase('demo-db')->Accounts->aggregate([
      ['$match'=> ["accountId"=> $account]],
      ['$addFields'=> [
        'temp'=>[[ 'clicks'=> 0, 'spend'=> 0, 'impressions'=> 0, 'costPerClick'=>0]]
      ]],
      ['$lookup'=> [
         'from'=> "Metrics",
         'pipeline'=> [
                [ '$match'=>["accountId"=> $account ]],
                [ '$project'=> [ 
                      "clicks"=> ['$ifNull'=> ['$clicks', 0]],
                      "spend"=> ['$ifNull'=> ['$spend', 0]],
                      "impressions"=> ['$ifNull'=> ['$impressions', 0]], 
                 ]],
                 ['$addFields'=> 
                    ["costPerClick"=> 
                        ['$cond'=> 
                            [ 'if'=> [ '$lt'=> [ '$clicks', 1 ] ], 'then'=> 0, 'else'=> ['$divide'=> ['$spend', '$clicks']] ]]]],
                            ['$group'=> [
                              '_id'=> $account,
                              'clicks'=> ['$sum'=> '$clicks'],
                              'spend'=> ['$sum'=> '$spend'],
                              'impressions'=> ['$sum'=> '$impressions'],
                              'costPerClick'=> ['$sum'=> '$costPerClick'],
                             ]]
             ],
         'as'=> "mrm"
       ]],
       ['$project'=> [
        'accountName'=> '$accountName',
        'accountId'=> '$accountId',
        'temp'=>'$temp',
        'temp2'=> ['$arrayElemAt'=> [ '$mrt', -1 ] ],
       ]],
       ['$project'=> [
        'accountName'=> '$accountName',
        'accountId'=> '$accountId',
        'Metrics'=> ['$ifNull'=> ['$temp2', ['$arrayElemAt'=> [ '$temp', -1 ] ]] ],
       ]],
      ]);


    return $accountData;
  }