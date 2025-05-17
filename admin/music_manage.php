<?php

require '../includes/db.php';

$stmt = $pdo->query('SELECT * FROM songs');
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>音楽管理</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <form method="POST" action="../index.php">
            <button type="submit">⇐</button>
        </form>
        <h1>音楽ファイルの管理</h1>


        <h2>アップロード<h2>
        <p>音楽ファイルアップロード</p>
        <form method="POST" action="upload.php" enctype="multipart/form-data">
            <input type="text" name="music_title" placeholder="曲名を入力">
            <input type="file" name="music_file" accept="audio/*">
            <input type="submit" value="音楽ファイルアップロード">
        </form>
        <ul>
            <?php foreach ($songs as $song) { ?>
                <li>
                    <?php echo $song['title'] ?>
                    <form method="POST" action="delete.php">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="song_id" value="<?php echo $song['id'] ?>">
                        <button type="submit">×</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    </body>
</html>