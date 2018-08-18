<?php
    session_start();
    require './db.php';

    if(isset($_POST['kode'])) {
        $kode = $_POST['kode'];

        $sqlM = "SELECT * FROM mahasiswa WHERE hapuskah = 0 AND nrp = ".$kode;
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

    $sql = "SELECT * FROM mahasiswa WHERE hapuskah = 0";
    $result = mysqli_query($link, $sql);
    if(!$result) {
        echo "SQL Error: " . $sql;
    } ?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Master Mahasiswa</title>
        <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./bootstrap/css/justified-nav.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="masthead">
                <nav>
                    <ul class="nav nav-justified">
                        <li><a href="./adminhome.php">Beranda</a></li>
                        <li><a href="./masterperiode.php">Periode</a></li>
                        <li><a href="./mastermk.php">Mata Kuliah</a></li>
                        <li class="active"><a href="./mastermhs.php">Mahasiswa</a></li>
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
                        <td colspan="2" class="info"><h1 class="sub-header">Tambah Mahasiswa</h1></td>
                    </tr>
                    <tr class="active">
                        <form action="manage.php?act=insertMHS" method="POST" enctype="multipart/form-data">
                            <td>NRP:<br/><input type="text" name="nrp" class="form-control" required autofocus /></td>
                            <td>Nama Mahasiswa:<br/><input type="text" name="namamhs" class="form-control" required /></td>
                    </tr>
                    <tr>
                            <td colspan="2">Upload Foto Profil:<br/><input type="file" name="upload" class="form-control"/></td>
                    </tr>
                    <tr class="active">
                            <td>Password:<br/><input type="password" name="password" class="form-control" pattern="\d+" required /></td>
                            <td>Ulangi Password:<br/><input type="password" name="upassword" class="form-control" pattern="\d+" required /></td>
                    </tr>
                    <tr>
                            <td colspan="2">Jatah SKS:<br/><input type="number" name="jatahSKS" min="0" max="27" class="form-control" required /></td>
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
                    <th>NRP</th>
                    <th>Nama Mahasiswa</th>
                    <th><center>Jatah SKS</th>
                    <th><center>Edit / Hapus</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_object($result)) {
                    echo "<tr>";
                    echo "<td>" . $row->nrp . "</td>";
                    echo "<td>" . $row->nama . "</td>";
                    echo "<td><center>" . $row->jatah_sks . "</td>";
                    echo "<td>";
                    echo "<center><a href='#' class='edit' data-toggle='modal' id='tekan' ide='" . $row->nrp . "' data-target='#exampleModal'><img src='./img/edit.png' width='20px'></a>&nbsp&nbsp&nbsp";
                    echo "<a href='manage.php?act=hapusMHS&i=" . $row->nrp . "'><img src='./img/hapus.png' width='20px'></a>";
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
                    <h4 class="modal-title" id="exampleModalLabel"><strong>Edit Mahasiswa</strong></h4>
                  </div>
                  <div class="modal-body">
                    <form action="manage.php?act=editMHS" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="control-label">NRP:</label>
                        <input name="nrp" type="text" class="form-control" id="nrp">
                      </div>
                      <div class="form-group">
                        <label class="control-label">Nama Mahasiswa:</label>
                        <input name="nama_mahasiswa" type="text" class="form-control" id="nama_mahasiswa" >
                      </div>
                      <!--<div class="form-group">
                        <label class="control-label">Password Baru:</label>
                        <input id="password" type="password" name="password" class="form-control" pattern="\d+" required />
                      </div>
                      <div class="form-group">
                        <label class="control-label">Ulangi Password Baru:</label>
                        <input id="upassword" type="password" name="upassword" class="form-control" pattern="\d+" required />
                      </div>-->
                      <input name="delete_foto" type="hidden" type="text" class="form-control" id="delete_foto">
                      <div class="form-group">
                        <label class="control-label">Upload Foto Profil:</label>
                        <input name="upload_foto" type="file" class="form-control" id="upload_foto">
                      </div>
                      <div class="form-group">
                        <label class="control-label">Jatah SKS:</label>
                        <input name="jatah_sks" type="number" min="0" max="27" class="form-control" id="jatah_sks">
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
                        url     : "mastermhs.php",
                        type    : "POST",
                        data    : {
                                'kode': idEdit
                            },
                        success:function(show)
                        {
                            $("#nrp").val(show.nrp);
                            $("#nama_mahasiswa").val(show.nama);
                            $("#delete_foto").val(show.foto_profil);
                            $("#jatah_sks").val(show.jatah_sks);
                            //$("#password").val(show.password);
                            //$("#upassword").val(show.password);
                        }
                    });
                });
            });
            </script>
        </div>
    </body>
</html>