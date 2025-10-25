<?php
require_once 'db.php';
$show_id = intval($_GET['show_id'] ?? 0);
if(!$show_id) exit('Invalid show');
$stmt = $pdo->prepare('SELECT st.*, m.title FROM show_timings st JOIN movies m ON st.movie_id = m.id WHERE st.id = ?');
$stmt->execute([$show_id]);
$show = $stmt->fetch();
if(!$show) exit('Show not found');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Select Seats - <?=htmlspecialchars($show['title'])?></title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <h1><?=htmlspecialchars($show['title'])?> — <?=htmlspecialchars($show['show_date'])?> <?=htmlspecialchars($show['show_time'])?></h1>
  <div id="seat-map"></div>
  <div>
    <button id="book">Book Selected Seats</button>
  </div>

  <script>
    const SHOW_ID = <?=$show['id']?>;
  </script>
  <script src="assets/js/seat.js"></script>
</body>
</html>
