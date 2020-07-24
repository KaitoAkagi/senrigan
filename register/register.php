<?php
        require "../dbconnect.php";

        session_start();

        if (isset($_POST['register'])) {
            // 未入力のデータがない場合
            if ((!empty($_POST["name"])&&(!empty($_POST["email"]))&&(!empty($_POST["password"])))) {
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
                // // パスワードをハッシュ値に変換してデータベースに保存
                // if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
                // } else {
                //     return false;
                // }
                
                // 同じ名前のユーザーがいるか判定
                $stmt = exeSQL("SELECT name FROM user_table WHERE name='".$name."'");
                
                // 同じ名前のユーザーがいたらエラーメッセージ表示
                if ($stmt->fetch(PDO::FETCH_BOTH)) {
                  printf("<script>window.onload = function() {
                    alert('同じ名前のユーザーがすでに存在します');
                  }</script>");
                } else {

                  // テーブル"user_table"に名前・e-mail・パスワードを追加
                  $stmt = exeSQL("INSERT INTO user_table (name,email,password) values ('".$name."','".$email."','".$password."')");
                  
                  $_SESSION['name'] = $name;

                  print($name);
                  print($email);
                  print($password);

                  header("location: ../home");
                }
            }
        }
      ?>