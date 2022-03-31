<?php
require_once("todoLogic.php");

/*
URL endpoints:

[GET] ./restmiddleware.php -> GET all todo
[POST] ./restmiddleware.php -> POST a new TODO
[PUT] ./restmiddleware.php -> PUT (modify) an existing TODO
[DELETE] ./restmiddleware.php/?id=$id -> DELETE an existing TODO
*/

class RestService {

   private $httpVersion = "HTTP/1.1";

   private function setHttpHeaders($contentType, $statusCode){
		http_response_code($statusCode);		
		header("Content-Type:". $contentType);
	}

   public function encodeJson($responseData) {
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}

   public function returnOk() {
      $this->setHttpHeaders("application/json", 200);
      echo "{\"result\": \"ok\"}";
   }

   public function returnKO($statusCode) {
      $this->setHttpHeaders("application/json", $statusCode);
      echo "{\"result\": \"ko\"}";
   }

   public function parseRequest() {
      try {
         $todos = new Todos();
         switch($_SERVER['REQUEST_METHOD']) {
            case 'GET': {
               
               $result = $todos->getAll();
               $this->setHttpHeaders("application/json", 200);
               $jsonResponse = $this->encodeJson($result);
               echo $jsonResponse;
            }
            break;
            case 'POST': {
               $data = json_decode(file_get_contents('php://input'), true);
               if (array_key_exists("title",$data) && array_key_exists("date",$data) && array_key_exists("completed",$data)) {
                  $result = $todos->createOne($data);
                  if ($result) {
                     $this->returnOk();
                  } else {
                     $this->returnKO(400);
                  }
               }
            }
            break;
            case 'PUT': {
               $data = json_decode(file_get_contents('php://input'), true);
               if (array_key_exists("id",$data)) {
                  $id=$data["id"];
                  $result = $todos->completeOne($id);
                  if ($result) {
                     $this->returnOk();
                  } else {
                     $this->returnKO(400);
                  }
               }
            }
            break;
            case 'DELETE': {
               if(isset($_GET["id"])) {
                  $result = $todos->deleteOne($_GET["id"]);
                  if ($result) {
                     $this->returnOk();
                  } else {
                     $this->returnKO(400);
                  }
               }
            }
            break;
         } 
      } catch (Exception $e) {
         echo $e->getMessage();
      }
      
   }

}

$restService = new RestService();
$restService->parseRequest();
