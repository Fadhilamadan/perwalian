<html>
    <head>
        <meta charset="UTF-8">
        <title>Master Mata Kuliah</title>
        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./bootstrap/css/justified-nav.css" rel="stylesheet">
    </head>
    <body>
        <?php
        session_start();
        require './db.php';

        $sqlP = "SELECT * FROM periode WHERE status= 1 AND hapuskah = 0";
        $resultP = mysqli_query($link, $sqlP);
        $rowP= mysqli_fetch_array($resultP);

        $sqlM = "SELECT * FROM mahasiswa WHERE nrp=".$_COOKIE['nomer'];
        $resultM = mysqli_query($link, $sqlM);
        $rowM= mysqli_fetch_array($resultM);

        if(!isset($_COOKIE['nomer'])) {
            header('location: index.php');
        }
        ?>
        <div class="container">
            <div class="masthead">
                <nav>
                    <ul class="nav nav-justified">
                        <li class="active"><a href="./inputperwalian.php">Input Perwalian</a></li>
                        <li ><a href="./matakuliah.php">Mata Kuliah</a></li>
                        <li><a href="./proses.php?cmd=logout">Logout</a></li>
                    </ul>
                </nav>
            </div>
            
            <br/>

            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>BIODATA MAHASISWA</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-6 col-lg-2">
                            <?php echo "<img src='./propic/".$rowM['foto_profil']."' width='156px' height='209px'>" ?>
                        </div>
                        <div class="col-xs-6 col-lg-3">
                            <?php
                            $sqlTotal = "SELECT SUM(matakuliah.jumlah_sks) as 'total_sks' "
                            . "FROM mahasiswa, matakuliah, kelas "
                            . "INNER JOIN mahasiswa_kelas "
                            . "WHERE mahasiswa.nrp = '".$_COOKIE['nomer']."' AND mahasiswa_kelas.nrp = '".$_COOKIE['nomer']."' AND mahasiswa_kelas.kode_kelas = kelas.kode_kelas AND matakuliah.kode_mk = kelas.kode_mk";
                            $resultTotal = mysqli_query($link, $sqlTotal);
                            if(!$resultTotal) {
                                die("SQL ERROR: ".$sqlTotal);
                            }
                            else {
                                $rowTotal = mysqli_fetch_array($resultTotal);
                            }
                            $sisa = $rowM['jatah_sks'] - $rowTotal['total_sks'];
                            $_SESSION['sisa_sks']=$sisa;
                            ?>

                            <strong>
                            NRP : <?php echo $rowM['nrp']; ?><br>
                            Nama : <?php echo $rowM['nama']; ?><br>
                            SKS Max : <?php echo $rowM['jatah_sks']; ?><br>
                            Sisa SKS : <?php echo $sisa; ?>
                            </strong>
                        </div>
                        <div class="col-xs-6 col-lg-7">
                            <div class="alert alert-success">
                            <h3 class="text-center"><br/><br/><strong>PERIODE: <?php echo $rowP['nama']; ?></strong><br/><br/><br/></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-lg-4">
                    <?php if(date("Y-m-d")>=$rowP['tanggal_buka'] && date("Y-m-d")>=$rowP['tanggal_akhir']) {?>
                        <div class="alert alert-danger"><h3 class="text-center"><strong>INPUT MATA KULIAH TIDAK DAPAT DI GUNAKAN</strong></h3></div>
                    <?php } ?>
                    <?php if(date("Y-m-d")>=$rowP['tanggal_buka'] && date("Y-m-d")<=$rowP['tanggal_akhir']) { ?>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>TAMBAH MATA KULIAH</strong></h3>
                            </div>
                            <div class="panel-body">
                                <center>
                                    <table>
                                        <tr>
                                            <td>Kode MK:<br/></td>
                                            <td>
                                                <form action="proses.php?cmd=tambah" method="POST" class="form-inline" role="form">
                                                <input type="text" name="mk" class="form-control"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>KP:</td>
                                            <td>
                                                <input type="text" name="kp" class="form-control"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <br/><button class="btn btn-primary btn-block" type="submit">SUBMIT</button>
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                
                <div class="col-xs-6 col-lg-8">

                    <?php
                    if(!isset($_SESSION['notif'])) {
                            echo "";
                        }
                        else { ?>
                            <div class="alert alert-success">
                            <?php
                            echo $_SESSION['notif']."</br>";
                            unset($_SESSION['notif']); ?>
                            </div>
                            <?php
                        } 

                    if(!isset($_SESSION['notifSQL'])) {
                            echo "";
                        }
                        else { ?>
                            <div class="alert alert-danger">
                            <?php
                            echo $_SESSION['notifSQL']."</br>";
                            unset($_SESSION['notifSQL']); ?>
                            </div>
                            <?php
                        } ?>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>DAFTAR MATA KULIAH YANG DIAMBIL</strong></h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-">
                                <tr class="info">
                                    <th>Kode MK</th>
                                    <th>Nama MK</th>
                                    <th><center>Kelas</center></th>
                                    <th><center>SKS</center></th>
                                    <?php
                                    if(date("Y-m-d")>=$rowP['tanggal_buka'] && date("Y-m-d")<=$rowP['tanggal_akhir']) {
                                        echo "<th>";
                                        echo "<center>HAPUS</center>";
                                        echo "</th>";
                                    } ?>
                                </tr>

                                <?php
                                $_SESSION['nrp'] = $rowM['nrp'];
                                $_SESSION['kode_periode']= $rowP['kode_periode'];

                                $sqlT = "SELECT kelas.kode_mk, matakuliah.nama, kelas.nama_kelas, matakuliah.jumlah_sks, kelas.kode_kelas FROM kelas, matakuliah INNER JOIN mahasiswa_kelas WHERE mahasiswa_kelas.nrp ='".$rowM['nrp']."' AND kelas.kode_kelas = mahasiswa_kelas.kode_kelas AND kelas.kode_mk = matakuliah.kode_mk AND kelas.kode_periode = '".$rowP['kode_periode']."'";
                                $resultT = mysqli_query($link, $sqlT);

                                if(!$resultT) {
                                    die("SQL ERROR: ".$sqlT."</br>");
                                }
                                while($rowT = mysqli_fetch_object($resultT)) {
                                    echo "<tr>";
                                    echo "<td>".$rowT->kode_mk."</td>";
                                    echo "<td>".$rowT->nama."</td>";
                                    echo "<td><center>".$rowT->nama_kelas."</center></td>";
                                    echo "<td><center>".$rowT->jumlah_sks."</center></td>";
                                    if(date("Y-m-d")>=$rowP['tanggal_buka'] && date("Y-m-d")<=$rowP['tanggal_akhir']){
                                        echo "<td align='center'><a href='proses.php?cmd=hapus&kode=".$rowT->kode_kelas."'><img src='./img/hapus.png' width='20px'></a></td>";
                                    }
                                    echo "</tr>";
                                } ?>

                                </form>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-offset-10">&nbsp&nbsp&nbsp<button class="btn btn-primary" id="cetak">CETAK LAPORAN</button></div>
            </div>

            <footer class="footer">
                <p class="pull-right">Faishal Hendaryawan (160414053) | Fadhil Amadan (160414063) | Putu Aditya (160414039)</p>
                <p>&copy; 2016 | Pemrograman Web | Universitas Surabaya </p>
            </footer>
            
            <script src="./bootstrap/jquery/jquery.min.js"></script>
            <script src="./bootstrap/js/bootstrap.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#cetak").click(function(){
                        window.location.href="pdf.php?act=mahasiswa";
                    });
                });
            </script>
        </div>
    </body>
</html>