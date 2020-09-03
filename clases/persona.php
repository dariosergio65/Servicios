<?php

class Persona {

protected $nombre;
protected $apellido;
protected $dni;

public function __construct($nombre, $apellido, $dni)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
    }

function setnombre($nombre){
    $this->nombre = $nombre;
}
function setapellido($apellido){
    $this->apellido = $apellido;
}
function setdni($dni){
    $this->dni = $dni;
}

function getnombre(){
    return $this->nombre;
}
function getapellido(){
    return $this->apellido;
}
function getdni(){
    return $this->dni;
}

}

class empleado extends persona {

    protected $fechanac;
    protected $categoria;
    protected $cuil;
    protected $licencia;
    protected $vencelic;
    
    function setfechanac($fechanac){
        $this->fechanac = $fechanac;
    }
    
    function getfechanac(){
        return $this->fechanac;
    }
    
    function setcategoria($categoria){
        $this->categoria = $categoria;
    }
    
    function getcategoria(){
        return $this->categoria;
    }
    
    function setcuil($cuil){
        $this->cuil = $cuil;
    }
    
    function getcuil(){
        return $this->cuil;
    }

    function setlicencia($licencia){
        $this->licencia = $licencia;
    }
    
    function getlicencia(){
        return $this->licencia;
    }

    function setvencelic($vencelic){
        $this->vencelic = $vencelic;
    }
    
    function getvencelic(){
        return $this->vencelic;
    }

}


class contacto extends persona {

    protected $celular;
    protected $fijo;
    protected $interno;
    protected $cargo;
    protected $empresa;
    
    function setcelular($celular){
        $this->celular = $celular;
    }
    
    function getcelular(){
        return $this->celular;
    }

    function setfijo($fijo){
        $this->fijo = $fijo;
    }
    
    function getfijo(){
        return $this->fijo;
    }

    function setinterno($interno){
        $this->interno = $interno;
    }
    
    function getinterno(){
        return $this->interno;
    }

    function setcargo($cargo){
        $this->cargo = $cargo;
    }
    
    function getcargo(){
        return $this->cargo;
    }

    function setempresa($empresa){
        $this->empresa = $empresa;
    }
    
    function getempresa(){
        return $this->empresa;
    }

}
?>