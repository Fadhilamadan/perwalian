<?php
    session_start();
    require './db.php';

    if(isset($_POST['kode'])) {
        $kode = $_POST['kode'];

        $sqlK = "SELECT * FROM kelas WHERE hapuskah = 0 AND kode_kelas = '".$kode."'";
        $resultK = mysqli_query($link, $sqlK);

        $rowK = mysqli_fetch_object($resultK);

        header("content-type: text/x-json");
        echo json_encode($rowK);
        exit();
    }

    $_SESSION['username'] = $_COOKIE['username'];
    if(!isset($_COOKIE['username'])) {
        header('location: loginadmin.php');
    }

    $sql = "SELECT kelas.kode_kelas, kelas.nama_kelas, matakuliah.nama as 'nama_mk', periode.nama, kelas.kapasitas FROM kelas INNER JOIN matakuliah, periode WHERE kelas.kode_mk = matakuliah.kode_mk AND kelas.kode_periode = periode.kode_periode AND kelas.hapuskah = 0";
    $result = mysqli_query($link, $sql);
    if(!$result) {
        die("SQL Error: " . $sql) ;
    }
    
    $sql1 = "SELECT * FROM matakuliah WHERE hapuskah = 0";
    $result1 = mysqli_query($link, $sql1);
    if(!$result1) {
        die("SQL Error: " . $sql1);
    }

    $sqlP = "SELECT * FROM periode WHERE hapuskah = 0";
    $resultP = mysqli_query($link, $sqlP);
    if(!$resultP) {
        die("SQL Error: " . $sqlP);
    }

    $sqlPeriod = "SELECT COUNT(kode_periode) AS 'total', kode_periode as 'idPeriode' FROM periode WHERE hapuskah = 0 AND status = 1";
    $resultPeriod = mysqli_query($link, $sqlPeriod);
    if(!$resultPeriod) {
        die("SQL Error: " . $sqlPeriod);
    }
    else {
        $rowPeriod = mysqli_fetch_array($resultPeriod);
    } ?>
    
<html>
    <head>
        <meta charset="UTF-8">
        <title>Master Kelas</title>
        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./bootstrap/css/justified-nav.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">

        <?php
        if($rowPeriod['total'] == 0) { //KALAU TIDAK ADA PERIODE YANG AKTIF, MUNCUL INI
        ?> 
            <div class="masthead">
                <nav>
                    <ul class="nav nav-justified">
                        <li><a href="./adminhome.php">Beranda</a></li>
                        <li><a href="./masterperiode.php">Periode</a></li>
                        <li><a href="./mastermk.php">Mata Kuliah</a></li>
                        <li><a href="./mastermhs.php">Mahasiswa</a></li>
                        <li class="active"><a href="./masterkelas.php">Kelas</a></li>
                        <li><a href="./laporan.php">Laporan</a></li>
                        <li><a href="./manage.php?act=logoutadmin">Logout</a></li>
                    </ul>
                </nav>
            </div>

            <br/>

            <div class="alert alert-danger">
            TIDAK ADA PERIODE YANG AKTIF
            </div>

            <?php
        }
        else {
            ?>
            <div class="masthead">
                <nav>
                    <ul class="nav nav-justified">
                        <li><a href="./adminhome.php">Beranda</a></li>
                        <li><a href="./masterperiode.php">Periode</a></li>
                        <li><a href="./mastermk.php">Mata Kuliah</a></li>
                        <li><a href="./mastermhs.php">Mahasiswa</a></li>
                        <li class="active"><a href="./masterkelas.php">Kelas</a></li>
                        <li><a href="./laporan.php">Laporan</a></li>
                        <li><a href="./manage.php?act=logoutadmin">Logout</a></li>
                    </ul>
                </nav>
            </div>

            <br/>
            
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td colspan="2" class="info"><h1 class="sub-header">Tambah Kelas</h1></td>
                    </tr>
                    <tr class="active">
                        <form action="manage.php?act=insertKelas" method="POST">
                            <td>Nama Kelas:<br/>
                            <select name="namaKelas" class="form-control"> <!-- KUJADIIN OPTION -->
                                <option value='KP -'>KP -</option>
                                <option value='KP A'>KP A</option>
                                <option value='KP B'>KP B</option>
                                <option value='KP C'>KP C</option>
                                <option value='KP D'>KP D</option>
                                <option value='KP E'>KP E</option>
                                <option value='KP F'>KP F</option>
                                <option value='KP G'>KP G</option>
                            </select></td>
                            <td>Periode Aktif:<br/>
                            <select name="periode" class="form-control" id="TPeriode">
                                <?php
                                while($rowP = mysqli_fetch_object($resultP)) {
                                    $P[]=$rowP;
                                    echo "<option value='" . $rowP->kode_periode . "'>" . $rowP->nama . "</option>"; //KUJADIIN OPTION
                                }
                                ?>
                            </select>
                            </td>
                    </tr>
                    <tr>
                            <td colspan="2">Mata Kuliah:<br/>
                            <select name="matakuliah" class="form-control">
                                <?php
                                while($row1 = mysqli_fetch_object($result1)) {
                                    $MK[]=$row1;
                                    echo "<option value='" . $row1->kode_mk . "'>" . $row1->nama . "</option>";
                                }
                                ?>
                            </select>
                            </td>
                    </tr>
                    <tr class="active">
                            <td colspan="2">Kapasitas Kelas:<br/><input type="number" name="kapasitasKelas" min="0" class="form-control" required/></td>
                    </tr>
                    <tr>
                            <td colspan="2" align="right"><div class="col-sm-offset-2"><input type="submit" class="btn btn-primary" value="SIMPAN"/></div></td>
                        </form>
                    </tr>
                </table>
            </div>

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

            <table class="table table-hover table-bordered">
                <tr class="info">
                    <th>Nama Kelas</th>
                    <th>Mata Kuliah</th>
                    <th>Periode</th>
                    <th><center>Kapasitas</th>
                    <th><center>Edit / Hapus</th>
                </tr>
                <?php //MASIH BELUM SELESAI
                while ($row = mysqli_fetch_object($result)) {
                    echo "<tr>";
                    echo "<td>" . $row->nama_kelas . "</td>";
                    echo "<td>" . $row->nama_mk . "</td>";
                    echo "<td>" . $row->nama . "</td>";
                    echo "<td><center>" . $row->kapasitas . "</td>";
                    echo "<td>";
                    echo "<center><a href='#' class='edit' data-toggle='modal' id='tekan' ide='" . $row->kode_kelas . "' data-target='#exampleModal'><img src='./img/edit.png' width='20px'></a>&nbsp&nbsp&nbsp";
                    echo "<a href='manage.php?act=hapusKelas&i=" . $row->kode_kelas . "'><img src='./img/hapus.png' width='20px'></a>"; //KUGANTI
                    echo "</td>";
                    echo "<tr>";
                }
                ?>
            </table>
            <?php } ?>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel"><strong>Edit Kelas</strong></h4>
                  </div>
                  <div class="modal-body">
                    <form action="manage.php?act=editKelas" method="POST">
                      <div class="form-group">
                      <input name="kode_kelas" type="hidden"  type="text" class="form-control" id="kode_kelas" />
                        <label class="control-label">Nama Kelas:</label>
                        <select name="namaKelas" type="text" class="form-control" id="nama_kelas">
                            <option value='KP -'>KP -</option>
                            <option value='KP A'>KP A</option>
                            <option value='KP B'>KP B</option>
                            <option value='KP C'>KP C</option>
                            <option value='KP D'>KP D</option>
                            <option value='KP E'>KP E</option>
                            <option value='KP F'>KP F</option>
                            <option value='KP G'>KP G</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Mata Kuliah:</label>
                        <select name="mata_kuliah" type="text" class="form-control" id="mata_kuliah">
                        <?php
                        foreach($MK as $row1) { //BUAT RESET mysqli_fetch_object()
                            echo "<option value='" . $row1->kode_mk . "'>" . $row1->nama . "</option>";
                        }
                        ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Periode:</label>
                        <select name="periode" type="text" class="form-control" id="periode">
                        <?php
                        foreach($P as $rowP) { //BUAT RESET mysqli_fetch_object()
                            echo "<option value='" . $rowP->kode_periode . "'>" . $rowP->nama . "</option>";
                        }
                        ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label class="control-label">Kapasitas:</label>
                        <input name="kapasitas" type="number" min="0" class="form-control" id="kapasitas" />
                      </div>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" id="kirim" value="SIMPAN"/>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <footer class="footer">
                <p class="pull-right">Faishal Hendaryawan (160414053) | Fadhil Amadan (160414063) | Putu Aditya (160414039)</p>
                <p>&copy; 2016 | Pemrograman Web | Universitas Surabaya </p>
            </footer>
            
            <script src="./bootstrap/jquery/jquery.min.js"></script>
            <script src="./bootstrap/js/bootstrap.min.js"></script>
            <script type="text/javascript"> 
            $(function() {
                $("body").delegate('.edit', 'click', function(){
                    var idEdit = $(this).attr('ide');
                    $.ajax({
                        url     : "masterkelas.php",
                        type    : "POST",
                        data    : {
                                'kode': idEdit
                            },
                        success:function(show)
                        {
                            $("#kode_kelas").val(show.kode_kelas);
                            $('#nama_kelas option[value="'+show.nama_kelas+'"]').attr('selected', 'selected');
                            $('#mata_kuliah option[value="'+show.kode_mk+'"]').attr('selected', 'selected');
                            $("#periode ").val(show.kode_periode);
                            $("#kapasitas").val(show.kapasitas);
                        }
                    });
                });
                var id = "<?php echo $rowPeriod['idPeriode']; ?>";
                $('#TPeriode option[value="'+id+'"').attr('selected', 'selected');
            });
            </script>
        </div>
    </body>
</html>