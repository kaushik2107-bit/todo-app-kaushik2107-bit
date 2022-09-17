<?php

$server = "sql6.freesqldatabase.com";
$username = "sql6520365";
$password = "LCaHG13sUV";

$conn = new mysqli($server, $username, $password);
if ($conn->connect_errno) {
  echo "<script>
  alert('There is some problem. Come back later')
  </script>";
}





?>
