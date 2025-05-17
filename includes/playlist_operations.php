<?php

require 'db.php';

$action = $_POST['action'] ?? '';

if ($action == 'create') {
    $name = trim($_POST['playlist_name'] ?? '');
    if (!empty($name)) {
        $stmt = $pdo->prepare('INSERT INTO playlists (name) VALUES (?)');
        $stmt->execute([$name]);
    }
} elseif ($action == 'remove') {
    $playlist_id = $_POST['playlist_id'] ?? '';

    $stmt = $pdo->prepare('DELETE FROM playlists WHERE id = ?');
    $stmt->execute([$playlist_id]);
}

header("Location:../index.php");
exit();