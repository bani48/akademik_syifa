<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {
            	$id = $_REQUEST['id'];
                $cek=mysqli_fetch_array(mysqli_query($config,"SELECT * FROM lampiran_pi WHERE id='".$id."'"));
                
                $transkip='upload/'.$cek['transkip'];
                $krs='upload/'.$cek['krs'];
                $proposal='upload/'.$cek['proposal_pi'];
                $khs1='upload/'.$cek['khs1'];
                $khs2='upload/'.$cek['khs2'];
                $khs3='upload/'.$cek['khs3'];
                $khs4='upload/'.$cek['khs4'];
        	
                if(file_exists($transkip)){
                    unlink($transkip);
                }
                if(file_exists($krs)){
                    unlink($krs);
                }
                if(file_exists($proposal)){
                    unlink($proposal);
                }
                if(file_exists($khs1)){
                    unlink($khs1);
                } 
                if(file_exists($khs2)){
                    unlink($khs2);
                } 
                if(file_exists($khs3)){
                    unlink($khs3);
                } 
                if(file_exists($khs4)){
                    unlink($khs4);
                } 
 
                $query = mysqli_query($config, "DELETE FROM lampiran_pi WHERE id='$id'");

            	if($query == true){
                    $_SESSION['succDel'] = 'SUKSES! Data berhasil dihapus<br/>';
                    header("Location: ./admin.php?page=pi");
                    die();
            	} else {
                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                    echo '<script language="javascript">
                            window.location.href="./admin.php?page=pi&act=del&id='.$id.'";
                          </script>';
            	} 
}

?>
