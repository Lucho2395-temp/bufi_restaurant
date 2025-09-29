<?php
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Archivo.php';
require 'app/models/Egresos.php';
require 'app/models/Negocio.php';
require 'app/models/Caja.php';

class EgresoController
{
    private $usuario;
    private $rol;
    private $archivo;
    private $egresos;
    private $negocio;
    private $caja;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $nav;

    public function __construct()
    {
        //Instancias especificas del controlador
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();
        $this->egresos = new Egresos();
        $this->negocio = new Negocio();
        $this->caja = new Caja();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }


    //Vista de Inicio de La Gestión de Menús
    public function gestionar()
    {
        try {
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            //$empresa_registrada = $this->empresa->listar_empresas_modal();
            //Hacemos el require de los archivos a usar en las vistas
            $fecha_filtro = date('Y-m-d');
            $fecha_filtro_fin = date('Y-m-d');
            if(isset($_POST['enviar_fecha'])){
                $fecha_filtro = $_POST['fecha_filtro'];
                $fecha_filtro_fin = $_POST['fecha_filtro_fin'];
                $egresos = $this->egresos->listar_egresos_filtro($fecha_filtro,$fecha_filtro_fin);
            }

            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $sucursal = $this->negocio->listar_sucursal_egresos($id_usuario);
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'egresos/gestionar.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }


    //FUNCIONES
    public function guardar_egresos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data){
                $model = new Egresos();
                $fecha_hoy = date('Y-m-d');
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $fecha = date('Y-m-d H:i:s');
                $buscar_caja = $this->caja->jalar_caja_movi($fecha_hoy,$id_usuario);
                $model->id_caja_numero = $buscar_caja->id_caja_numero;
                $model->id_usuario = $id_usuario;
                $model->id_sucursal = $_POST['id_sucursal'];
                $model->movimiento_tipo = $_POST['movimiento_tipo'];
                $model->egreso_descripcion = $_POST['egreso_descripcion'];
                $model->egreso_monto = $_POST['egreso_monto'];
                $model->egreso_fecha_registro = $fecha;
                $model->egreso_estado = 1;
                //Guardamos el menú y recibimos el resultado
                $result = $this->egresos->guardar_egresos($model);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }

    public function editar_egresos(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validacion de datos
            if($ok_data){
                $model = new Egresos();
                $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
                $fecha = date('Y-m-d H:i:s');
                $model->id_usuario = $id_usuario;
                $model->id_movimiento = $_POST['id_movimiento'];
                $model->id_sucursal = $_POST['id_sucursal_e'];
                $model->movimiento_tipo = $_POST['movimiento_tipo_e'];
                $model->egreso_descripcion = $_POST['egreso_descripcion_e'];
                $model->egreso_monto = $_POST['egreso_monto_e'];
                $model->egreso_fecha_registro = $fecha;
                //Guardamos el menú y recibimos el resultado
                $result = $this->egresos->guardar_egresos($model);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }


    public function eliminar_egreso(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_movimiento', 'POST',true,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data) {
                $id_movimiento = $_POST['id_movimiento'];
                $result = $this->egresos->eliminar_egreso($id_movimiento);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }



}