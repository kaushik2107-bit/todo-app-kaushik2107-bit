<?php

$server = "localhost";
$username = "kaushik";
$password = "1234";

$conn = new mysqli($server, $username, $password);
if ($conn->connect_errno) {
  echo "<script>
  alert('There is some problem. Come back later')
  </script>";
}





?>
