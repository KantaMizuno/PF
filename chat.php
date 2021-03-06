<?php

$dataFile = 'bbs.dat';

// CSRF対策

session_start();

function setToken() {
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
}

function checkToken() {
    if (empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])) {
        echo "不正なPOSTが行われました！";
        exit;
    }
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && 
    isset($_POST['message']) &&
    isset($_POST['user'])) {

    checkToken();

    $message = trim($_POST['message']);
    $user = trim($_POST['user']);

    if ($message !== '') {
        
        $user = ($user === '') ? '名無しさん' : $user;

        $message = str_replace("\t", ' ', $message);
        $user = str_replace("\t", ' ', $user);

        $postedAt = date('Y-m-d H:i:s');

        $newData = $message . "\t" . $user . "\t" . $postedAt. "\n";

        $fp = fopen($dataFile, 'a');
        fwrite($fp, $newData);
        fclose($fp);
    }
} else {
    setToken();
}

$posts = file($dataFile, FILE_IGNORE_NEW_LINES);

$posts = array_reverse($posts);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>ヒロアカ完全攻略</title>
    <link rel="stylesheet" href="chat.css">
</head>
<body>

<div class="header">
<div class="top"><a href="top.html">TOP</a></div>
<div class="episode"><a href="episode.html">episode</a></div>
<div class="ranking"><a href="ranking.php">ranking</a></div>
<div class="chat"><a href="character.html">character</a></div> 
</div>
  
<div class="main">
<div class="sub2">
<h1>簡易掲示板</h1>
    <form action="" method="post">
        message: <input type="text" name="message">
        user: <input type="text" name="user">
        <input type="submit" value="投稿">
        <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
</div>
    </form>
    <div class="sub1">
    <h2>投稿一覧（<?php echo count($posts); ?>件）</h2>
    <ul>
        <?php if (count($posts)) : ?>
            <?php foreach ($posts as $post) : ?>
            <?php list($message, $user, $postedAt) = explode("\t", $post); ?>
                <li><?php echo h($message); ?> (<?php echo h($user); ?>) - <?php echo h($postedAt); ?></li>
            <?php endforeach; ?>
        <?php else : ?>
            <li>まだ投稿はありません。</li>
        <?php endif; ?>
    </ul>
  </div>
</div>
</body>
</html>