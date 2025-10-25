<?php
require_once __DIR__ . '/../db.php';

$q = $_GET['q'] ?? '';
$sql = "SELECT id, title, genre, poster, duration FROM movies";
$params = [];
if($q){
    $sql .= " WHERE title LIKE :q OR genre LIKE :q";
    $params[':q'] = "%$q%";
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$movies = $stmt->fetchAll();
header('Content-Type: application/json');
echo json_encode($movies);
