<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>m3-5</title>
    </head>
    <body>
        <?php
            $filename = "m3-5.txt";
            
            if(!empty($_POST["name"]) && !empty($_POST["str"]) && !empty($_POST["pass"])){
                if(!empty($_POST["now_edit_num"])){
                // 編集記入モード
                    $now_edit_num = $_POST["now_edit_num"];
                    $name = $_POST["name"];
                    $str = $_POST["str"];
                    $pass = $_POST["pass"];
                    $date = date("Y/m/d H:i:s");

                    $content = $now_edit_num."<>".$name."<>".$str."<>".$date."<>".$pass;
                    
                    $lines = file($filename,FILE_IGNORE_NEW_LINES);
                    
                    $fp = fopen($filename, "w");
                    
                    for($i = 0; $i < count($lines); $i++){
                        $line = explode("<>", $lines[$i]);
                    
        // 投稿番号の取得
                        $post_num = $line[0];

        // 投稿番号と削除対象番号が一致したら値を差し替える
                        if ($post_num == $now_edit_num){
                            fwrite($fp,$content.PHP_EOL);
                        } else {
                  //一致しなかったところはそのまま書き込む
                            fwrite($fp,$lines[$i].PHP_EOL);
                        }
                    }fclose ($fp);
                    
                }else{
                // 投稿モード
                    $name = $_POST["name"];
                    $str = $_POST["str"];
                    $pass = $_POST["pass"];
                    $date = date("Y/m/d H:i:s");

                    if(file_exists($filename)){
                        $line = file($filename,FILE_SKIP_EMPTY_LINES);
                        $n = count($line) - 1;
                // $n=行数
                        $post_num = mb_substr($line[$n],0,1) + 1;
                // mb_substr = 文字を割り出す = (対象文字列,取得開始位置の数値, 取得する長さの数値)
                    }else{
                        $post_num = 1;
                    }
                
                    $content = $post_num."<>".$name."<>".$str."<>".$date."<>".$pass."<>";
                    $fp = fopen($filename, "a");
                    fwrite ($fp, $content.PHP_EOL);
                    fclose ($fp);
                }
            // 投稿削除
            }elseif(!empty($_POST["delete_num"])){
                $delete_num = $_POST["delete_num"];
                $delete_pass = $_POST["delete_pass"];
                
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                
                $fp_d = fopen($filename, "w");
                for($i = 0; $i < count($lines); $i++){
                    $line = explode("<>", $lines[$i]);
                    
        // 投稿番号の取得
                    $post_num = $line[0];
                    $pass = $line[4];

        // 投稿番号と削除対象番号が一致しない場合、書き込む
                    if ($post_num != $delete_num){
                        fwrite($fp_d, $lines[$i].PHP_EOL);
                    }elseif($pass != $delete_pass){
                        fwrite($fp_d, $lines[$i].PHP_EOL);
                    }
                }
                fclose ($fp_d);
                // }
                
            // 編集選択モード
            }elseif(!empty($_POST["edit_num"])){
                $name = $_POST["name"];
                $str = $_POST["str"];
                // $date = date("Y/m/d H:i:s");
                $edit_num = $_POST["edit_num"];
                $edit_pass = $_POST["edit_pass"];
                
                $lines = file($filename,FILE_IGNORE_NEW_LINES);
                $fp_e = fopen($filename, "w");
                for($i = 0; $i < count($lines); $i++){
                    $line = explode("<>", $lines[$i]);
                    
                    $post_num = $line[0];
                    $pass = $line[4];
                    
                    if ($post_num == $edit_num && $pass == $edit_pass){
                            $name_get = $line[1];
                            $str_get = $line[2];
                        
                        // $name_get = $line[1];
                        // $str_get = $line[2];
                    }
                    
                    fwrite($fp_e, $lines[$i].PHP_EOL);
                }
                fclose($fp_e);
            }
        ?>
        
        <p>この掲示板のテーマ「好きなお菓子」</p>
        <form action = "" method = "post">
            <input type = "text" name = "name" placeholder = "名前" value="<?php if(isset($name_get)){echo $name_get;} ?>"><br/>
            <input type = "text" name = "str" placeholder = "コメント" value="<?php if(isset($name_get)){echo $str_get;} ?>"><br/>
            <input type = "text" name = "pass" placeholder = "パスワード"><br/>
            <input type = "submit" name = "submit" value = "送信"><br/>
            <input type = "text" name = "delete_num" placeholder = "削除対象番号"><br/>
            <input type = "text" name = "delete_pass" placeholder = "パスワード"><br/>
            <input type = "submit" name = "delete_btn" value ="削除"><br/>
            <input type = "text" name = "edit_num" placeholder = "編集対象番号"><br/>
            <input type = "text" name = "edit_pass" placeholder = "パスワード"><br/>
            <input type = "submit" name = "edit_btn" value ="編集"><br/>
            <input type = "hidden" name="now_edit_num" placeholder = "編集中番号" value="<?php if(isset($edit_num)){echo $edit_num;} ?>"><br/>
        </form>
            
       
    </body>
</html>

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