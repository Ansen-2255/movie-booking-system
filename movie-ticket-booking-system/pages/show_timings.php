<?php
require_once 'db.php';
$movie_id = intval($_GET['movie_id'] ?? 0);
if(!$movie_id) exit('Invalid movie');
$stmt = $pdo->prepare('SELECT * FROM movies WHERE id = ?');
$stmt->execute([$movie_id]);
$movie = $stmt->fetch();
$stmt = $pdo->prepare('SELECT * FROM show_timings WHERE movie_id = ? AND show_date >= CURDATE() ORDER BY show_date, show_time');
$stmt->execute([$movie_id]);
$timings = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Show Timings for <?=htmlspecialchars($movie['title'])?></title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <a href="homepage2.php">← Back</a>
  <h1><?=htmlspecialchars($movie['title'])?></h1>
  <?php if(!$timings): ?>
    <p>No upcoming shows.</p>
  <?php else: ?>
    <ul>
      <?php foreach($timings as $t): ?>
        <?php $datetime = $t['show_date'] . ' ' . $t['show_time']; ?>
        <li>
          <?=htmlspecialchars($t['show_date'])?> @ <?=htmlspecialchars($t['show_time'])?>
          <a class="button" href="seat_selection.php?show_id=<?=$t['id']?>">Select Seats</a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</body>
</html>
