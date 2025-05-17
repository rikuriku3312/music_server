<?php

require '../includes/db.php';

$song_id = $_POST['song_id'] ?? '';

$stmt = $pdo->prepare('DELETE FROM songs WHERE id = ?');
$stmt->execute([$song_id]);

header("Location:../music_manage.php");
exit();