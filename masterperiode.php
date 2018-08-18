<?php
    session_start();
    require './db.php';

    if(isset($_POST['kode'])){
        $kode = $_POST['kode'];

        $sqlP = "SELECT * FROM periode WHERE hapuskah = 0 AND kode_periode = ".$kode;
        $resultP = mysqli_query($link, $sqlP);

        $rowP = mysqli_fetch_object($resultP);
        
        header("content-type: text/x-json");
        echo json_encode($rowP);
        exit();
    }

    $_SESSION['username'] = $_COOKIE['username'];
    if(!isset($_COOKIE['username'])) {
        header('location: loginadmin.php');
    }

    $sql = "SELECT * FROM periode WHERE hapuskah = 0";
    $result = mysqli_query($link, $sql);
    if(!$result) {
        echo "SQL Error: " . $sql;
    } ?>
    
<html>
    <head>
        <meta charset="UTF-8">
        <title>Master Periode</title>
        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./bootstrap/css/justified-nav.css" rel="stylesheet">
    </head>
    <body>
    <script src="./bootstrap/jquery/jquery.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
        <div class="container">
            <div class="masthead">
                <nav>
                    <ul class="nav nav-justified">
                        <li><a href="./adminhome.php">Beranda</a></li>
                        <li class="active"><a href="./masterperiode.php">Periode</a></li>
                        <li><a href="./mastermk.php">Mata Kuliah</a></li>
                        <li><a href="./mastermhs.php">Mahasiswa</a></li>
                        <li><a href="./masterkelas.php">Kelas</a></li>
                        <li><a href="./laporan.php">Laporan</a></li>
                        <li><a href="./manage.php?act=logoutadmin">Logout</a></li>
                    </ul>
                </nav>
            </div>

            <br/>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <td colspan="5" class="info"><h1 class="sub-header">Tambah Periode</h1></td>
                    </tr>
                    <tr class="active">
                        <td>Nama Periode:</td>
                        <td>Status Periode:</td>
                        <td>Tanggal Mulai:</td>
                        <td>Tanggal Akhir:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <form action="manage.php?act=insertPeriode" method="POST">
                            <td><input type="text" name="nperiode" class="form-control" required/></td>
                            <td>
                            <select name="aktif" class="form-control">
                              <option value="1" >Aktif</option>
                              <option value="0" >Non Aktif</option>
                            </select>
                            </td>
                            <td><input type="date" name="tglmulai" class="form-control" required/></td>
                            <td><input type="date" name="tglakhir" class="form-control" required/></td>
                            <td><div class="col-sm-offset-2"><input type="submit" class="btn btn-primary" value="SIMPAN"/></div></td>
                        </form>
                    </tr>
                </table>
            </div>

            <br/>

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
                    <th>No</th>
                    <th>Nama Periode</th>
                    <th>Tanggal Awal</th>
                    <th>Tanggal Akhir</th>
                    <th><center>Status</th>
                    <th><center>Edit / Hapus</th>
                </tr>
                <?php
                $hitung = 1;
                while ($row = mysqli_fetch_object($result)) {
                    echo "<tr>";
                    echo "<td>" . $hitung. "</td>";
                    echo "<td>" . $row->nama . "</td>";
                    echo "<td>" . $row->tanggal_buka . "</td>";
                    echo "<td>" . $row->tanggal_akhir . "</td>";
                    echo "<td><center>" . $row->status . "</td>";
                    echo "<td>";
                    echo "<center><a href='#' class='edit' data-toggle='modal' id='tekan' ide='" . $row->kode_periode . "' data-target='#exampleModal'><img src='./img/edit.png' width='20px'></a>&nbsp&nbsp&nbsp";
                    echo "<a href='manage.php?act=hapusPeriode&i=" . $row->kode_periode . "' ><img src='./img/hapus.png' width='20px'></a>";
                    echo "</td>";
                    echo "<tr>";
                    $hitung = $hitung +1;
                } ?>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel"><strong>Edit Periode</strong></h4>
                  </div>
                  <div class="modal-body">
                    <form action="manage.php?act=editPeriode" method="POST">
                      <div class="form-group">
                        <label class="control-label">ID Periode:</label>
                        <input name="kode_periode" type="text" class="form-control" id="id_periode" disabled="true">
                      </div>
                      <div class="form-group">
                        <label class="control-label">Nama Periode:</label>
                        <input name="nama" type="text" class="form-control" id="nama_periode" >
                      </div>
                      <div class="form-group">
                        <label class="control-label">Tanggal Awal:</label>
                        <input name="tanggal_buka" type="date" class="form-control" id="tanggal_awal" value="<?php echo $rowP->tanggal_buka; ?>">
                      </div>
                      <div class="form-group">
                        <label class="control-label">Tanggal Akhir:</label>
                        <input name="tanggal_akhir" type="date" class="form-control" id="tanggal_akhir" value="<?php echo $rowP->tanggal_akhir; ?>">
                      </div>
                      <div class="form-group">
                        <label class="control-label">Status:</label><br/>
                        <select name="aktif" id="aktif" class="form-control">
                          <option value="1">Aktif</option>
                          <option value="0">Non Aktif</option>
                        </select>
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
            
            <script type="text/javascript"> 
            $(function(){
                $("body").delegate('.edit', 'click', function(){
                    var idEdit = $(this).attr('ide');
                    $.ajax({
                        url     : "masterperiode.php",
                        type    : "POST",
                        data    : {
                                'kode': idEdit
                            },
                        success:function(show)
                        {
                            $("#id_periode").val(show.kode_periode);
                            $("#nama_periode").val(show.nama);
                            $("#tanggal_awal").val(show.tanggal_buka);
                            $("#tanggal_akhir").val(show.tanggal_akhir);
                            if(show.status == "1"){ //BUAT NYAMAIN AKTIF
                                $("#aktif option[value=1]").prop('selected', true);
                            }
                            if(show.status == "0"){ //BUAT NYAMAIN NONAKTIF
                                $("#aktif option[value=0]").prop('selected', true);
                            }
                        }
                    });
                });
            });
            </script>
        </div>
    </body>
</html>