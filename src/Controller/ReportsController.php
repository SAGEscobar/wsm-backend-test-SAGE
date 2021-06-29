<?php

// src/Controller/ProductController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use MongoDB;

include_once dirname(__DIR__).'/src/lib/db_connection.php';
include_once dirname(__DIR__).'/src/lib/functions.php';

class ReportsController extends AbstractController
{
    public function index()
    {
        // ...

        list($data, $error) = $data = connect();
        $accounts=[];
        if ($error){
            return $this->render('tableScreen.html.twig', [
                'collection' => null,
                'error' => $error
            ]);
        }
        $collection = [];

        // Execute the corresponding function based on the button of submit pressed

        if(isset($_POST['submit1'])) {
            $collection = getAccountsMetrics($data, $_POST['account']);
            $i=0;
            foreach ((object)$collection as $key => $value){
                $accounts['$key']=$value;
                $i++;
            }
            if($i==0){
                return $this->render('tableScreen.html.twig', [
                    'collection' => null,
                    'error' => true
                ]);
            }
        }

        if(isset($_POST['submit2'])) {
            $collection = getAll($data);
            $accounts=$collection;
        }

        // the template path is the relative file path from `templates/`
        return $this->render('tableScreen.html.twig', [
            'collection' => $accounts,
            'error' => $error
        ]);
        
    }
}
