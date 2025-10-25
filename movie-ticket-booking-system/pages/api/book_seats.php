<?php
require_once __DIR__ . '/../db.php';
$input = json_decode(file_get_contents('php://input'), true);
$show_id = intval($input['show_id'] ?? 0);
$seats = $input['seats'] ?? [];
$user_id = $_SESSION['user']['id'] ?? null;
if(!$show_id || empty($seats)) { echo json_encode(['success'=>false,'message'=>'invalid data']); exit; }
$stmt = $pdo->prepare('SELECT seats FROM bookings WHERE show_timing_id = ?');
$stmt->execute([$show_id]);
$already = [];
while($r = $stmt->fetchColumn()){
  $arr = json_decode($r, true);
  if(is_array($arr)) $already = array_merge($already, $arr);
}
foreach($seats as $s){ if(in_array($s, $already)){ echo json_encode(['success'=>false,'message'=>'seat '.$s.' already booked']); exit; } }
$total_price = count($seats) * 150;
$pdo->prepare('INSERT INTO bookings (user_id, movie_id, show_timing_id, seats, total_price) VALUES (?, ?, ?, ?, ?)')
    ->execute([$user_id, 0, $show_id, json_encode($seats), $total_price]);
echo json_encode(['success'=>true]);
