<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

         
        		$id = $_REQUEST['id'];

                $query = mysqli_query($config, "UPDATE lampiran_pi SET status=1 WHERE id='$id'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Lampiran disetujui<br/>';
                    header("Location: ./admin.php?page=pi");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=pi&act=setuju&id='.$id.'";
                          </script>';
            	} 
}

?>
