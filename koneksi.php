<?php

$DB_HOST =  "127.0.0.1";
$DB_DATABASE = "sekolah";
$DB_USERNAME = "root";
$DB_PASSWORD = "";
$DB_PORT = "3306";

$conn = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE, $DB_PORT);

if($conn->connect_error) {
	die('koneksi gagal:' .$conn->connect_error);
}

