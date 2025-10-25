<?php
require_once 'db.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $email = $_POST['email'] ?? '';
  $pass = $_POST['password'] ?? '';
  $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
  $stmt->execute([$email]);
  $u = $stmt->fetch();
  if($u && password_verify($pass, $u['password'])){
    $_SESSION['user'] = ['id'=>$u['id'],'email'=>$u['email'],'name'=>$u['name']];
    header('Location: loginhome.php'); exit;
  } else {
    $error = 'Invalid credentials';
  }
}
?>
<!doctype html><html><body>
<h1>Login</h1>
<?php if(!empty($error)) echo '<p style="color:red;">'.htmlspecialchars($error).'</p>'; ?>
<form method="post">
  <input name="email" placeholder="Email"><br>
  <input name="password" type="password" placeholder="Password"><br>
  <button>Login</button>
</form>
</body></html>
