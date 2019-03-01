<?php
    //cek session
    if(!empty($_SESSION['admin'])){ 
            echo '
                <div class="col s12" id="header-instansi">
                    <div class="card blue-grey white-text">
                        <div class="card-content"> <div class="circle left"><img class="logo" src="./asset/img/logo.png"/></div> 
                              <h5 class="ins">
                              PENDIDIKAN TEKNIK ELEKTRO</h5>
                               <h5 class="ins">Fakultas Keguruan dan Ilmu Pendidikan </h5>
                              <h5 class="ins">UNTIRTA</h5>
                               <center><p class="almt">Jl. Ciwaru Raya No.25, Cipare, Kec. Serang, Kota Serang, Banten 42117</p></center> 
                        </div>
                    </div>
                </div>'; 
    } else {
        header("Location: ../");
        die();
    }
?>
