<?php

require 'includes/db.php';

$stmt = $pdo->query('SELECT * FROM playlists');
$playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>音楽プレーヤー</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h1>プレイリスト</h1>
        <ul>
            <?php foreach ($playlists as $playlist) { ?>
                <li>
                    <a href="playlist.php?id=<?php echo $playlist['id'] ?>"><?php echo $playlist['name'] ?></a>
                    <form method="POST" action="includes/playlist_operations.php">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="playlist_id" value="<?php echo $playlist['id'] ?>">
                        <button type="submit">×</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
        <form method="POST" action="includes/playlist_operations.php">
            <input type="text" name="playlist_name" placeholder="プレイリスト名を入力">
            <input type="hidden" name="action" value="create">
            <button type="submit">作成</button>
        </form>
        <form class="admin" method="POST" action="admin/music_manage.php">
            <button type="submit">管理</button>
        </form>
    </body>
</html>