<?php

require 'db.php';

$action = $_POST['action'] ?? '';

if ($action == 'add') {
    $playlist_id = $_POST['playlist_id'];
    $song_id = $_POST['song_id'];
    
    $stmt = $pdo->prepare('INSERT INTO playlist_songs (playlist_id, song_id) VALUES (?, ?)');
    $stmt->execute([$playlist_id, $song_id]);
} elseif ($action == 'remove') {
    $playlist_id = $_POST['playlist_id'];
    $song_id = $_POST['song_id'];

    $stmt = $pdo->prepare('DELETE FROM playlist_songs WHERE playlist_id = ? AND song_id = ?');
    $stmt->execute([$playlist_id, $song_id]);
}

header("Location:../playlist.php?id=" . $_POST['playlist_id']);
exit();