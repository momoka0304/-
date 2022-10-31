 <!DOCTYPE html>


<?php 
//conntect to the detabase
$dsn = 'mysql:dbname=co_***_it_3919_com;host=localhost';
$user = 'co-***.it.3919.c';
$password = 'PASSWORD';
$pdo = new PDO($dsn,$user,$password);


//INCERT文
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"]) && empty($_POST["invisible"])){
    $sql = $pdo -> prepare("INSERT INTO mission5 (name,comment,date,postpass) VALUE(:name,:comment,:date,:postpass)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':postpass', $pass, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $name =  $_POST["name"] ;
    $comment = $_POST["comment"];
    $pass = $_POST["pass"];
    $date=date("Y/m/d H:i:s");
        $sql -> execute();
}


//編集したい文呼び出し
if(!empty($_POST["E_num"]) && !empty($_POST["E_pass"])){
    $E_num = $_POST["E_num"];
    $E_pass = $_POST["E_pass"];
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach($results as $row){
        $id = $row['id'];
        $pass = $row['postpass'];
        if($E_num == $id && $E_pass == $pass){
            $E_name = $row['name'];
            $E_comment = $row['comment'];
            
            
        }
    }
}


//UPDATE文
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"]) && !empty($_POST["invisible"])){
 
   
    
    $id = $_POST["invisible"]; //変更する投稿番号
    $name = $_POST["name"];
    $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
    $pass = $_POST["pass"];
    $sql = 'UPDATE mission5 SET name=:name,comment=:comment,postpass=:postpass WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':postpass', $pass, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    $stmt->execute();
}

// DELETE文
if(!empty($_POST["D_num"]) && !empty($_POST["D_pass"])){
    $D_num = $_POST["D_num"];
    $D_pass = $_POST["D_pass"];
   
    $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach($results as $row){
        $id = $row["id"];
        $pass = $row["postpass"];
        
        if($D_num == $id && $D_pass == $pass){
            
            $sql = 'delete from mission5 where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $D_num, PDO::PARAM_INT);
            $stmt->execute();
        }
    }    
}
?>

<html lang="ja">
<head>
<meta charset=UTF8>
<title>mission5-1</title>
</head>
<body>
    <p>この掲示板のテーマ＜好きなお菓子＞</p>
    <form action="" method="post" >
        【投稿フォーム】<br>
        name<br>
        <input type="text" name="name" value=<?php if(isset($E_name)){echo $E_name;} ?> > <br>
        comment<br>
        <input type="text" name="comment" value=<?php if(isset($E_comment)){echo $E_comment;} ?> > <br>
        password<br>
        <input type="text" name="pass" value=<?php if(isset($E_name)){echo $E_pass;}?>> <br>
        <input type="submit" name="submit"><br>
        【削除フォーム】<br>
        <input type="text" name="D_num" placeholder="削除対象番号"><br>
        <input type="text" name="D_pass" placeholder="PASSWORD"><br>
        <input type="submit" name="delete" value="削除"><br>
        【編集フォーム】<br>
        <input type="text" name="E_num" placeholder="編集対象番号"> <br>
        <input type="text" name="E_pass" placeholder="PASSWORD"> <br>
        <input type="hidden" name="invisible" value=<?php if(isset($E_name)){echo $E_num;} ?>> <br>
        <input type="submit" name="edit" value="編集"> <br>
        
    
    </form>
</body>

<?php

//表示用
 $sql = 'SELECT * FROM mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].',';
        echo $row['postpass'].'<br>';
    echo "<hr>";
    }



?>