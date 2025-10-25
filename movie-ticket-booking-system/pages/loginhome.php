<?php
require_once 'db.php';
if(empty($_SESSION['user'])){ header('Location: login.php'); exit; }
?>
<!doctype html><html><body>
<h1>Welcome, <?=htmlspecialchars($_SESSION['user']['name'])?></h1>
<p><a href="homepage2.php">Browse Movies</a></p>
</body></html>
