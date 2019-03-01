<?php
    //cek session
    if(!empty($_SESSION['admin'])){
?>

<nav class="blue-grey darken-1">
    <div class="nav-wrapper">
        <a href="./" class="brand-logo center hide-on-large-only"><i class="material-icons md-36">school</i> SIPITA</a>
        <ul id="slide-out" class="side-nav" data-simplebar-direction="vertical">
            <li class="no-padding">
                <div class="logo-side center blue-grey darken-3">
                        <img class="logoside" src="./asset/img/logo.png"/> 
                </div>
            </li>
            <li class="no-padding blue-grey darken-4">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header"><i class="material-icons">account_circle</i><?php echo $_SESSION['nama']; ?></a>
                        <div class="collapsible-body">
                            <ul> 
                                <li><a href="logout.php">Logout</a></li>
                                <li><a href="help.php">Help</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
            <li><a href="./"><i class="material-icons middle">dashboard</i> Beranda</a></li>
            <li><a href="./"><i class="material-icons middle">dashboard</i> Master Data</a></li>
            <li><a href="./"><i class="material-icons middle">dashboard</i> Praktet Industri</a></li>
            <li><a href="./"><i class="material-icons middle">dashboard</i> Tugas Akhir</a></li> 
 
        </ul>
        <!-- Menu on medium and small screen END -->

        <!-- Menu on large screen START -->
        <ul class="center hide-on-med-and-down" id="nv">
            <li><a href="./" class="ams hide-on-med-and-down"><i class="material-icons md-36">school</i> SIPITA</a></li>
            <li><div class="grs"></></li>
            <li><a href="./"><i class="material-icons"></i>&nbsp; Beranda</a></li>
            <?php
                if($_SESSION['admin'] == 1){ ?>
           
            <li><a class="dropdown-button" href="#!" data-activates="master">Master Data<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='master' class='dropdown-content'> 
                                <li><a href="?page=dosen">Dosen Pembimbing</a></li>
                                <li><a href="?page=mahasiswa">Mahasiswa</a></li>
                                <li><a href="?page=perusahaan">Perusahaan</a></li> 
                                <li><a href="?page=usr">User</a></li> 
                </ul>
            <li><a class="dropdown-button" href="#!" data-activates="transaksi">Praktik Industri<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='transaksi' class='dropdown-content'> 
                                <li><a href="?page=pi">Pendaftaran Praktik Industri </a></li>
                                <li><a href="?page=daftar_pi">Pendaftaran Seminar Praktik Industri</a></li> 
                                <li><a href="?page=seminar_hasil">Jadwal Seminar Hasil </a></li>
                                <li><a href="?page=dosen">Daftar Dosen Pembimbing </a></li>
                                <li><a href="?page=perusahaan">Perusahaan/Mitra Kerja </a></li>
                                <li><a href="?page=dokumen_ta">Dokumen/Lampiran</a></li>  
                                <li><a>Bimbingan</a></li> 
                                <li><a href="?page=jurnal_harian">- Jurnal Harian</a></li> 
                </ul>
            <li><a class="dropdown-button" href="#!" data-activates="ta">Tugas Akhir<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='ta' class='dropdown-content'> 
                                <li><a href="?page=pengajuan_proposal">Pengajuan Judul Proposal Skripsi</a></li>
                                <li><a href="?page=pengajuan_seminar">Pengajuan Seminar Skripsi</a></li>
                                <li><a href="?page=pengajuan_hasil_seminar">Pengajuan Seminar Hasil Skripsi</a></li>
                                <li><a href="?page=jadwal_seminar_proposal">Jadwal Seminar Proposal</a></li>
                                <li><a href="?page=seminar_hasil">Jadwal Seminar Hasil </a></li>
                                <li><a href="?page=jadwal_sidang">Jadwal Sidang</a></li>
                                <li><a href="?page=dokumen_ta">Dokumen/Lampiran</a></li> 
                                
                </ul>
            <?php
                }else if($_SESSION['admin'] == 2){ 
            ?>
              
            <li><a class="dropdown-button" href="#!" data-activates="master">Master Data<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='master' class='dropdown-content'>  
                                <li><a href="?page=usr">User</a></li>
                </ul>
            <li><a class="dropdown-button" href="#!" data-activates="transaksi">Praktik Industri<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='transaksi' class='dropdown-content'> 
                                <li><a href="?page=pi">Pendaftaran Praktik Industri </a></li>
                                <li><a href="?page=daftar_pi">Pendaftaran Seminar Praktik Industri</a></li> 
                                <li><a href="?page=jurnal_harian">Jurnal Harian</a></li> 
                                <li><a href="?page=seminar_hasil">Jadwal Seminar Hasil </a></li>
                                <li><a href="?page=dosen">Daftar Dosen Pembimbing </a></li>
                                <li><a href="?page=perusahaan">Perusahaan/Mitra Kerja </a></li>
                                <li><a href="?page=dokumen_ta">Dokumen/Lampiran</a></li>  
                </ul>
            <li><a class="dropdown-button" href="#!" data-activates="ta">Tugas Akhir<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='ta' class='dropdown-content'> 
                                <li><a href="?page=pengajuan_proposal">Pengajuan Judul Proposal Skripsi</a></li>
                                <li><a href="?page=pengajuan_seminar">Pengajuan Seminar Skripsi</a></li>
                                <li><a href="?page=pengajuan_hasil_seminar">Pengajuan Seminar Hasil Skripsi</a></li>
                                <li><a href="?page=jadwal_seminar_proposal">Jadwal Seminar Proposal</a></li>
                                <li><a href="?page=seminar_hasil">Jadwal Seminar Hasil </a></li>
                                <li><a href="?page=jadwal_sidang">Jadwal Sidang</a></li>
                                <li><a href="?page=dokumen_ta">Dokumen/Lampiran</a></li> 
                </ul> 
            <?php
                }else if($_SESSION['admin'] == 3){ 
            ?>
              
            <li><a class="dropdown-button" href="#!" data-activates="master">Master Data<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='master' class='dropdown-content'>  
                                <li><a href="?page=mahasiswa">Mahasiswa</a></li>  
                </ul>
            <li><a class="dropdown-button" href="#!" data-activates="transaksi">Praktik Industri<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='transaksi' class='dropdown-content'> 
                                <li><a href="?page=pi">Pendaftaran Praktik Industri </a></li>
                                <li><a href="?page=daftar_pi">Pendaftaran Seminar Praktik Industri</a></li> 
                                <li><a href="?page=jurnal_harian">Jurnal Harian</a></li> 
                                <li><a href="?page=">Bimbingan</a></li> 
                                <li><a href="?page=jurnal_harian">Jurnal Harian</a></li> 
                </ul>
            <li><a class="dropdown-button" href="#!" data-activates="ta">Tugas Akhir<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='ta' class='dropdown-content'> 
                                <li><a href="?page=jadwal_seminar_proposal">Jadwal Seminar Proposal</a></li>
                                <li><a href="?page=seminar_hasil">Jadwal Seminar Hasil </a></li>
                                <li><a href="?page=jadwal_sidang">Jadwal Sidang</a></li>
                                <li><a href="?page=dokumen_ta">Dokumen/Lampiran</a></li> 
                </ul>
            <?php 
                }else if($_SESSION['admin'] == 4){ 
            ?>
           
            <li><a class="dropdown-button" href="#!" data-activates="transaksi">Praktik Industri<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='transaksi' class='dropdown-content'>  
                                <li><a href="?page=pi">Pendaftaran Praktik Industri </a></li> 
                                <li><a href="?page=daftar_pi">Pendaftaran Seminar Praktik Industri</a></li> 
                                <li><a href="?page=seminar_hasil">Jadwal Seminar Hasil </a></li>
                                <li><a href="?page=dosen">Daftar Dosen Pembimbing </a></li>
                                <li><a href="?page=perusahaan">Perusahaan/Mitra Kerja </a></li>
                                <li><a href="?page=dokumen_ta">Dokumen/Lampiran</a></li> 
                                <li><a href="?page=">Bimbingan</a></li> 
                                <li><a href="?page=jurnal_harian">- Jurnal Harian</a></li> 
                                
                </ul>
            <li><a class="dropdown-button" href="#!" data-activates="ta">Tugas Akhir<i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='ta' class='dropdown-content'> 
                                <li><a href="?page=pengajuan_proposal">Pengajuan Judul Proposal Skripsi</a></li>
                                <li><a href="?page=pengajuan_seminar">Pengajuan Seminar Skripsi</a></li>
                                <li><a href="?page=pengajuan_hasil_seminar">Pengajuan Seminar Hasil Skripsi</a></li>
                                <li><a href="?page=jadwal_seminar_proposal">Jadwal Seminar Proposal</a></li>
                                <li><a href="?page=seminar_hasil">Jadwal Seminar Hasil </a></li>
                                <li><a href="?page=jadwal_sidang">Jadwal Sidang</a></li>
                                <li><a href="?page=dokumen_ta">Dokumen/Lampiran</a></li> 
                                
                </ul>
            
            <?php
                }
            ?>
             
            <li class="right" style="margin-right: 10px;"><a class="dropdown-button" href="#!" data-activates="logout"><i class="material-icons">account_circle</i> <?php echo $_SESSION['nama']; ?><i class="material-icons md-18">arrow_drop_down</i></a></li>
                <ul id='logout' class='dropdown-content'> 
                    <li><a href="?page=ganti_password">Ubah Password</a></li>
                    <li><a href="?page=help">Help</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="material-icons">settings_power</i> Logout</a></li>
                </ul>
        </ul>
        <!-- Menu on large screen END -->
        <a href="#" data-activates="slide-out" class="button-collapse" id="menu"><i class="material-icons">menu</i></a>
    </div>
</nav>

<?php
    } else {
        header("Location: ../");
        die();
    }
?>
