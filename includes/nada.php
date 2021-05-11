if ($micant==0){//si no existe el permiso
                    if($micategoria==1){//admin 
                        $permiso=true;   
                        
                    }elseif($micategoria==2){//personal Lago
                        if ($idpantalla=='menu12') {
                            $permiso=0;
                        }else{
                            $permiso=true;    
                        }
                    }elseif($micategoria==3){//invitado   
                        if ($idpantalla=='menu0' or $idpantalla=='menu18') {
                            $permiso=true;
                        }else{
                            $permiso=0;    
                        }
                    }
                    $queryfinal="INSERT INTO permisos (id_usuario,id_pantalla,permitido) VALUES ('$miuser','$mipant',$permiso) ";
                    $rfinal = mysqli_query($conn,$queryfinal);
                    if (!$rfinal){
                        die( 'Algo falló en la función recargartodos--' );
                    } 
                }