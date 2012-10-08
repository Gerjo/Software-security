<?php

session_name("broken-session");
session_start();

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
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">

<?php

if(isset($_GET['logout'])) {
    session_destroy();
    session_start();
    session_regenerate_id();
    print "Thou hast logged out.<br>";
}

$pdo = new PDO('sqlite:database.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['username'], $_POST['password'])) {
    $sth = $pdo->prepare("SELECT * FROM users WHERE
        username = '{$_POST['username']}' AND password = '{$_POST['password']}'");

    $sth->execute();

    $row = $sth->fetch(PDO::FETCH_ASSOC);

    if($row != false) {
        $_SESSION["auth"]    = true;
        $_COOKIE["username"] = $row['username'];
        setcookie("username", $_COOKIE["username"], 9999999999, '/');

    } else {
        print "Access denied! <br>";
        $_SESSION["auth"] = false;
    }
}


if($_SESSION["auth"] !== true) { ?>
    One does not simply login.<br>
    Thou name: <input type="text" name="username" value="<?=$_POST['username']?>"><br>
    Thou password: <input type="password" name="password" value="<?=$_POST['password']?>"><br>
    <input type="submit" name="submit" value="Commence Forth">

<?php } else { ?>
    <?=$_COOKIE["username"]?>, thou art logged in. <a href="?logout=true"> Logout</a>.
<?php } ?>

</form>
</body>
</html>
