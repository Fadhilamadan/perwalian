<?php
session_start();
require './db.php';
$cmd = $_GET['cmd'];

switch ($cmd) {
    case "login":
        $nrp = $_POST['NRP'];
        $pswd = $_POST['pswd'];
        $Dpswd = md5($pswd);

        $sqlM = "SELECT * FROM mahasiswa WHERE nrp ='" . $nrp . "' ";
        $resultM = mysqli_query($link, $sqlM);
        $rowM=  mysqli_fetch_array($resultM);

        if(mysqli_num_rows($resultM) > 0) {
            if($Dpswd == $rowM['password']){
                setcookie("nomer", $nrp, time() +600);
                setcookie("login", TRUE, time() +600);
                header("location: inputperwalian.php");
            }
            else {
                $_SESSION['notif'] = "<strong>MAAF!</strong> PASSWORD SALAH.";
                header("location: index.php");
            }
        }
        else {
            $_SESSION['notif'] = "<strong>MAAF!</strong> USER TIDAK DITEMUKAN.";
            header("location: index.php");
        }
        break;

    case "logout":
        setcookie("nomer", $nrp, time() -1);
        setcookie("login", FALSE, time() -1);
        header('location: index.php');
        break;

    case "tambah":
        $mk = strtoupper($_POST['mk']);
        $kp = strtoupper($_POST['kp']);
        $kode = $_GET['kode'];

        $sqlM = "SELECT * FROM mahasiswa WHERE nrp =".$_COOKIE['nomer'];
        $resultM = mysqli_query($link, $sqlM);
        $rowM=  mysqli_fetch_array($resultM);
        if(!$resultM){
            die("SQL ERROR: ".$sqM);
        }

        $sqlP = "SELECT * FROM periode WHERE status = 1 AND hapuskah = 0";
        $resultP = mysqli_query($link, $sqlP);
        if(!$resultP) {
            die("SQL ERROR: ".$sqlP);
        }
        else {
            $rowP = mysqli_fetch_array($resultP);
        }

        $sqlK = "SELECT * FROM kelas WHERE (kode_mk = '".$mk."') AND (nama_kelas = 'KP ".$kp."' AND hapuskah = 0) AND kode_periode = '".$rowP['kode_periode']."'";
        $resultK = mysqli_query($link, $sqlK);
        $rowK = mysqli_fetch_array($resultK);
        if(!$resultK){
            die("SQL ERROR: ".$sqlK);
        }
        else {
            if(mysqli_num_rows($resultK)==0){
                $_SESSION['notifSQL']="KELAS TIDAK ADA";
                die(header('location: inputperwalian.php'));
            }
            else{
                $sqlBantu = "SELECT * FROM matakuliah WHERE kode_mk = '".$mk."' ";
                $resultBantu = mysqli_query($link, $sqlBantu);
                $rowBantu = mysqli_fetch_array($resultBantu);
                $sqlBantu1 = "SELECT mahasiswa_kelas.nrp, kelas.kode_mk, matakuliah.nama FROM kelas, matakuliah INNER JOIN mahasiswa_kelas WHERE mahasiswa_kelas.kode_kelas = kelas.kode_kelas AND mahasiswa_kelas.nrp ='".$_COOKIE['nomer']."' AND matakuliah.kode_mk = '".$mk."' AND kelas.kode_mk = '".$mk."'";
                $resultBantu1 = mysqli_query($link, $sqlBantu1);
                $rowBantu1 = mysqli_fetch_array($resultBantu1);
                if(!$resultBantu1){
                    die("SQL ERROR: ".$sqlBantu1);
                }
                if(mysqli_num_rows($resultBantu) == 0){
                    $_SESSION['notifSQL']="MATAKULIAH / KELAS, TIDAK ADA";
                    header('location: inputperwalian.php');
                    break;
                }
                $sama = "lanjut";
                if($rowBantu1['kode_mk']==$mk){
                    $sama = "setop";
                }
                else{
                    $sama ="lanjut";
                }
                if($rowM['jatah_sks']>=$rowBantu['jumlah_sks']){
                    if($rowK['kapasitas']> 0){
                        if($sama == "lanjut"){
                            $sqlInsert = "INSERT INTO mahasiswa_kelas (nrp, kode_kelas)"
                            ." VALUE ('".$_COOKIE['nomer']."', '".$rowK['kode_kelas']."')";
                            $resultInsert= mysqli_query($link, $sqlInsert);
                            if(!$resultInsert){
                                die("SQL ERROR: ".$sqlInsert);
                            }
                            else{
                                $sqlKapasitas = "UPDATE kelas SET kapasitas=kapasitas-1 WHERE kode_mk = '".$mk."' AND nama_kelas = 'KP ".$kp."' AND kode_periode ='".$rowP['kode_periode']."'";
                                $resultKapasitas = mysqli_query($link, $sqlKapasitas);
                                if(!$resultKapasitas){
                                    die("SQL ERROR: ".$resultKapasitas);
                                }
                                else{
                                    $_SESSION['notif']="MATA KULIAH BERHASIL DI INPUT";
                                    header("location: inputperwalian.php");
                                }
                            }
                        }
                        else{
                            $_SESSION['notifSQL']="KODE MATAKULIAH <strong>" .$mk. "</strong>, SUDAH ADA DAN TIDAK BISA DI INPUT LAGI";
                            header("location: inputperwalian.php");
                        }
                    }
                    else{
                        $_SESSION['notifSQL']="KELAS PENUH";
                        header("location: inputperwalian.php");
                    }
                }
                else{
                    $_SESSION['notifSQL']="SKS KURANG";
                    header("location: inputperwalian.php");
                }
            }
        }
        break;

    case "hapus":
        $kode = $_GET['kode'];
        $sqlHapus = "DELETE FROM mahasiswa_kelas WHERE kode_kelas ='".$kode."' ";
        $resultHapus = mysqli_query($link, $sqlHapus);
        if(!$resultHapus){
            die("SQL ERROR: ".$sqlHapus);
        }
        else{
            $sqlHapus1 = "UPDATE kelas SET kapasitas = kapasitas+1 WHERE kode_kelas ='".$kode."' ";
            $resultHapus1 = mysqli_query($link, $sqlHapus1);
            if(!$resultHapus1){
                die("SQL ERROR: ".$sqlHapus1);
            }
            $_SESSION['notif']="MATA KULIAH BERHASIL DI HAPUS";
            header("location: inputperwalian.php");
        }
        break;

    default;
        die("UNKNOWN");
} ?>