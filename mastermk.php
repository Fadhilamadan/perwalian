<?php
    session_start();
    require './db.php';

    if(isset($_POST['kode'])) {
        $kode = $_POST['kode'];

        $sqlM = "SELECT * FROM matakuliah WHERE hapuskah = 0 AND kode_mk = '".$kode."'";
        $resultM = mysqli_query($link, $sqlM);

        $rowM = mysqli_fetch_object($resultM);

        header("content-type: text/x-json");
        echo json_encode($rowM);
        exit();
    }

    $_SESSION['username'] = $_COOKIE['username'];
    if(!isset($_COOKIE['username'])) {
        header('location: loginadmin.php');
    }

    $sql = "SELECT * FROM matakuliah WHERE hapuskah = 0";
    $result = mysqli_query($link, $sql);
    if(!$result) {
        echo "SQL Error: " . $sql;
    } ?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Master Mata Kuliah</title>
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
                        <li><a href="./masterperiode.php">Periode</a></li>
                        <li class="active"><a href="./mastermk.php">Mata Kuliah</a></li>
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
                        <td colspan="3" class="info"><h1 class="sub-header">Tambah Mata Kuliah</h1></td>
                    </tr>
                    <tr class="active">
                        <td>Kode MK:</td>
                        <td>Nama MK:</td>
                        <td>Jumlah SKS:</td>
                    </tr>
                    <tr>
                        <form action="manage.php?act=insertMK" method="POST" id="matkul">
                            <td><input type="text" name="kodemk" class="form-control" required autofocus/></td>
                            <td><input type="text" name="namamk" class="form-control" required/></td>
                            <td><input type="number" name="sks" min="0" class="form-control" required/></td>
                    </tr>
                    <tr class="active">
                        <td colspan="3">Deskripsi:</td>
                    </tr>
                    <tr>
                            <td colspan="3"><textarea form="matkul" cols="125" rows="5" name="deskripsi" class="form-control"></textarea></td>
                    </tr>
                    <tr>
                            <td colspan="3" align="right"><div class="col-sm-offset-2"><input type="submit" class="btn btn-primary" value="SIMPAN"/></div></td>
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
                    <th>Kode MK</th>
                    <th>Nama MK</th>
                    <th><center>Jumlah SKS</th>
                    <th><center>Edit / Hapus</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_object($result)) {
                    echo "<tr>";
                    echo "<td>" . $row->kode_mk . "</td>";
                    echo "<td>" . $row->nama . "</td>";
                    echo "<td><center>" . $row->jumlah_sks . "</td>";
                    echo "<td>";
                    echo "<center><a href='#' class='edit' data-toggle='modal' id='tekan' ide='" . $row->kode_mk . "' data-target='#exampleModal'><img src='./img/edit.png' width='20px'></a>&nbsp&nbsp&nbsp";
                    echo "<a href='manage.php?act=hapusMK&i=" . $row->kode_mk . "'><img src='./img/hapus.png' width='20px'></a>";
                    echo "</td>";
                    echo "<tr>";
                }
                ?>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel"><strong>Edit Mata Kuliah</strong></h4>
                  </div>
                  <div class="modal-body">
                    <form action="manage.php?act=editMK" method="POST">
                      <div class="form-group">
                        <label class="control-label">Kode Mata Kuliah:</label>
                        <input name="kode_mk" type="text" class="form-control" id="kode_mk">
                      </div>
                      <div class="form-group">
                        <label class="control-label">Nama Mata Kuliah:</label>
                        <input name="nama_mk" type="text" class="form-control" id="nama_mk" >
                      </div>
                      <div class="form-group">
                        <label class="control-label">Jumlah SKS:</label>
                        <input name="jumlah_sks" type="number" min="0" class="form-control" id="jumlah_sks">
                      </div>
                      <div class="form-group">
                        <label class="control-label">Deskripsi:</label>
                        <textarea name="deskripsi" type="text" rows="5" class="form-control" id="deskripsi"></textarea>
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
            $(function() {
                $("body").delegate('.edit', 'click', function(){
                    var idEdit = $(this).attr('ide');
                    $.ajax({
                        url     : "mastermk.php",
                        type    : "POST",
                        data    : {
                                'kode': idEdit
                            },
                        success:function(show)
                        {
                            $("#kode_mk").val(show.kode_mk);
                            $("#nama_mk").val(show.nama);
                            $("#jumlah_sks").val(show.jumlah_sks);
                            $("#deskripsi").val(show.deskripsi);
                        }
                    });
                });
            });
            </script>
        </div>
    </body>
</html>