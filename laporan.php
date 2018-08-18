<html>
    <head>
        <meta charset="UTF-8">
        <title>Laporan</title>
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

            $sqlPeriode = "SELECT * FROM periode WHERE hapuskah = 0";
            $resultPeriode = mysqli_query($link, $sqlPeriode);
            if(!$resultPeriode) {
                echo "SQL Error: " . $sqlPeriode;
            }
            
            $sqlMata = "SELECT * FROM matakuliah WHERE hapuskah = 0";
            $resultMata = mysqli_query($link, $sqlMata);
            if(!$resultMata) {
                echo "SQL Error: " . $sqlMata;
            }
            ?>

            <div class="masthead">
                <nav>
                    <ul class="nav nav-justified">
                        <li><a href="./adminhome.php">Beranda</a></li>
                        <li><a href="./masterperiode.php">Periode</a></li>
                        <li><a href="./mastermk.php">Mata Kuliah</a></li>
                        <li><a href="./mastermhs.php">Mahasiswa</a></li>
                        <li><a href="./masterkelas.php">Kelas</a></li>
                        <li class="active"><a href="./laporan.php">Laporan</a></li>
                        <li><a href="./manage.php?act=logoutadmin">Logout</a></li>
                    </ul>
                </nav>
            </div>

            <br/>
            
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td colspan="2" class="info"><h1 class="sub-header">Filter Laporan</h1></td>
                    </tr>
                    <tr class="active">
                        <form action="pdf.php?act=admin" method="POST" >
                            <td>Pilih Periode:<br/>
                                <select name="P" class="form-control" id="periode" required="*" autofocus>
                                </select>
                            </td>
                    </tr>
                    <tr>
                            <td>Pilih Mata Kuliah:<br/>
                                <select name="MK" class="form-control" id="matakuliah" required="*">
                                </select>
                            </td>  
                    </tr>
                    <tr class="active">
                            <td>Pilih Kelas:<br/>
                                <select name="K" class="form-control" id="kelas" required="*">
                                </select>
                            </td>  
                    </tr>
                    <tr>
                            <td colspan="2" align="right">
                            <div class="col-sm-offset-2"><input type="submit" class="btn btn-primary" value="CETAK LAPORAN"/></div>
                            </td>
                        </form>
                    </tr>
                </table>
            </div>

            <footer class="footer">
                <p class="pull-right">Faishal Hendaryawan (160414053) | Fadhil Amadan (160414063) | Putu Aditya (160414039)</p>
                <p>&copy; 2016 | Pemrograman Web | Universitas Surabaya </p>
            </footer>

            <script src="./bootstrap/jquery/jquery.min.js"></script>
            <script src="./bootstrap/js/bootstrap.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#periode").load("manage.php?act=laporanPeriode");
                    $("#matakuliah").load("manage.php?act=laporanMatakuliah");

                    $("#periode").change(function(){
                        var id = $(this).val();    
                        $("#matakuliah").change(function(){
                            var idP = id;
                            var idMK = $(this).val();   
                            $("#kelas").load("manage.php?act=laporanKelas",{
                                mk_id: idMK, pd_id: idP
                            });
                            $("#kelas").change(function(){
                                var P = idP;
                                var MK = idMK;
                                var K = $(this).val();
                            });
                        });
                    });
                    $("#matakuliah").change(function(){
                        var id = $(this).val();    
                        $("#periode").change(function(){
                            var idMK = id;
                            var idP = $(this).val();   
                            $("#kelas").load("manage.php?act=laporanKelas",{
                                mk_id: idMK, pd_id: idP
                            });
                            $("#kelas").change(function(){
                                var P = idP;
                                var MK = idMK;
                                var K = $(this).val();
                            });
                        });
                    });
                });
            </script>
        </div>
    </body>
</html>