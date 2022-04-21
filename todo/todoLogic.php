<?php
require_once("dbaccess.php");

class Todos {

   private $db;

   public function getAll() {
      $db = new DbAccess();
      $list = $db->select(); 
      return $list;   
   }

   public function deleteOne($id) {
      $db = new DbAccess();
      $result = $db->delete($id);
      if ($result) {
         return true;
      } else {
         return false;
      }
   }

   public function completeOne($id) {
      $db = new DbAccess();
      $result = $db->update($id);
      if ($result > 0) {
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