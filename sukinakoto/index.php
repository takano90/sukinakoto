<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $contents = $_POST["contents"];
    
    if (empty($name)) {
        $errors[] = "名前を入力してください";
    }
    if (empty($contents)) {
        $errors[] = "投稿内容を入力してください";
    }
    
    if (empty($errors)) {
        date_default_timezone_set('Asia/Tokyo');
        $created_at = date("Y-m-d H:i:s");
        
        // DB接続
        $pdo = new PDO(
            "mysql:dbname=sample;host=localhost;charset=utf8mb4",
            "root",
            "",
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
        );
        
        // エラー処理
        if ($pdo) {
            echo "DB接続成功<br>";
        } else {
            echo "DB接続失敗<br>";
            exit; // 接続失敗時は処理を停止
        }
        
        // SQL実行
        $stmt = $pdo->prepare("INSERT INTO post(name, contents, created_at) VALUES (?, ?, ?)");
        $stmt->execute([$name, $contents, $created_at]);
        
        if ($stmt) {
            echo "登録成功<br>";
        } else {
            echo "登録失敗<br>";
            exit; // 登録失敗時は処理を停止
        }
    }
}

// DB接続
$pdo = new PDO(
    "mysql:dbname=sample;host=localhost;charset=utf8mb4",
    "root",
    "",
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
);

// エラー処理
if ($pdo) {
    echo "DB接続成功<br>";
} else {
    echo "DB接続失敗<br>";
    exit; // 接続失敗時は処理を停止
}

// SQL実行
$stmt = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT 20");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<title>掲示板サンプル</title>
<h1>掲示板サンプル</h1>
<section>
    <h2>新規投稿</h2>
    <div id="error"><?php foreach($errors as $error) echo $error . "<br>"; ?></div>
    <form action="index.php" method="post">
        名前 : <input type="text" name="name" value=""><br>
        投稿内容: <input type="text" name="contents" value=""><br>
        <button type="submit">投稿</button>
    </form>
</section>

<!-- 追記２ここから -->
<section>
	<h2>投稿内容一覧</h2>
	<?php foreach ($rows as $row): ?>
		<div>No：<?php echo $row['id'] ?></div>
		<div>名前：<?php echo $row['name'] ?></div>
		<div>投稿内容：<?php echo $row['contents'] ?></div>
		<div>投稿時間：<?php echo $row['created_at'] ?></div>
		<div>------------------------------------------</div>
	<?php endforeach; ?>
</section>
<!-- 追記２ここまで -->