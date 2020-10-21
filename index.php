<?php
	session_start();
	if(!isset($_SESSION['username'])) {
	   header('location:login.php'); 
	} else { 
	   $username = $_SESSION['username']; 
	}
	session_destroy();
?>

<title>Halaman Masuk Login</title>
<div align="center">
	<h1>Selamat datang di halaman website <?php echo $username; ?> </h1>
	<p>Klik <a href="logout.php"> disini </a> untuk logout</p>
</div>