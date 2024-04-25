<?php
require_once "send.php";
$regist = getPostData();
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>掲示板サンプル</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<h1>掲示板サンプル</h1>
<section>
    <h2>新規投稿</h2>
    <div id="error"></div>
    名前 : <input type="text" name="name" value="" id="name"><br>
    投稿内容: <input type="text" name="contents" value="" id="contents"><br>
    <button type="submit" id="send">投稿</button>
</section>

<section>
	<h2>投稿内容一覧</h2>
        <div id="post-data">
            <?php foreach($regist as $loop):?>
                <div>No：<?php echo $loop['id']?></div>
                <div>名前：<?php echo $loop['name']?></div>
                <div>投稿内容：<?php echo $loop['contents']?></div>
                <div>投稿時間：<?php echo $loop['created_at']?></div>
                <div>------------------------------------------</div>
            <?php endforeach;?>
        </div>
</section>

<script>
document.getElementById('send').onclick = function(){
    let name = $('#name').val();
    let contents = $('#contents').val();
    $.ajax({
        url: "send.php",
        type: "post",
        dataType: "text",
        data:{'name': name, 'contents': contents}
    }).done(function (response) {
        let res = JSON.parse(response);
        let html = '';
        if(!res['error']){
            res.forEach( val => {
                html += 
                    `<div>No：${val['id']}</div>
                    <div>名前：${val['name']}</div>
                    <div>投稿内容：${val['contents']}</div>
                    <div>投稿時間：${val['created_at']}</div>
                    <div>------------------------------------------</div>`;
            });
            $('#post-data').html(html);
            $('#error').html('');
            $('#name').val('');
            $('#contents').val('');
        }else{
            res['error'].forEach( val => {
                html += val + '<br>';
            });
            $('#error').html(html);
        }
    }).fail(function (xhr,textStatus,errorThrown) {
        alert('error');
    });
}
</script>