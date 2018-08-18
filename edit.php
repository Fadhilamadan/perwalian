<?php
/*if(isset($_POST['id'])){
    echo $_POST['id'];
}
else{
    echo"belom";
}
require './db.php';
$cmd = $_GET['cmd'];

switch($cmd){
    case "mk":
        $i = $_GET['i'];
        $sql = "SELECT * FROM matakuliah WHERE kode_mk = '" . $i."'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        ?>
        EDIT MK <br>
        <form action="manage.php?act=editMK" method="POST">
            Kode MK: <input type="text" name="kode_mk" value="<?php echo $row['kode_mk']?>"/><br/>
            Nama MK: <input type="text" name="nama" value="<?php echo $row['nama']?>"/><br/>
            <input type="submit" name="Edit"/>
        </form>
        <?php
        break;
    case "mhs":
        $i = $_GET['i'];
        $sql = "SELECT * FROM mahasiswa WHERE nrp = " . $i;
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($result);
        ?>
        EDIT MHS <br>
        <form action="manage.php?act=editMHS" method="POST">
            Kode MK: <input type="text" value="<?php echo $row['nrp']?>"/><br/>
            Nama MK: <input type="text" value="<?php echo $row['nama']?>"/><br/>
            <input type="submit" name="Edit"/>
        </form>
        <?php
        
        
}
*/

if(isset($_POST['id'])){
    $kode = $_POST['id'];
    echo $kode;

    $sqlP = "SELECT * FROM periode WHERE hapuskah = 0 AND kode_periode = ".$kode;
    $resultP = mysqli_query($link, $sqlP);
    if(!$resultP) {
        dead("SQL Error: " . $sqlP);
    }
    $rows = mysql_query($sqlP);
    $rowP = mysql_fetch_object($rows);
    echo json_encode($rowP);
    header("Content-type: text/x-json");
    exit();

}
else{
    echo "belom ada"; 
}

?>

