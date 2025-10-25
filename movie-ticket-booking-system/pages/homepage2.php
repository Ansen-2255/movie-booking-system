<?php
require_once 'db.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Movie Booking — Home</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <header class="site-header">
    <h1>Movie Booking</h1>
    <nav>
      <?php if(!empty($_SESSION['user'])): ?>
        <a href="loginhome.php">Dashboard</a>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
      <?php endif; ?>
    </nav>
  </header>

  <main>
    <section class="search-bar">
      <input id="search" placeholder="Search by title or genre">
    </section>

    <section id="movies" class="movies-grid">
      <!-- movies populated by JS fetching pages/api/get_movies.php -->
    </section>
  </main>

  <script src="assets/js/main.js"></script>
</body>
</html>
