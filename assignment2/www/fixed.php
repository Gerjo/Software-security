<?php

session_name("fixed-session");
session_start();

// Seeding ought to be done better, but for all intents and purposes, this works.
define("CSRF_TOKEN", md5($_SERVER['REMOTE_ADDR'] . "jfoegpiewjg" .  $_SERVER['HTTP_USER_AGENT']));

?>
<html>
    <head>
        <script>
            // First hit on google "javascript set cookie function":
            function setCookie(c_name,value){
                exdays = 10;
                var exdate=new Date();
                exdate.setDate(exdate.getDate() + exdays);
                var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
                document.cookie=c_name + "=" + c_value + ";path=/";
            }
         </script>
    </head>
<body>
<form action="<?=$_SERVER['SCRIPT_NAME']?>" method="post">

<?php

if(isset($_GET['logout'])) {
    if($_SESSION["auth"] === true) {
        if(isset($_GET['token'], $_SESSION['csrf-token']) && $_GET['token'] == $_SESSION['csrf-token']) {
            session_destroy();
            session_start();
            session_regenerate_id();
            print "Thou hast logged out.<br>";
        } else {
            print "One does not simply use CSRF to force a logout. <br>";
            exit();
        }
    } else {
        print "You're not even logged in. <br>";
    }
}

try {
    $pdo = new PDO('sqlite:../database.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $meh) {
    print "Some gentle error handling here. Mostlikely the database is offline :( <br>";
    exit;
}


if(isset($_POST['username'], $_POST['password'])) {
    if(preg_match("#[a-z0-9]{1,}#i", $_POST['username'])) {
         try {
            $sth = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
            $sth->execute(array($_POST['username'], $_POST['password']));
            $row = $sth->fetch(PDO::FETCH_ASSOC);

            if($row != false) {
                $_SESSION["auth"]       = true;
                $_SESSION['username']   = $row['username'];
                $_SESSION['csrf-token'] = CSRF_TOKEN;
            } else {
                print "Access denied! <br>";
                $_SESSION["auth"] = false;
            }
         } catch(PDOException $meh) {
             print "Some gentle error handling here. <br>";
         }
    } else {
        print "Usernames consist of 1 to 60 alphanumeric characters.<br>";
    }
}


if($_SESSION["auth"] !== true) { ?>
    One does not simply login.<br>
    Thou name: <input type="text" name="username" value="<?=htmlentities($_POST['username'])?>"><br>
    Thou password: <input type="password" name="password" value="<?=htmlentities($_POST['password'])?>"><br>
    <input type="submit" name="submit" value="Commence Forth">

<?php } else { ?>
    <?=$_SESSION["username"]?>, thou art logged in. <a href="?logout=true&token=<?=CSRF_TOKEN?>"> Logout</a>.
<?php } ?>

</form>
</body>
</html>
