<?php
require_once __DIR__ . '/../db.php';
$show_id = intval($_GET['show_id'] ?? 0);
if(!$show_id) { echo json_encode(['error'=>'no show specified']); exit; }
$stmt = $pdo->prepare('SELECT seats_layout FROM show_timings WHERE id = ?');
$stmt->execute([$show_id]);
$layout = $stmt->fetchColumn();
$rows = 6; $cols = 10; $booked = [];
if($layout){
  $layout = json_decode($layout, true);
  $rows = $layout['rows'] ?? $rows;
  $cols = $layout['cols'] ?? $cols;
}
$stmt = $pdo->prepare('SELECT seats FROM bookings WHERE show_timing_id = ?');
$stmt->execute([$show_id]);
while($r = $stmt->fetchColumn()){
  $s = json_decode($r, true);
  if(is_array($s)) foreach($s as $seat) $booked[] = $seat;
}
header('Content-Type: application/json');
echo json_encode(['rows'=>$rows,'cols'=>$cols,'booked'=>$booked]);
