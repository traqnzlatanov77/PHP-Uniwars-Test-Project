<?php 
	session_start(); 
?>

<?php if(!$_SESSION['user_id']): ?>
	<form method="POST">
		<input name="username" />
		<input name="password" />
		<input type="submit" />
	</form>
<?php endif; ?>

<?php
mysql_connect('localhost', 'root', '9f9d4ee6');
mysql_select_db('uniwars');

if (isset($_POST['username'], $_POST['password'])) {
	$username = $_POST['username'];
	$password = md5($_POST['password']);

	$query = "SELECT id FROM players WHERE username = '$username' AND password = '$password'";
	$result = mysql_query($query);
	$user = mysql_fetch_assoc($result);

	if (empty($user)) {
		echo "Invalid details";
	} else {
		$_SESSION['user_id'] = $user['id'];
	}
}

if (isset($_SESSION['user_id'])) {
	$id = $_SESSION['user_id'];
	$query = "SELECT id, username, password FROM players WHERE id = $id";
	$result = mysql_query($query);
	$user = mysql_fetch_assoc($result);

	echo "<h1>Welcome, " . $user['username']."</h1>";
	echo "<a href='?logout=true'>Logout</a>";
}

if ($_GET['logout']) {
	session_destroy();
	header("Location: /Uniwars/");
}