<?php

// src/Controller/ProductController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use MongoDB;

class ReportsController extends AbstractController
{
    public function index()
    {
        return $this->render('tableScreen.html.twig', []);
        
    }
}
