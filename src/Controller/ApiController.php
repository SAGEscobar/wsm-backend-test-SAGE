<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

include_once dirname(__DIR__).'\src\includes\ActMtcDatabase.php';
/**
 * @Route("/api", name="posts.")
*/
class ApiController extends AbstractController
{
      /**
     * @Route("/", name="get")
     */
    public function show(){
        $response = [];
        if(isset($_GET['filter'])){
          $data = getData($_GET['filter']);
          $i = 0;
          foreach($data as $key => $value){
            $response[$i] = $value;
            $i++;
          }
          if(count($response)==0){
            $response = array('message'=>'No data was found');
            return $this->json($response, 404);
          }
        }else{
          $response = array('error'=>$_GET);
        }

        return $this->json($response);
        
    }

    public function get_Account(){
      $response = [];
      if(isset($_GET['account'])){
        $data = getAccount($_GET['account']);
        $i = 0;
        foreach($data as $key => $value){
          $response[$i] = $value;
          $i++;
        }
        if(count($response)==0){
          $response = array('message'=>'No data was found');
          return $this->json($response, 404);
        }
      }else{
        $response = array('error'=>'No data to process');
      }

      return $this->json($response);
      
  }
}