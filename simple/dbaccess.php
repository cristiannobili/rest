<?php

class DbAccess {

   private function connect() {
      $servername = "127.0.0.1";
      $database = "todo";
      $username = "root";
      $password = "";

      $conn = mysqli_connect($servername, $username, $password, $database);

      if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      }

      return $conn;
   } 

   private function close($conn) {
      mysqli_close($conn);
   }

   public function select() {
      $sql = "select id, title, date, completed from todo";
      $conn = $this->connect();
      $result = mysqli_query($conn, $sql);
      $list= array();
      while ($row = $result->fetch_assoc()) {
         $todo = [
            'id' => $row['id'],
            'title' => $row['title'],
            'date' => $row['date'],
            'completed' => $row['completed'],
         ];
         $list[] = $todo;
      }
      $this->close($conn);
      return $list;
   }

   public function update($id) {
      $sql = "update todo set completed=1 where id='$id'";
      $conn = $this->connect();
      $result = mysqli_query($conn, $sql);
      $this->close($conn);
      return $result;
   }

   public function delete($id) {
      $sql = "delete from todo where id='$id'";
      $conn = $this->connect();
      $result = mysqli_query($conn, $sql);
      $this->close($conn);
      return $result;
   }

   public function create($title, $date) {
      $sqldate = date("Y-m-d", strtotime($date));
      $sql = "insert into todo (title, date, completed) values ('$title', '$sqldate', 0)";
      $conn = $this->connect();
      $result = mysqli_query($conn, $sql);
      $this->close($conn);
      return $result;
   }
}

?>