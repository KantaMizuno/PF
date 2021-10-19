<?php
require_once('config.php');
require_once('functions.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 投票前
    
    // CSRF対策
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = sha1(uniqid(mt_rand(), true));
    }
    
} else {
    // 投票後
    if (empty($_POST['token']) || $_POST['token'] != $_SESSION['token']) {
      echo "不正な操作です！";
      exit;
  }

  // エラーチェック
  if (!in_array($_POST['answer'], array("緑谷出久", "爆豪勝己", "麗日お茶子", "轟焦凍", "切島鋭児郎", "飯田天哉", "相澤消太", "八百万百", "ホークス", "耳郎響香", "オールマイト", "上鳴電気", "真堂揺", "蛙吹梅雨", "心操人使", "エンデヴァー", "プレゼントマイク", "天喰環", "常闇踏陰", "通形ミリオ", "瀬呂範太", "障子目蔵", "ベストジーニスト", "サー・ナイトアイ", "峰田実", "発目明", "死柄木弔", "トガヒミコ", "茶毘", "オーバーホール", "トゥワイス", "オール・フォー・ワン"))) {
      $err = "キャラクターを選択してください！";
  }
  if (empty($err)) {
    $dbh = connectDb();
    $sql = "insert into answers 
            (answer, remote_addr, user_agent, answer_date, created, modified) 
            values 
            (:answer, :remote_addr, :user_agent, :answer_date, now(), now())";
    $stmt = $dbh->prepare($sql);
    $params = array(
        ":answer" => $_POST['answer'],
        ":remote_addr" => $_SERVER['REMOTE_ADDR'],
        ":user_agent" => $_SERVER['HTTP_USER_AGENT'],
        ":answer_date" => date("Y-m-d")
    );
    if ($stmt->execute($params)) {
      $msg = "投票ありがとうございました！";
  } else {
      $err = "投票は1日1回までです！";
  }
}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="ranking.css">
<meta charset="UTF-8">
    <title>投票システム</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <style>
    .selected {
        border:4px solid red;
    }
    </style>
</head>

<body>

<?php if (!empty($msg)) : ?>
<p style="color:green"><?php echo h($msg); ?></p>
<?php endif; ?>

<?php if (!empty($err)) : ?>
<p style="color:red"><?php echo h($err); ?></p>
<?php endif; ?>

<div class="header">
<div class="top"><a href="top.html">TOP</a></div>
<div class="character"><a href="character.html">character</a></div>
<div class="episode"><a href="episode.html">episode</a></div>
<div class="chat"><a href="chat.php">chat</a></div>
</div>

<div class="main">
  <h1>ヒーロービルボードチャート</h1><h3>in KCG</h3><br>
  <p>自分のお気に入りのヒーローを以下から一人選択して投票しよう！！</p>
  <p>最終的に投票数が最も多かったヒーローがオールマイトに次ぐNo.1ヒーローになります</p><br>

<form action="" method="POST">
<img  src="image/緑谷出久.png" class="candidate" data-id="緑谷出久" alt="緑谷出久">
<img  src="image/爆豪勝己.png" class="candidate" data-id="爆豪勝己" alt="爆豪勝己">
<img  src="image/麗日お茶子.png" class="candidate" data-id="麗日お茶子" alt="麗日お茶子">
<img  src="image/轟焦凍.png" class="candidate" data-id="轟焦凍" alt="轟焦凍">
<img  src="image/切島鋭児郎.png" class="candidate" data-id="切島鋭児郎" alt="切島鋭児郎">
<img  src="image/飯田天哉.png" class="candidate" data-id="飯田天哉" alt="飯田天哉">
<img  src="image/相澤消太.png" class="candidate" data-id="相澤消太" alt="相澤消太">
<img  src="image/八百万百.png" class="candidate" data-id="八百万百" alt="八百万百">
<img  src="image/ホークス.png" class="candidate" data-id="ホークス" alt="ホークス">
<img  src="image/耳郎響香.png" class="candidate" data-id="耳郎響香" alt="耳郎響香">
<img  src="image/オールマイト.png" class="candidate" data-id="オールマイト" alt="オールマイト">
<img  src="image/上鳴電気.png" class="candidate" data-id="上鳴電気" alt="上鳴電気">
<img  src="image/真堂揺.png" class="candidate" data-id="真堂揺" alt="真堂揺">
<img  src="image/蛙吹梅雨.png" class="candidate" data-id="蛙吹梅雨" alt="蛙吹梅雨">
<img  src="image/心操人使.png" class="candidate" data-id="心操人使" alt="心操人使">
<img  src="image/エンデヴァー.png" class="candidate" data-id="エンデヴァー" alt="エンデヴァー">
<img  src="image/プレゼントマイク.png" class="candidate" data-id="プレゼントマイク" alt="プレゼントマイク">
<img  src="image/天喰環.png" class="candidate" data-id="天喰環" alt="天喰環">
<img  src="image/常闇踏陰.png" class="candidate" data-id="常闇踏陰" alt="常闇踏陰">
<img  src="image/通形ミリオ.png" class="candidate" data-id="通形ミリオ" alt="通形ミリオ">
<img  src="image/瀬呂範太.png" class="candidate" data-id="瀬呂範太" alt="瀬呂範太">
<img  src="image/障子目蔵.png" class="candidate" data-id="障子目蔵" alt="障子目蔵">
<img  src="image/ベストジーニスト.png" class="candidate" data-id="ベストジーニスト" alt="ベストジーニスト">
<img  src="image/サーナイトアイ.png" class="candidate" data-id="サー・ナイトアイ" alt="サー・ナイトアイ">
<img  src="image/峰田実.png" class="candidate" data-id="峰田実" alt="峰田実">
<img  src="image/発目明.png" class="candidate" data-id="発目明" alt="発目明">
<img  src="image/死柄木弔.png" class="candidate" data-id="死柄木弔" alt="死柄木弔">
<img  src="image/トガヒミコ.png" class="candidate" data-id="トガヒミコ" alt="トガヒミコ">
<img  src="image/茶毘.png" class="candidate" data-id="茶毘" alt="茶毘">
<img  src="image/オーバーホール.png" class="candidate" data-id="オーバーホール" alt="オーバーホール">
<img  src="image/トゥワイス.png" class="candidate" data-id="トゥワイス" alt="トゥワイス">
<img  src="image/オールフォーワン.png" class="candidate"data-id="オール・フォー・ワン"  alt="オール・フォー・ワン">
</div>
<div class="sub">
<p><input type="submit" value="投票する！"></p>
<input type="hidden" id="answer" name="answer" value="">
<input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
</form>
<p><a href="result.php">結果を見る</a></p>
</div>
<script>
  $(function() {
    $('.candidate').click(function() {
        $('.candidate').removeClass('selected');
        $(this).addClass('selected');
        $('#answer').val($(this).data('id'));
    });
});
</script>
</body>
</html>