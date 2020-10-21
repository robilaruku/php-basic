<?php
   session_start();
   if(isset($_SESSION['username'])) {
   header('location:list_student.php'); }
   require_once("database.php");
?>

<title>Halaman Login</title>
<div align="center">
	<form action="proseslogin.php" method="POST">
		<h1>Login</h1>
		<table>
			<tbody>
				<tr>
					<td>username </td>
					<td>: <input type="text" name="username"></td>
				</tr>
				<tr>
					<td>Password </td>
					<td>: <input type="password" name="password"></td>
				</tr>
				<tr>
					<td colspan="2" align="right">
						<input type="submit" value="Login">
						<input type="reset" value="Cancel">
					</td>
				</tr>
				<tr>
					<td>
						Belum Punya Akun? <a href="daftar.php">Daftar</a>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	
</div>