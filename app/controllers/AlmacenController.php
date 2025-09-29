<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 12/03/2021
 * Time: 10:27
 */
require 'app/models/Usuario.php';
require 'app/models/Rol.php';
require 'app/models/Menu.php';
require 'app/models/Archivo.php';
require 'app/models/Almacen.php';
require 'app/models/Negocio.php';
class AlmacenController
{
    private $almacen;
    private $negocio;
    private $sucursal;
    private $usuario;
    private $rol;
    private $archivo;
    //Variables fijas para cada llamada al controlador
    private $sesion;
    private $encriptar;
    private $log;
    private $validar;
    private $nav;

    public function __construct()
    {
        //Instancias especificas del controlador
        $this->almacen = new Almacen();
        $this->negocio = new Negocio();
        $this->sucursal = new Negocio();
        $this->usuario = new Usuario();
        $this->rol = new Rol();
        $this->archivo = new Archivo();
        //Instancias fijas para cada llamada al controlador
        $this->encriptar = new Encriptar();
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->validar = new Validar();
    }

    //Vista de Inicio de La Gestión de Menús
    public function inicio()
    {

        try {
            //Llamamos a la clase del Navbar, que sólo se usa
            // en funciones para llamar vistas y la instaciamos
            $this->nav = new Navbar();
            $navs = $this->nav->listar_menus($this->encriptar->desencriptar($_SESSION['ru'], _FULL_KEY_));
            $id_usuario = $this->encriptar->desencriptar($_SESSION['c_u'],_FULL_KEY_);
            $id = $_GET['id'];
            $negocios = $this->negocio->listar_usuario($id_usuario);
            //$categorias = $this->categoria->listar_categorias();
            $negocios = $this->negocio->listarnegocio();
            $sucursal = $this->negocio->listar_sucursal($id_usuario);
            $usuario = $this->usuario->listar_usuarios();
            $rol = $this->rol->listar_roles_usuario();
            $almacenes = $this->almacen->listar_almacenes();
            $datos = $this->almacen->almacen($id);
            //$empresa_registrada = $this->empresa->listar_empresas_modal();
            //Hacemos el require de los archivos a usar en las vistas
            require _VIEW_PATH_ . 'header.php';
            require _VIEW_PATH_ . 'navbar.php';
            require _VIEW_PATH_ . 'almacen/inicio.php';
            require _VIEW_PATH_ . 'footer.php';
        } catch (Throwable $e) {
            //En caso de errores insertamos el error generado y redireccionamos a la vista de inicio
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            echo "<script language=\"javascript\">alert(\"Error Al Mostrar Contenido. Redireccionando Al Inicio\");</script>";
            echo "<script language=\"javascript\">window.location.href=\"" . _SERVER_ . "\";</script>";
        }
    }

    //Funciones
    //Agregar Nuevo Almacen
    public function guardar_nuevo_almacen()
    {
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_negocio', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('id_sucursal', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('almacen_nombre', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('almacen_capacidad', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('almacen_estado', 'POST', true, $ok_data, 4, 'numero', 0);

            //Validacion de datos
            if ($ok_data) {
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Almacen();
                        $microtime = microtime(true);
                        $model->almacen_nombre = $_POST['almacen_nombre'];
                        $model->almacen_capacidad = $_POST['almacen_capacidad'];
                        $model->almacen_estado = $_POST['almacen_estado'];
                        $model->id_negocio = $_POST['id_negocio'];
                        $model->id_sucursal = $_POST['id_sucursal'];
                        $model->almacencodigo = $microtime;
                        //Guardamos el menú y recibimos el resultado
                        $model->almacen_estado = $_POST['almacen_estado'];
                        $result = $this->almacen->guardar_almacen($model);

            }else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message)));
    }


    //Funcion usada para guardar la edicion del almacen
    public function guardar_edicion_almacen(){
        //Infomación del almacen
        $almacen = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_negocio_e', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('id_sucursal_e', 'POST', true, $ok_data, 11, 'numero', 0);
            $ok_data = $this->validar->validar_parametro('almacen_nombre_e', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('almacen_capacidad_e', 'POST', true, $ok_data, 100, 'texto', 0);
            $ok_data = $this->validar->validar_parametro('almacen_estado_e', 'POST', true, $ok_data, 4, 'numero', 0);

            //Validamos el id_menu y menu_estado, en caso este sea declarado para editar personas
            $ok_data = $this->validar->validar_parametro('id_almacen', 'POST',false,$ok_data,11,'numero',0);
            //Validacion de datos
            if($ok_data){
                //Creamos el modelo y ingresamos los datos a guardar
                $model = new Almacen();
                        $almacen = $this->almacen->listar_almacen($_POST['id_almacen']);
                        $model->id_almacen = $_POST['id_almacen'];
                        $model->id_negocio = $_POST['id_negocio_e'];
                        $model->id_sucursal = $_POST['id_sucursal_e'];
                        $model->almacen_nombre = $_POST['almacen_nombre_e'];
                        $model->almacen_capacidad = $_POST['almacen_capacidad_e'];
                        $model->almacen_estado = $_POST['almacen_estado_e'];
                        $result = $this->almacen->guardar_almacen($model);
                        if($result == 1){
                            $almacen = $this->almacen->listar_almacen($_POST['id_almacen']);

                        }
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "almacen" => $almacen)));
    }

    //Funcion para Eliminar almacen
    public function eliminar_almacen()
    {
        //Array donde vamos a almacenar los cambios, en caso hagamos alguno
        $almacen = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try {
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('id_almacen', 'POST', true, $ok_data, 11, 'numero', 0);
            //Validacion de datos
            if ($ok_data) {
                //Eliminamos el almacen

                $result = $this->almacen->eliminar_almacen($_POST['id_almacen']);
            } else {
                //Código 6: Integridad de datos erronea
                $result = 6;
                $message = "Integridad de datos fallida. Algún parametro se está enviando mal";
            }
        } catch (Exception $e) {
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this) . '|' . __FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode(array("result" => array("code" => $result, "message" => $message, "almacen" => $almacen)));
    }

    public function listar_negocio_por_id(){
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app

        try{
            $id_negocio = $_POST['id_negocio'];
            $result = $this->almacen->listar_sucursal_negocio($id_negocio);

            $datos = "<select class='form-control' id='id_sucursal' name='id_sucursal'>";
            foreach($result as $c){
                $datos.="<option value='". $c->id_sucursal."'>". $c->sucursal_nombre."</option>";
            }
        }catch (Exception $e){
            //Registramos el error generado y devolvemos el mensaje enviado por PHP
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $message = $e->getMessage();
        }
        //Retornamos el json
        echo json_encode($datos);
    }

}

