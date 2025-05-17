<?php

require 'db.php';

$song_id = intval($_GET['id'] ?? null);
if (!$song_id) {
    exit('Invalid Request');
}

$stmt = $pdo->prepare('SELECT file_path FROM songs WHERE id = ?');
$stmt->execute([$song_id]);
$song = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$song) {
    exit('Song not found');
}

$file_path = $song['file_path'];
if (!file_exists($file_path)) {
    http_response_code(404);
    exit('File not found');
}

$extension = pathinfo($file_path, PATHINFO_EXTENSION);
$content_types = [
    'mp3' => 'audio/mpeg',
    'wav' => 'audio/wav'
];
if (!isset($content_types[$extension])) {
    http_response_code(415);
    exit('Unsupported media type');
}

header("X-Sendfile: " . $file_path);
header("Content-Type: " . $content_types[$extension]);
header("Accept-Ranges: bytes");

exit();