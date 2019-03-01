<?php
    ob_start();
    //cek session
    session_start();

    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
?>

<!doctype html>
<html lang="en">

<!-- Include Head START -->
<?php include('include/head.php'); ?>
<!-- Include Head END -->

<!-- Body START -->
<body class="bg">

<!-- Header START -->
<header>

<!-- Include Navigation START -->
<?php include('include/menu.php'); ?>
<!-- Include Navigation END -->

</header>
<!-- Header END -->

<!-- Main START -->
<main>

    <!-- container START -->
    <div class="container">

    <?php
        if(isset($_REQUEST['page'])){
            $page = $_REQUEST['page'];
            switch ($page) {
                case 'dosen':
                    include "dosen.php";
                    break;
                case 'perusahaan':
                    include "perusahaan.php";
                    break;
                case 'jadwal':
                    include "jadwal.php";
                    break;
                case 'dokumen':
                    include "dokumen.php";
                    break;               
                case 'mahasiswa':
                    include "mahasiswa.php";
                    break;           
                case 'ruangan':
                    include "ruangan.php";
                    break;      
                case 'pi':
                    include "pi.php";
                    break;   
                case 'praktek_industri':
                    include "pi.php";
                    break;
                case 'jurnal_harian':
                    include "jurnal_harian.php";
                    break;
                case 'ctk':
                    include "surat_pi.php";
                    break;
                case 'jadwal_seminar_proposal':
                    include "jadwal_seminar_proposal.php";
                    break;
                case 'jadwal_sidang':
                    include "jadwal_sidang.php";
                    break;
                case 'seminar_hasil':
                    include "seminar_hasil.php";
                    break;
                case 'dokumen_ta':
                    include "dokumen_ta.php";
                    break;
                case 'usr':
                    include "user.php";
                    break;
                case 'ganti_password':
                    include "ganti_password.php";
                    break;
				case 'pengajuan_proposal';
					include "pengajuan_proposal.php";
					break;
				case 'pengajuan_seminar';
					include "pengajuan_seminar.php";
					break;
				case 'pengajuan_hasil_seminar';
					include "pengajuan_hasil_seminar.php";
					break;
				case 'help';
					include "help.php";
					break;
				case 'daftar_pi';
					include "daftar_pi.php";
					break;
				case 'karya_ilmiah_dosen';
					include "karya_ilmiah_dosen.php";
					break;
            }
        } else {
    ?>
        <!-- Row START -->
        <div class="row">

            <!-- Include Header Instansi START -->
            <?php include('include/header_instansi.php'); ?>
            <!-- Include Header Instansi END -->

            <!-- Welcome Message START -->
            <div class="col s12">
                <div class="card">
                    <div class="card-content">
                        <h4>Selamat Datang <?php echo $_SESSION['nama']; ?></h4>
                        <p class="description">Anda login sebagai
                        <?php
                            if($_SESSION['admin'] == 1){
                                echo "<strong>Admin</strong>. Anda memiliki akses penuh terhadap sistem.";
                            } elseif($_SESSION['admin'] == 2){
                                echo "<strong>Petugas TU</strong>. ";
                            } elseif($_SESSION['admin'] == 3){
                                echo "<strong>Dosen</strong>. ";
                            } elseif($_SESSION['admin'] == 4){
                                echo "<strong>Mahasiswa</strong>. ";
                            } ?></p>
                            
                    <iframe src="include/nivo" style="width: 100%; height:450px;"  frameborder="0"></iframe>
                    </div>
                </div>
            </div>
            <!-- Welcome Message END -->
             

        </div>
        <!-- Row END -->
    <?php
        }
    ?>
    </div>
    <!-- container END -->

</main>
<!-- Main END -->

<!-- Include Footer START -->
<?php include('include/footer.php'); ?>
<!-- Include Footer END -->

</body>
<!-- Body END -->

</html>

<?php
    }
?>
