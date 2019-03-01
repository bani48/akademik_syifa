<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        		$id_jurnal_harian = $_REQUEST['id_jurnal_harian'];

                $query = mysqli_query($config, "DELETE FROM jurnal_harian WHERE id_jurnal_harian='$id_jurnal_harian'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                    header("Location: ./admin.php?page=jurnal_harian");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=jurnal_harian&act=del&id_jurnal_harian='.$id_jurnal_harian.'";
                          </script>';
            	} 
}

?>
