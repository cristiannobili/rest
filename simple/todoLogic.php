<?php
require_once("dbaccess.php");

class Todos {

   private $db;
   private $list;

   function __construct() {
      
      
   }

   public function getAll() {
      $db = new DbAccess();
      $this->list = $db->select(); 
      return $this->list;   
   }

   public function deleteOne($id) {
      $db = new DbAccess();
      $result = $db->delete($id);
      if ($result) {
         $this->list = $db->select();
         return true;
      } else {
         return false;
      }
   }

   public function completeOne($id) {
      $db = new DbAccess();
      $result = $db->update($id);
      if ($result > 0) {
         $this->list = $db->select();
         return true;
      } else {
         return false;
      }
   }

   public function createOne($todo) {
      $db = new DbAccess();
      $result = $db->create($todo['title'], $todo['date']);
      return $result;
   }

}