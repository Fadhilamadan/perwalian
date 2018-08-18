<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Mahasiswa</title>
        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./bootstrap/css/signin.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php
            session_start();
            require './db.php';

            if(isset($_COOKIE['login'])) {
                header('location: inputperwalian.php');
            }
            else {
                $sqlP = "SELECT status FROM periode WHERE status = 1 AND hapuskah = 0";
                $resultP = mysqli_query($link, $sqlP);
                if(!$resultP) {
                    echo "SQL ERROR: ".$sqlP;
                }
                if(mysqli_num_rows($resultP) == 0) { ?>
                    <div class="alert alert-danger">
                        <strong>MAAF!</strong> INPUT PERWALIAN BELUM DAPAT DIAKSES.
                    </div>
            <?php
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

                    <form class="form-signin" action="proses.php?cmd=login" method="POST">
                        <img src="./img/mahasiswa.png" class="center-block"><br/>
                        <h2 class="form-signin-heading text-center">LOGIN MAHASISWA</h2>
                        <label for="inputNRP" class="sr-only">NRP</label>
                        <input type="text" name="NRP" class="form-control" placeholder="NRP" required autofocus>
                        <label for="inputPassword" class="sr-only">Password</label>
                        <input type="password" name="pswd" class="form-control" placeholder="Password" required>
                        <label>
                            <a href="./loginadmin.php">Admin, masuk disini.</a>
                        </label>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">LOGIN</button>
                    </form>
            <?php
                }
            } ?>
            <script src="./bootstrap/jquery/jquery.min.js"></script>
            <script src="./bootstrap/js/bootstrap.min.js"></script>
        </div>
    </body>
</html>
        