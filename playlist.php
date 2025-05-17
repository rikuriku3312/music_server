<?php

require 'includes/db.php';

$playlist_id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM playlists WHERE id = ?');
$stmt->execute([$playlist_id]);
$playlist = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT songs.id, songs.title, songs.file_path FROM songs, playlist_songs 
                       WHERE songs.id = playlist_songs.song_id AND playlist_songs.playlist_id = ?');
$stmt->execute([$playlist_id]);
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query('SELECT * FROM songs');
$all_songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $playlist['name'] ?> - プレイリスト</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <form method="POST" action="index.php">
            <button type="submit">⇐</button>
        </form>

        <h1><?php echo $playlist['name'] ?></h1>
        <ol>
            <?php foreach ($songs as $song) { ?>
                <li>
                    <?php echo $song['title'] ?>
                    <button class="play-button" data-id="<?php echo $song['id'] ?>" data-title="<?php echo $song['title'] ?>">▶</button>
                    <form method="POST" action="includes/music_operations.php">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="playlist_id" value="<?php echo $playlist_id ?>">
                        <input type="hidden" name="song_id" value="<?php echo $song['id'] ?>">
                        <button type="submit">×</button>
                    </form>
                </li>
            <?php } ?>
        </ol>
        <p>曲を追加</p>
        <form method="POST" action="includes/music_operations.php">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="playlist_id" value="<?php echo $playlist_id ?>">
            <select name="song_id">
                <?php foreach($all_songs as $song) { ?>
                    <option value="<?php echo $song['id']?>"><?php echo $song['title'] ?></option>
                <?php } ?>
            </select>
            <button type="submit">追加</button>
        </form>

        <div class="audio-player">
            <audio src=""></audio>
            <span class="track-title">曲のタイトル</span>
            <div class="controls">
                <button class="play-toggle">||</button>
                <button class="skip">⏭</button>
                <button class="loop">ONE</button>
            </div>
            <div class="progress">
                <span class="elapsed-time"></span>
                <input type="range" name="seekbar" min="0" max="100" value="0" step=".1">
                <span class="duration"></span>
            </div>
        </div>

        <script src="js/music.js"></script>
    </body>
</html>