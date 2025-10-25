<?php
require_once 'db.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $pass = $_POST['password'] ?? '';
  if($email && $pass){
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name,email,password) VALUES (?,?,?)');
    $stmt->execute([$name,$email,$hash]);
    header('Location: login.php'); exit;
  }
}
?>
<!doctype html><html><body>
<h1>Register</h1>
<form method="post">
  <input name="name" placeholder="Name"><br>
  <input name="email" placeholder="Email"><br>
  <input name="password" type="password" placeholder="Password"><br>
  <button>Register</button>
</form>
</body></html>
