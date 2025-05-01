<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "health_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'web';
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>