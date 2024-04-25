<?php
$errors = [];

if ($_POST) {
    $id = null;
    $name = $_POST["name"];
    $contents = $_POST["contents"];
    if (!$name) {
        $errors[] = "名前を入力してください";
    }
    if (!$contents) {
        $errors[] = "投稿内容を入力してください";
    }
    if (!$errors) {
        date_default_timezone_set('Asia/Tokyo');
        $created_at = date("Y-m-d H:i:s");
        //DB接続情報を設定します。
        $pdo = new PDO(
            "mysql:dbname=sample;host=localhost", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
        );
        //SQLを実行。
        $regist = $pdo->prepare("INSERT INTO post(id, name, contents, created_at) VALUES (:id,:name,:contents,:created_at)");
        $regist->bindParam(":id", $id);
        $regist->bindParam(":name", $name);
        $regist->bindParam(":contents", $contents);
        $regist->bindParam(":created_at", $created_at);
        $regist->execute();

        $res = [];
        $post_data = getPostData();
        $cnt = 0;
        foreach ($post_data as $loop) {
            $res[$cnt]['id'] = $loop['id'];
            $res[$cnt]['name'] = $loop['name'];
            $res[$cnt]['contents'] = $loop['contents'];
            $res[$cnt]['created_at'] = $loop['created_at'];
            $cnt++;
        }
        echo json_encode($res);
    } else {
        echo json_encode(['error' => $errors]);
    }
}

function getPostData()
{
    //DB接続情報を設定します。
    $pdo = new PDO(
        "mysql:dbname=sample;host=localhost", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
    );
    //SQLを実行。
    $regist = $pdo->prepare("SELECT * FROM post order by created_at DESC limit 20");
    $regist->execute();
    return $regist;
}