<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
            	$id = $_REQUEST['id'];
                $cek=mysqli_fetch_array(mysqli_query($config,"SELECT * FROM seminar_praktek_industri WHERE id='".$id."'"));
                
                $lampiran_pi='upload/'.$cek['lampiran_pi'];
                $jurnal_pi='upload/'.$cek['jurnal_pi'];
                $kartu_bimbingan='upload/'.$cek['kartu_bimbingan']; 
        	
                if(file_exists($lampiran_pi)){
                    unlink($lampiran_pi);
                }
                if(file_exists($jurnal_pi)){
                    unlink($jurnal_pi);
                }
                if(file_exists($kartu_bimbingan)){
                    unlink($kartu_bimbingan);
                }
                
 
                $query = mysqli_query($config, "DELETE FROM seminar_praktek_industri WHERE id='$id'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                    header("Location: ./admin.php?page=daftar_pi");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=daftar_pi&act=del&id='.$id.'";
                          </script>';
            	} 
}

?>
