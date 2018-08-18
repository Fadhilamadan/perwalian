<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Home</title>
        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./bootstrap/css/justified-nav.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php
            session_start();
            require './db.php';

            $_SESSION['username'] = $_COOKIE['username'];
            if(!isset($_COOKIE['username'])) {
                header('location: loginadmin.php');
            }
            ?>
            
            <div class="alert alert-success"><h2 class="text-center">SELAMAT DATANG, <?php echo strtoupper($_SESSION['username']); ?></h2></div><br/><br/><br/><br/>
            <center>
            <div class="row">
                <div class="col-lg-4">
                    <img src="img/masterPeriode.png">
                    <p><br/><a class="btn btn-info" href="./masterperiode.php" role="button">Master Period</a></p>
                </div>
                <div class="col-lg-4">
                    <img src="img/masterMK.png">
                    <p><br/><a class="btn btn-info" href="./mastermk.php" role="button">Master Mata Kuliah</a></p>
                </div>
                <div class="col-lg-4">
                    <img src="img/masterMHS.png">
                    <p><br/><a class="btn btn-info" href="./mastermhs.php" role="button">Master Mahasiswa</a></p>
                </div>
            </div>
            <br/><br/><br/><br/>
            <div class="row">
                <div class="col-lg-4">
                    <img src="img/masterKelas.png">
                    <p><br/><a class="btn btn-info" href="./masterkelas.php" role="button">Master Kelas</a></p>
                </div>
                <div class="col-lg-4">
                    <img src="img/laporan.png">
                    <p><br/><a class="btn btn-info" href="./laporan.php" role="button">Laporan</a></p>
                </div>
                <div class="col-lg-4">
                    <img src="img/logout.png">
                    <p><br/><a class="btn btn-info" href="./manage.php?act=logoutadmin" role="button">Logout</a></p>
                </div>
            </div>
            </center>

            <footer class="footer">
                <p class="pull-right">Faishal Hendaryawan (160414053) | Fadhil Amadan (160414063) | Putu Aditya (160414039)</p>
                <p>&copy; 2016 | Pemrograman Web | Universitas Surabaya </p>
            </footer>
      
            <script src="./bootstrap/jquery/jquery.min.js"></script>
            <script src="./bootstrap/js/bootstrap.min.js"></script>
        </div>
    </body>
</html>