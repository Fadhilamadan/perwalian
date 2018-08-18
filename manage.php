<?php
session_start();
require './db.php';
$act = $_GET['act'];

switch ($act) {
    case "loginadmin":
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
        }
        
        $sql = "SELECT * FROM admin WHERE username = '" . $username . "' ";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);

        if(mysqli_num_rows($result) > 0) {
            if($password == $row['password']) {
                setcookie("username", $username, time() + 600);
                setcookie("loginadmin", TRUE, time() + 600);
                header("location: adminhome.php");
            }
            else {
                $_SESSION['notif'] = "<strong>MAAF!</strong> PASSWORD SALAH.";
                header("location: loginadmin.php");
            }
        }
        else {
            $_SESSION['notif'] = "<strong>MAAF!</strong> USER TIDAK DITEMUKAN.";
            header("location: loginadmin.php");
        }
        break;

    case "logoutadmin":
        setcookie("username", $username, time() -1);
        setcookie("loginadmin", FALSE, time() -1);
        header('location: loginadmin.php');
        break;

////////////////////////////////////////MASTER PERIODE////////////////////////////////////////

    case "insertPeriode":
        $nperiode = $_POST['nperiode'];
        $tglmulai = $_POST['tglmulai'];
        $tglakhir = $_POST['tglakhir'];
        $aktif = $_POST['aktif'];
        
        if($aktif == 1) {
            $sqlP = "SELECT * FROM periode WHERE status = 1";
            $resultP = mysqli_query($link, $sqlP);
            if (!$resultP) {
                $_SESSION['notifSQL'] = "SQL ERROR.";
                die(header('location: masterperiode.php'));
            }
            else {
                $rowP = mysqli_fetch_array($resultP);
            }

            if(mysqli_num_rows($resultP) > 0) {
                $sqlEDIT = "UPDATE periode SET status = 0 WHERE kode_periode = ".$rowP['kode_periode'];
                $resultEDIT = mysqli_query($link, $sqlEDIT);
                if (!$resultEDIT) {
                    $_SESSION['notifSQL'] = "SQL ERROR.";
                    die(header('location: masterperiode.php'));
                }
            }

            $sqlAKTIF = "INSERT INTO periode (nama, tanggal_buka, tanggal_akhir, status) " . "VALUE ('" . $nperiode . "', '" . $tglmulai . "', '" . $tglakhir . "', 1)";
            $resultAKTIF = mysqli_query($link, $sqlAKTIF);
            if (!$resultAKTIF) {
                $_SESSION['notifSQL'] = "SQL ERROR.";
                die(header('location: masterperiode.php'));
            }
            else {
                $_SESSION['notif'] = "DATA BERHASIL DI MASUKKAN.";
                header('location: masterperiode.php');
            }
        }
        else {
            $sqlNONAKTIF = "INSERT INTO periode (nama, tanggal_buka, tanggal_akhir) " . "VALUE ('" . $nperiode . "', '" . $tglmulai . "', '" . $tglakhir . "')";
            $resultNONAKTIF  = mysqli_query($link, $sqlNONAKTIF );

            if (!$resultNONAKTIF ) {
                $_SESSION['notifSQL'] = "SQL ERROR.";
                die(header('location: masterperiode.php'));
            }
            else {
                $_SESSION['notif'] = "DATA BERHASIL DI MASUKKAN.";
                header('location: masterperiode.php');
            }
        }
        break;

    case "hapusPeriode":
        $kode_periode = $_GET['i'];
        
        $sql = "UPDATE periode SET hapuskah = 1 WHERE kode_periode='" . $kode_periode . "' ";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            $_SESSION['notifSQL'] = "SQL ERROR.";
            die(header('location: masterperiode.php'));
        }
        else {
            $_SESSION['notif'] = "DATA BERHASIL DI HAPUS.";
            header("Location: masterperiode.php");
        }
        break;

    case "editPeriode":
        $K = $_POST['kode_periode'];
        $N = $_POST['nama'];
        $B = $_POST['tanggal_buka'];
        $A = $_POST['tanggal_akhir'];
        $S = $_POST['aktif'];

        if($S == 1) {

            $sqlP = "SELECT * FROM periode WHERE status = 1";
            $resultP = mysqli_query($link, $sqlP);
            if (!$resultP) {
                $_SESSION['notifSQL'] = "SQL ERROR.";
                die(header('location: masterperiode.php'));
            }
            else {
                $rowP = mysqli_fetch_array($resultP);
            }

            if(mysqli_num_rows($resultP) > 0) {
                $sqlEDIT = "UPDATE periode SET status = 0 WHERE kode_periode = ".$rowP['kode_periode'];
                $resultEDIT = mysqli_query($link, $sqlEDIT);
                if (!$resultEDIT) {
                    $_SESSION['notifSQL'] = "SQL ERROR.";
                    die(header('location: masterperiode.php'));
                }
            }

            $sqlAKTIF = "UPDATE periode SET nama = '".$N."', tanggal_buka ='".$B."', tanggal_akhir = '".$A."', status = '".$S."' WHERE kode_periode = '".$K."'";
            $resultAKTIF = mysqli_query($link, $sqlAKTIF);
            if (!$resultAKTIF) {
                $_SESSION['notifSQL'] = "SQL ERROR.";
                die(header('location: masterperiode.php'));
            }
            else {
                $_SESSION['notif'] = "DATA BERHASIL DI EDIT.";
                header('location: masterperiode.php');
            }
        }
        else {
            $sqlNONAKTIF = "UPDATE periode SET nama = '".$N."', tanggal_buka ='".$B."', tanggal_akhir = '".$A."', status = '".$S."' WHERE kode_periode = '".$K."'";
            $resultNONAKTIF  = mysqli_query($link, $sqlNONAKTIF );

            if (!$resultNONAKTIF ) {
                $_SESSION['notifSQL'] = "SQL ERROR.";
                die(header('location: masterperiode.php'));
            }
            else {
                $_SESSION['notif'] = "DATA BERHASIL DI EDIT.";
                header('location: masterperiode.php');
            }
        }

        break;
////////////////////////////////////////MASTER PERIODE////////////////////////////////////////

////////////////////////////////////////MASTER MK////////////////////////////////////////

    case "insertMK":
        $kodemk = $_POST['kodemk'];
        $namamk = $_POST['namamk'];
        $deskripsi = $_POST['deskripsi'];
        $sks = $_POST['sks'];
        
        $sql = "INSERT INTO matakuliah (kode_mk, nama, deskripsi, jumlah_sks)" . "VALUE ('" . $kodemk . "', '" . $namamk . "', '" . $deskripsi . "', '".$sks."')";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            $_SESSION['notifSQL'] = "SQL ERROR.";
            header("Location: mastermk.php");
        }
        else {
            $_SESSION['notif'] = "DATA BERHASIL DI MASUKKAN.";
            header("Location: mastermk.php");
        }
        break;
        
    case "editMK":
        $kode_mk = $_POST['kode_mk'];
        $nama = $_POST['nama_mk'];
        $sks = $_POST['jumlah_sks'];
        $des = $_POST['deskripsi'];
        


        $sql = "UPDATE matakuliah SET kode_mk='" . $kode_mk . "', nama='" . $nama . "', jumlah_sks = '".$sks."', deskripsi='".$des."' " . "WHERE kode_mk='" . $kode_mk . "' ";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("SQL ERROR");
        }
        else {
            $_SESSION['notif'] = "DATA BERHASIL DI EDIT.";
            header("Location: mastermk.php");
        }
        break;

    case "hapusMK":
        $kode_mk = $_GET['i'];
        
        $sql = "UPDATE matakuliah SET hapuskah = 1 WHERE kode_mk='" . $kode_mk . "' ";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            die("SQL ERROR");
        }
        else {
            $_SESSION['notif'] = "DATA BERHASIL DI HAPUS.";
            header("Location: mastermk.php");
        }
        break;

////////////////////////////////////////MASTER MK////////////////////////////////////////

////////////////////////////////////////MASTER MHS////////////////////////////////////////

    case "insertMHS":
        $nrp = $_POST['nrp'];
        $nama = $_POST['namamhs'];

        $a = explode(".", $_FILES['upload']['name']);
        $format = $a[count($a)-1];  //BUAT FORMAT

        if(strlen($_POST['password']) != 8){
            $_SESSION['notifSQL'] = "PASWORD HARUS 8 ANGKA : ".$_POST['password'];
            die(header('location: mastermhs.php'));
        }
        else if(!ctype_digit($_POST['password'])){
            $_SESSION['notifSQL'] = "PASSWORD HARUS ANGKA SAJA: ".$_POST['password'];
            die(header('location: mastermhs.php'));
        }
        $upload = $kategori."-".$idmovie;
        $upload = substr(md5($_FILES['upload']['name'].time()), 0,10); //BIAR JADI 10 CHARACTER
        $upload = $upload . "." . $format;

        $sks = $_POST['jatahSKS'];

        if($_POST['password'] == $_POST['upassword']) {
            $password = $_POST['password'];
            $Dpassword = md5($_POST['password']);

            if(strlen($password) == 8 && $format == "jpg") {
                move_uploaded_file($_FILES['upload']['tmp_name'], "propic/".$upload); //FOLDER FOTO " upload " DIUBAH JADI " propic "
                $sqlInsert = "INSERT INTO mahasiswa (nrp, nama, password, foto_profil, jatah_sks) VALUE ('".$nrp."', '".$nama."', '".$Dpassword."', '".$upload."', '".$sks."')";
                $resultInsert = mysqli_query($link, $sqlInsert);
                if(!$resultInsert) {
                    $_SESSION['notifSQL'] = "SQL ERROR.";
                    die(header('location: mastermhs.php'));
                }
                else {
                    $_SESSION['notif'] = "DATA BERHASIL DI MASUKKAN.";
                    header('location: mastermhs.php');
                }
            }
            else if(strlen($password) != 8 ) {
                $_SESSION['notifSQL'] = "PASSWORD HARUS 8 ANGKA.";
                die(header('location: mastermhs.php'));
            }
            else if($format != "jpg") {
                $_SESSION['notifSQL'] = "FORMAT HARUS JPG.";
                die(header('location: mastermhs.php'));
            }
        }
        else {
            $_SESSION['notifSQL'] = "PASSWORD TIDAK SAMA";
            die(header('location: mastermhs.php'));
        }
        break;

    case "editMHS":
        $NRP = $_POST['nrp'];
        $N = $_POST['nama_mahasiswa'];
        $D = $_POST['delete_foto'];

        $a = explode(".", $_FILES['upload_foto']['name']);
        $format = $a[count($a)-1];  //BUAT FORMAT

        $upload = substr(md5($_FILES['upload_foto']['name'].time()), 0,10); //BIAR JADI 10 CHARACTER
        $upload = $upload . "." . $format;

        $SKS = $_POST['jatah_sks'];
        unlink("propic/".$D);
        /*if($_POST['password'] == $_POST['upassword']) {
            $password = $_POST['password'];
            $Dpassword = md5($_POST['password']);*/

            if($format == "jpg") {
                move_uploaded_file($_FILES['upload_foto']['tmp_name'], "propic/".$upload); //FOLDER FOTO " upload " DIUBAH JADI " propic "
                $sqlInsert = "UPDATE mahasiswa SET nrp = '".$NRP."', nama = '".$N."', foto_profil ='".$upload."', jatah_sks = '".$SKS."' WHERE nrp='".$NRP."'";
                $resultInsert = mysqli_query($link, $sqlInsert);
                if(!$resultInsert) {
                    $_SESSION['notifSQL'] = "SQL ERROR.";
                    die(header('location: mastermhs.php'));
                }
                else {
                    $_SESSION['notif'] = "DATA BERHASIL DI EDIT.";
                    header('location: mastermhs.php');
                }
            }
            /*else if(strlen($password) != 8 ) {
                $_SESSION['notifSQL'] = "PASSWORD HARUS 8 ANGKA.";
                die(header('location: mastermhs.php'));
            }*/
            else if($format != "jpg") {
                $_SESSION['notifSQL'] = "FORMAT HARUS JPG.";
                die(header('location: mastermhs.php'));
            }
        /*}
        else {
            $_SESSION['notifSQL'] = "PASSWORD TIDAK SAMA";
            die(header('location: mastermhs.php'));
        }*/
        break;

    case "hapusMHS":
        $nrp = $_GET['i'];
        
        $sql = "UPDATE mahasiswa SET hapuskah = 1 WHERE nrp='" . $nrp . "' ";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            $_SESSION['notifSQL'] = "SQL ERROR.";
            die(header('location: mastermhs.php'));
        }
        else {
            $_SESSION['notif'] = "DATA BERHASIL DI HAPUS.";
            header("Location: mastermhs.php");
        }
        break;

////////////////////////////////////////MASTER MHS////////////////////////////////////////

////////////////////////////////////////MASTER KELAS////////////////////////////////////////

    case "insertKelas": //BELUM SELESAI
        $namaKP = $_POST['namaKelas'];
        $kode_periode = $_POST['periode'];
        $kode_mk = $_POST['matakuliah'];
        $kapasitas = $_POST['kapasitasKelas'];

        $sqlK = "INSERT INTO kelas (kode_mk, kode_periode, nama_kelas, kapasitas) VALUE ('".$kode_mk."', '".$kode_periode."', '".$namaKP."', '".$kapasitas."')";
        $resultK = mysqli_query($link, $sqlK);
        if(!$resultK){
            $_SESSION['notifSQL'] = "SQL ERROR.";
            die(header('location: masterkelas.php'));
        }
        else{
            $_SESSION['notif'] = "DATA BERHASIL DI SIMPAN.";
            header("Location: masterkelas.php");
        }
        break;

    case "editKelas": 
        $kode_kelas = $_POST['kode_kelas'];
        $nama = $_POST['namaKelas'];
        $MK = $_POST['mata_kuliah'];
        $P = $_POST['periode'];
        $K = $_POST['kapasitas'];
        
        $sql = "UPDATE kelas SET nama_kelas='" . $nama . "', kode_periode = '".$P."', kapasitas='".$K."' " . "WHERE kode_kelas='" . $kode_kelas . "' ";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            $_SESSION['notifSQL'] = "SQL ERROR.";
            die(header('location: masterkelas.php'));
        }
        else {
            $_SESSION['notif'] = "DATA BERHASIL DI EDIT.";
            header("Location: masterkelas.php");
        }
        break;

    case "hapusKelas":
        $kode_kelas = $_GET['i'];
        
        $sql = "UPDATE kelas SET hapuskah = 1 WHERE kode_kelas='" . $kode_kelas . "' ";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            $_SESSION['notifSQL'] = "SQL ERROR.";
            die(header('location: masterkelas.php'));
        }
        else {
            $_SESSION['notif'] = "DATA BERHASIL DI HAPUS.";
            header("Location: masterkelas.php");
        }
        break;

////////////////////////////////////////MASTER KELAS////////////////////////////////////////

/////////////////////////////////DROPDOWN DI LAPORAN//////////////////////////////////////

    case "laporanPeriode": //AKU BUAT BARU
        $sql = "SELECT * FROM periode WHERE hapuskah = 0";
        $result = mysqli_query($link, $sql);
        if(!$result) {
            die("SQL Error: " . $sql);
        }
        else{
            echo "<option value='0'>Pilih Periode</option>";
            while($row = mysqli_fetch_object($result)) {
                echo "<option value='" . $row->kode_periode . "'>" . $row->nama . "</option>";
            }
        }
        break;
        
    case "laporanMatakuliah": //AKU BUAT BARU
        $sql = "SELECT * FROM matakuliah WHERE hapuskah = 0 "; 
        $result = mysqli_query($link, $sql);
        if(!$result) {
            die("SQL Error: " . $sql);
        }
        else{
            echo "<option value='0'>Pilih Matakuliah</option>";
            while($row = mysqli_fetch_object($result)) {
                echo "<option value='" . $row->kode_mk . "'>" . $row->nama . "</option>";
            }
        }
        break;

    case "laporanKelas": //AKU BUAT BARU
        $matakuliah_id = $_POST['mk_id'];
        $periode_id = $_POST['pd_id'];

        $sql = "SELECT * FROM kelas WHERE hapuskah = 0 AND kode_mk = '".$matakuliah_id."' AND kode_periode = '".$periode_id."' "; 
        $result = mysqli_query($link, $sql);
        if(!$result) {
            die("SQL Error: " . $sql);
        }
        else{
            echo "<option value='0'>Pilih Kelas</option>";
            while($row = mysqli_fetch_object($result)) {
                echo "<option value='" . $row->kode_kelas. "'>" . $row->nama_kelas . "</option>";
            }
        }
        break;
/////////////////////////////////DROPDOWN DI LAPORAN//////////////////////////////////////
    
    default;
        die("UNKNOWN");
        break;
} ?>
