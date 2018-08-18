<?php
session_start();
require_once 'tcpdf/tcpdf.php';
require 'db.php';

$act = $_GET['act'];

switch ($act) {
	case 'admin': // SELESAI TINGGAL DI EDIT TEMPAT2NYA
		$kode_kelas = $_POST['K'];
		$kode_periode = $_POST['P'];
		$kode_mk = $_POST['MK'];

		//BIAR GK BYPASS
		if(!isset($_COOKIE['username'])) {
		    header('location: loginadmin.php');
		}

		//SQL BUAT TABEL
		$sql = "SELECT mahasiswa.nrp AS 'id_nrp', mahasiswa.nama AS 'nama_mhs' FROM kelas, mahasiswa, periode, matakuliah INNER JOIN mahasiswa_kelas WHERE kelas.kode_kelas = mahasiswa_kelas.kode_kelas AND kelas.kode_kelas = '".$kode_kelas."' AND mahasiswa.nrp = mahasiswa_kelas.nrp AND kelas.kode_periode = periode.kode_periode AND kelas.kode_periode = '".$kode_periode."' AND kelas.kode_mk = matakuliah.kode_mk AND matakuliah.kode_mk = '".$kode_mk."'"; // BUAT NAMPILIN TABEL
		$result = mysqli_query($link, $sql);
		if(!$result){
			die("SQL ERROR: ".$sql);
		}

		//SQL BUAT HITUNG KAPASITAS
		$sqlData = "SELECT COUNT(mahasiswa.nrp) AS 'jumlah', mahasiswa.nrp AS 'id_nrp', mahasiswa.nama AS 'nama_mhs' FROM kelas, mahasiswa, periode, matakuliah INNER JOIN mahasiswa_kelas WHERE kelas.kode_kelas = mahasiswa_kelas.kode_kelas AND kelas.kode_kelas = '".$kode_kelas."' AND mahasiswa.nrp = mahasiswa_kelas.nrp AND kelas.kode_periode = periode.kode_periode AND kelas.kode_periode = '".$kode_periode."' AND kelas.kode_mk = matakuliah.kode_mk AND matakuliah.kode_mk = '".$kode_mk."'"; // BUAT KAPASITAS
		$resultData = mysqli_query($link, $sqlData);
		$rowData = mysqli_fetch_array($resultData);
		if(!$result){
			die("SQL ERROR: ".$sqlData);
		}
		
		//SQL BUAT DATA LAPORAN
		$sqlM = "SELECT * FROM matakuliah WHERE kode_mk = '".$kode_mk."'"; 
		$resultM = mysqli_query($link, $sqlM);
		$rowM = mysqli_fetch_array($resultM);
		if(!$resultM){
			die("SQL ERROR: ".$sqlM);
		}

		$sqlK = "SELECT * FROM kelas WHERE kode_kelas = '".$kode_kelas."'";
		$resultK = mysqli_query($link, $sqlK);
		$rowK = mysqli_fetch_array($resultK);
		if(!$resultK){
			die("SQL ERROR: ".$sqlK);
		}

		$sqlP = "SELECT * FROM periode WHERE kode_periode = '".$kode_periode."'"; 
		$resultP = mysqli_query($link, $sqlP);
		$rowP = mysqli_fetch_array($resultP);
		if(!$resultP){
			die("SQL ERROR: ".$sqlP);
		}

		//BUAT PDF
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);
		$pdf->SetCreator($_COOKIE['username']);
		$pdf->SetAuthor($_COOKIE['username']);
		$pdf->SetSubject("LaporanKelas");
		$pdf->SetTitle("Rekap Kelas ".$rowM['nama']." ".$rowK['nama_kelas']." ".$rowP['nama']);
		$pdf->SetKeywords("a b c");

		$pdf->setHeaderData("ubaya.jpg", 50, "", "", array(0, 0, 0));
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, "", PDF_FONT_SIZE_DATA));
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT, PDF_MARGIN_BOTTOM);
		$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->setFooterData(array(0, 0, 255));
		$pdf->setFooterFont(array(PDF_FONT_NAME_MAIN, "", PDF_FONT_SIZE_DATA));

		$pdf->AddPage();
		$html = "<div> DAFTAR ISI KELAS </div>";

		//DIBUAT KE KIRI
		$html = $html."<div>";
		$html = $html."Mata Kuliah: ".$rowM['nama']."<br/>";
		$html = $html."Kode: ".$rowM['kode_mk']."<br/>";
		$html = $html."Kelas: ".$rowK['nama_kelas']."<br/>";

		$banyak = $rowData['jumlah'];
		$kapasitas = $rowK['kapasitas']+$banyak;

		$html = $html."Kapasitas: ".$banyak."/".$kapasitas;
		$html = $html."</div>";

		//DIBUAT KE KANAN
		$html = $html."<div>";
		$html = $html."Periode: ".$rowP['nama']."<br/>";
		$html = $html."Tanggal Cetak: ".date('d/m/Y')."<br/>";
		$html = $html."</div>";

		$html = $html."<br/>";

		//TABEL
		$html = $html."<table border='1'>";
		$html = $html."<tr>";
		$html = $html."<th>NO</th>";
		$html = $html."<th>NRP</th>";
		$html = $html."<th>NAMA MAHASISWA</th>";
		$html = $html."</tr>";
		
		$nomer = 1;					
		while($row = mysqli_fetch_object($result)){ //LOOPING TABEL
			$html = $html."<tr>";
		    $html = $html."<td>".$nomer."</td>";
		    $html = $html."<td>".$row->id_nrp."</td>";
		    $html = $html."<td>".$row->nama_mhs."</td>";
		    $html = $html."</tr>";
		    $nomer = $nomer+1; //buat nambah nomer 1, 2, 3 ...
		}
		$html = $html."</table>";
		$pdf->writeHTML($html);

		$pdf->Output("Laporan.pdf");
		break;
	
	case 'mahasiswa':
		if(!isset($_COOKIE['nomer'])) {
		    header('location: inputperwalian.php');
		}

		//SQL BUAT TABEL
		$sql = "SELECT kelas.kode_mk, matakuliah.nama, kelas.nama_kelas, matakuliah.jumlah_sks, kelas.kode_kelas FROM kelas, matakuliah INNER JOIN mahasiswa_kelas WHERE mahasiswa_kelas.nrp ='".$_COOKIE['nomer']."' AND kelas.kode_kelas = mahasiswa_kelas.kode_kelas AND kelas.kode_mk = matakuliah.kode_mk AND kelas.kode_periode = '".$_SESSION['kode_periode']."'";
        $result = mysqli_query($link, $sql);

        if(!$result) {
            die("SQL ERROR: ".$sql."</br>");
        }
		
		//SQL BUAT DATA LAPORAN
		$sqlM = "SELECT * FROM mahasiswa WHERE nrp = '".$_SESSION['nrp']."'"; 
		$resultM = mysqli_query($link, $sqlM);
		$rowM = mysqli_fetch_array($resultM);
		if(!$resultM){
			die("SQL ERROR: ".$sqlM);
		}

		$sqlP = "SELECT * FROM periode WHERE hapuskah = 0 AND status = 1"; 
		$resultP = mysqli_query($link, $sqlP);
		$rowP = mysqli_fetch_array($resultP);
		if(!$resultP){
			die("SQL ERROR: ".$sqlP);
		}

		//BUAT PDF
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);
		$pdf->SetCreator("UBAYA");
		$pdf->SetAuthor("UBAYA");
		$pdf->SetSubject("LaporanMatakuliah");
		$pdf->SetTitle("Hasil Input Matakuliah - ".$rowP['nama']);
		$pdf->SetKeywords("a b c");

		$pdf->setHeaderData("ubaya.jpg", 50, "", "", array(0, 0, 0));
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, "", PDF_FONT_SIZE_DATA));
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT, PDF_MARGIN_BOTTOM);
		$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->setFooterData(array(0, 0, 255));
		$pdf->setFooterFont(array(PDF_FONT_NAME_MAIN, "", PDF_FONT_SIZE_DATA));

		$pdf->AddPage();
		$pdf->Cell(0, 0, "HASIL INPUT MATAKULIAH - " . $rowP['nama'], 0, 1, 'C', 0, '', 1);

		//DIBUAT KE KIRI
		$html = "<table>";
		$html = $html."<tr><td>Nama: ".$rowM['nama']."<br/>";
		$html = $html."NRP: ".$rowM['nrp']."<br/>";
		$html = $html."SKS: ".$_SESSION['sisa_sks']."/".$rowM['jatah_sks']."<br/></td>";

		//DIBUAT KE KANAN
		$html = $html."<td>";
		$html = $html."Periode: ".$rowP['nama']."<br/>";
		$html = $html."Tanggal Cetak: ".date('d/m/Y')."<br/>";
		$html = $html."<br/></td></tr></table>";

		//TABEL
		$html = $html."<table border='1'>";
		$html = $html."<tr>";
		$html = $html."<th>No</th>";
		$html = $html."<th>Kode MK</th>";
		$html = $html."<th>Nama MK</th>";
		$html = $html."<th>Kelas</th>";
		$html = $html."<th>SKS</th>";
		$html = $html."</tr>";
		
		$nomer = 1;					
		while($row = mysqli_fetch_object($result)) { //LOOPING TABEL
			$html = $html."<tr>";
		    $html = $html."<td>".$nomer."</td>";
		    $html = $html."<td>".$row->kode_mk."</td>";
		    $html = $html."<td>".$row->nama."</td>";
		    $html = $html."<td>".$row->nama_kelas."</td>";
		    $html = $html."<td>".$row->jumlah_sks."</td>";
		    $html = $html."</tr>";
		    $nomer = $nomer+1; //buat nambah nomer 1, 2, 3 ...
		}
		$html = $html."</table>";
		$pdf->writeHTML($html);

		$pdf->Output("Hasil Input Perwalian - ".$rowP['nama'].".pdf");
		break;

	default:
		die("UNKNOWN");
		break;
}

?>
