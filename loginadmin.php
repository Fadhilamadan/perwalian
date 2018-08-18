<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Admin</title>
        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./bootstrap/css/signin.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php
            session_start();
            require './db.php';

            if(isset($_COOKIE['loginadmin'])) {
                header('location: adminhome.php');
            }
            else {

                if(!isset($_SESSION['notif'])) {
                    echo "";
                }
                else { ?>
                    <div class="alert alert-danger">
                    <?php
                    echo $_SESSION['notif']."</br>";
                    unset($_SESSION['notif']); ?>
                    </div>
                    <?php
                } ?>
 
            <form class="form-signin" action="manage.php?act=loginadmin" method="POST">
                <img src="./img/admin.png" class="center-block"><br/>
                <h2 class="form-signin-heading text-center">LOGIN ADMIN</h2>
                <label for="inputUsername" class="sr-only">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <label>
                    <a href="./index.php">Mahasiswa, masuk disini.</a>
                </label>
                <button class="btn btn-lg btn-primary btn-block" type="submit">LOGIN</button>
            </form>

            <?php
            }
            ?>
            <script src="./bootstrap/jquery/jquery.min.js"></script>
            <script src="./bootstrap/js/bootstrap.min.js"></script>
        </div>
    </body>
</html>