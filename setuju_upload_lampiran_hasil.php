<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        		$id = $_REQUEST['id_ph'];

                $query = mysqli_query($config, "UPDATE lampiran_seminar_hasil SET status=1 WHERE id_ph='$id'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Lampiran disetujui<br/>';
                    header("Location: ./admin.php?page=pengajuan_hasil_seminar");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=pengajuan_hasil_seminar&act=setuju&id='.$id.'";
                          </script>';
            	} 
}

?>
