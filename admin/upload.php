<?php

require '../includes/db.php';

$file = $_FILES['music_file'];
$title = trim($_POST['music_title'] ?? '');

$filename = basename($file['name']);
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowedExt = ['mp3', 'wav'];

$path = "/var/www/html/music_server/music_files/" . $filename;

if (!in_array($ext, $allowedExt)) {
    echo "拡張子エラー";
    exit();
}

if (is_uploaded_file($file['tmp_name'])) {
    if (move_uploaded_file($file['tmp_name'], $path)) {
        $stmt = $pdo->prepare('INSERT INTO songs (title, file_path) VALUES (?, ?)');
        $stmt->execute([$title, $path]);
    } else {
        echo "ファイルの移動に失敗";
    }
} else {
    echo "アップロードエラー";
}

exit();