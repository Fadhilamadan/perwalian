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
        
        $sqlMK = "SELECT * FROM matakuliah WHERE hapuskah = 0";
        $resultMK = mysqli_query($link, $sqlMK);
        if(!$resultMK) {
            echo "SQL ERROR: ".$sqlMK;
        }
        if(!isset($_COOKIE['nomer'])) {
            header('location: index.php');
        }
        ?>
        
        <div class="container">
            <div class="masthead">
                <nav>
                    <ul class="nav nav-justified">
                        <li><a href="./inputperwalian.php">Input Perwalian</a></li>
                        <li class="active"><a href="./matakuliah.php">Mata Kuliah</a></li>
                        <li><a href="./proses.php?cmd=logout">Logout</a></li>
                    </ul>
                </nav>
            </div>
            
            <br/>
            
            <div class="table-responsive">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>DAFTAR MATA KULIAH</strong></h3>
                    </div>
                    
                    <table class="table table-hover table-bordered table-striped">
                        <tr class="info">
                            <th>Kode MK</th>
                            <th>Nama MK</th>
                            <th>SKS</th>
                            <th>Deskripsi</th>
                        </tr>
                        
                        <?php
                        while($rowMK = mysqli_fetch_object($resultMK)) {
                            echo "<tr>";
                            echo "<td>".$rowMK->kode_mk."</td>";
                            echo "<td>".$rowMK->nama."</td>";
                            echo "<td>".$rowMK->jumlah_sks."</td>";
                            echo "<td>".$rowMK->deskripsi."</td>";
                            echo "</tr>";
                        } ?>
                    </table>
                </div>
            </div>

            <footer class="footer">
                <p class="pull-right">Faishal Hendaryawan (160414053) | Fadhil Amadan (160414063) | Putu Aditya (160414039)</p>
                <p>&copy; 2016 | Pemrograman Web | Universitas Surabaya </p>
            </footer>
        </div>
    </body>
</html>
