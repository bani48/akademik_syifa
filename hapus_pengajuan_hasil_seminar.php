<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
            	$id = $_REQUEST['id_ph'];
                $cek=mysqli_fetch_array(mysqli_query($config,"SELECT * FROM lampiran_seminar_hasil WHERE id_ph='".$id."'"));
                
                $pendaftaran='upload/'.$cek['pendaftaran_seminar'];
                $bukti_serah_terima='upload/'.$cek['bukti_serah_terima'];
                $kartu_bimbingan='upload/'.$cek['kartu_bimbingan'];
                $laporan_pengajuan='upload/'.$cek['laporan_pengajuan'];
        	
                if(file_exists($pendaftaran)){
                    unlink($pendaftaran);
                }
                if(file_exists($bukti_serah_terima)){
                    unlink($bukti_serah_terima);
                }
                if(file_exists($kartu_bimbingan)){
                    unlink($kartu_bimbingan);
                }
                if(file_exists($laporan_pengajuan)){
                    unlink($laporan_pengajuan);
                } 
 
                $query = mysqli_query($config, "DELETE FROM lampiran_seminar_hasil WHERE id_ph='$id'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                    header("Location: ./admin.php?page=pengajuan_hasil_seminar");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=pengajuan_hasil_seminar&act=del&id='.$id.'";
                          </script>';
            	} 
}

?>
