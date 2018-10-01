<?php 

$conn = pg_connect(getenv("DATABASE_URL"));


$res = pg_query($conn, "SELECT * FROM User");

echo $res;  


?>