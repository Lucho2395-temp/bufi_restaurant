<?php
/**
 * Created by PhpStorm
 * User: CESARJOSE39
 * Date: 12/10/2020
 * Time: 17:28
 */

class LoginController{
    //Variables fijas para cada llamada al controlador
    private $log;
    private $sesion;
    private $encriptar;
    private $validar;
    public function __construct()
    {
        //Instancias fijas para cada llamada al controlador
        $this->log = new Log();
        $this->sesion = new Sesion();
        $this->encriptar = new Encriptar();
        $this->validar = new Validar();
    }
    //Vistas/Opciones
    //Vista de acceso al login
    public function inicio(){
        require _VIEW_PATH_ . 'login/inicio.php';
    }
    //Funciones/Permisos
    //Funcion para validar la sesión del usuario y generar las variables de $_SESSION o enviar el array de datos del usuario
    public function validar_sesion(){
        //Array donde irán los datos del usuario en caso de que el inicio de sesión sea desde una app
        $usuario = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('usuario_nickname', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_contrasenha', 'POST',true,$ok_data,32,'texto',0);
            //Validacion de datos
            if($ok_data){
                //Consultamos los datos del usuario en base al nickname enviado
                $usuario = $this->sesion->consultar_usuario($_POST['usuario_nickname']);
                //Verificamos si existe algún usuario con el nickname consultado,
                //caso contrario devolvemos error de validacion
                if(isset($usuario->id_usuario)){
                    //Validamos el hash de contraseña con la que envió el usuario. Si devuelve true, quiere decir que la validación fue exitosa
                    if(password_verify($_POST['usuario_contrasenha'], $usuario->usuario_contrasenha)){
                        //Verificacion de licencia de funcionamiento
                        if ($this->key_validation()==true){
                            //Registramos el inicio de sesión del usuario
                            $this->sesion->ultimo_logueo($usuario->id_usuario);
                            //Verificamos si la consulta se hizo desde una app
                            if(isset($_POST['app']) && $_POST['app'] == true){
                                $usuario = array(
                                    "c_u" => $usuario->id_usuario,
                                    "c_p" => $usuario->id_persona,
                                    "_n" => $usuario->usuario_nickname,
                                    "u_e" => $usuario->usuario_email,
                                    "u_i" => _SERVER_ . $usuario->usuario_imagen,
                                    "p_n" => $usuario->persona_nombre,
                                    "p_p" => $usuario->persona_apellido_paterno,
                                    "p_m" => $usuario->persona_apellido_materno,
                                    "ru" => $usuario->id_rol,
                                    "rn" => $usuario->rol_nombre,
                                    "tn" => $this->encriptar->encriptacion_triple($usuario->usuario_contrasenha, $usuario->id_usuario, $usuario->usuario_creacion)
                                );
                            } else {
                                //Validamos si el usuario seleccionó la opción de recordar contraseña
                                if(isset($_POST['recordar']) && $_POST['recordar'] == "true"){
                                    //Generamos la sesión del usuario usando cookies
                                    $this->sesion->generar_sesion($usuario, true);
                                } else {
                                    //Generamos la sesión del usuario sin usar cookies
                                    $this->sesion->generar_sesion($usuario);
                                }
                            }
                            //Devolvemos 1 para indicar que todo salió bien
                            $result = 1;
                        } else {
                            $result = 7;
                        }
                    } else {
                        //Código 3: Usuario o contraseña incorrectos
                        $usuario = [];
                        $result = 3;
                        $message = "Usuario o contraseña incorrectos";
                    }
                } else {
                    //Código 3: Usuario o contraseña incorrectos
                    $usuario = [];
                    $result = 3;
                    $message = "Usuario o contraseña incorrectos";
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
        //Si esta declarada la variable $_POST['app'], devolvemos el json que será consumido como ws,
        // caso contrario, sólo retornamos los códigos
        if(isset($_POST['app']) && $_POST['app'] == true){
            $data = array(
                "result" => array("code" => $result, "message" => $message),
                "data" => $usuario);
        } else {
            $data = array("result" => array("code" => $result, "message" => $message));
        }
        //Retornamos el json
        echo json_encode($data);
    }

    public function validar_sesion_app(){
        //Array donde irán los datos del usuario en caso de que el inicio de sesión sea desde una app
        $usuario = [];
        //Código de error general
        $result = 2;
        //Mensaje a devolver en caso de hacer consulta por app
        $message = 'OK';
        try{
            $ok_data = true;
            //Validamos que todos los parametros a recibir sean correctos. De ocurrir un error de validación,
            //$ok_true se cambiará a false y finalizara la ejecucion de la funcion
            $ok_data = $this->validar->validar_parametro('usuario_nickname', 'POST',true,$ok_data,16,'texto',0);
            $ok_data = $this->validar->validar_parametro('usuario_contrasenha', 'POST',true,$ok_data,32,'texto',0);
            //Validacion de datos
            if($ok_data){
                //Consultamos los datos del usuario en base al nickname enviado
                $usuario = $this->sesion->consultar_usuario_app($_POST['usuario_nickname']);
                //Verificamos si existe algún usuario con el nickname consultado,
                //caso contrario devolvemos error de validacion
                if(isset($usuario->id_usuario)){
                    //Validamos el hash de contraseña con la que envió el usuario. Si devuelve true, quiere decir que la validación fue exitosa
                    if(password_verify($_POST['usuario_contrasenha'], $usuario->usuario_contrasenha)){
                        //Verificacion de licencia de funcionamiento
                        if ($this->key_validation()==true){
                            //Registramos el inicio de sesión del usuario
                            $this->sesion->ultimo_logueo($usuario->id_usuario);
                            //Verificamos si la consulta se hizo desde una app
                            if(isset($_POST['app']) && $_POST['app'] == true){
                                $usuario = array(
                                    "c_u" => $usuario->id_usuario,
                                    "c_p" => $usuario->id_persona,
                                    "_n" => $usuario->usuario_nickname,
                                    "u_e" => $usuario->usuario_email,
                                    "u_i" => _SERVER_ . $usuario->usuario_imagen,
                                    "p_n" => $usuario->persona_nombre,
                                    "p_p" => $usuario->persona_apellido_paterno,
                                    "p_m" => $usuario->persona_apellido_materno,
                                    "ru" => $usuario->id_rol,
                                    "rn" => $usuario->rol_nombre,
                                    "n_i" => $usuario->id_negocio,
                                    "n_n" => $usuario->negocio_nombre,
                                    "n_f" => $usuario->negocio_foto,
                                    "n_r" => $usuario->negocio_ruc,
                                    "i_d" => $usuario->id_sucursal,
                                    "tn" => $this->encriptar->encriptacion_triple($usuario->usuario_contrasenha, $usuario->id_usuario, $usuario->usuario_creacion)
                                );
                            } else {
                                //Validamos si el usuario seleccionó la opción de recordar contraseña
                                if(isset($_POST['recordar']) && $_POST['recordar'] == "true"){
                                    //Generamos la sesión del usuario usando cookies
                                    $this->sesion->generar_sesion($usuario, true);
                                } else {
                                    //Generamos la sesión del usuario sin usar cookies
                                    $this->sesion->generar_sesion($usuario);
                                }
                            }
                            //Devolvemos 1 para indicar que todo salió bien
                            $result = 1;
                        } else {
                            $result = 7;
                        }
                    } else {
                        //Código 3: Usuario o contraseña incorrectos
                        $usuario = [];
                        $result = 3;
                        $message = "Usuario o contraseña incorrectos";
                    }
                } else {
                    //Código 3: Usuario o contraseña incorrectos
                    $usuario = [];
                    $result = 3;
                    $message = "Usuario o contraseña incorrectos";
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
        //Si esta declarada la variable $_POST['app'], devolvemos el json que será consumido como ws,
        // caso contrario, sólo retornamos los códigos
        if(isset($_POST['app']) && $_POST['app'] == true){
            $data = array(
                "result" => array("code" => $result, "message" => $message),
                "data" => $usuario);
        } else {
            $data = array("result" => array("code" => $result, "message" => $message));
        }
        //Retornamos el json
        echo json_encode($data);
    }

    //FUNCIONES PARA LA LICENCIA DEL SISTEMA
    private function key_validation()
    {
        //$ruta = $this->encrypt_lic('0FG8-R12H-YY20C23C',_FULL_KEY_);
        $dir_env_file='.env';
        /* Verificamos la existencia del archivo */
        if(!file_exists($dir_env_file)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $dir_env_file));
        }
        $this->path = $dir_env_file;
        /* Verificamos si el archivo se puede leer */
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }
        /* Obtenemos la primera linea  */
        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        /* desencriptar la linea  */
        $licencia = $this->encrypt_lic('2F8G-0RT9Y-20RC25C',_FULL_KEY_);
        $lcs = $this->decrypt($lines[0],_FULL_KEY_);
        $dsr =$this->decrypt_date($lcs);

        /*$ruta = $this->encrypt_lic('2FG0-R1T0-YY20-C23C',_FULL_KEY_);*/

        $act= date('Y-m-d',strtotime($dsr));
        $_SESSION['lic']=$act;
        $dtnow = date('Y-m-d');

        // Comparar fechas usando objetos DateTime para una comparación más precisa
        $fechaLicencia = new DateTime($act);
        $fechaActual = new DateTime($dtnow);

        if ($fechaLicencia > $fechaActual) {
            // La licencia es válida
            return true;
        }  else {
            // La licencia ha caducado, hacer una consulta a la API
            /*$apiUrl = 'URL_DE_TU_API_AQUI';
            $response = file_get_contents($apiUrl);*/
            $response = array(
                'system'=>'https://bufeotec.com',
                'licencia_text'=>'bc4FgfYH5gVJ1IreB0MJLLD90tg9rSvDdyGvJN5sHQbNb88tqexmXvA4KhpE/snd2lauuZCXqOkhq6BvA5mdOQ==',
                'licence_text_new'=>'casa'
            );
            $data_s = $response['system'];
            /*$responseData = json_decode($response, true);*/
            if ($response){
                if($response['system']==_MYSITE_ ){
                    /* Entra si el sistema es parte de la base de datos de bufeo  */
                    if ($response['licence_text']!=$response['licence_text_new']){
                        /*  si la licencias no son iguales, entonces no se actualizo  */
                        /* Entonces se actualiza el archivo env por el nuevo codigo */
                        /* lectura del archivo env */
                        $envFilePath = '.env';
                        $envContent = file_get_contents($envFilePath);
                        $pattern = '/' . preg_quote($response['licence_text_new'], '/') . '/';
                        $envContent = preg_replace($pattern, $response['licencia_text'], $envContent);
                        /*  Entonces actualizamos la licencia */
                        file_put_contents($envFilePath, $envContent);
                    }
                }else{
                    throw new \RuntimeException(sprintf('%s no update system env', $this->path));
                }
            }
            // Devolver false o la respuesta procesada de la API según corresponda
            return false;
        }
    }
    private function decrypt_date($cadena) {
        return filter_var($cadena, FILTER_SANITIZE_NUMBER_INT);
    }
    private function decrypt($ciphertext_base64, $key) {
        $ciphertext = base64_decode($ciphertext_base64);
        $block_size = openssl_cipher_iv_length('AES-256-CBC');
        $iv = substr($ciphertext, 0, $block_size);
        $ciphertext = substr($ciphertext, $block_size);
        $text = openssl_decrypt($ciphertext, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        $padding = ord($text[strlen($text) - 1]);
        $text = substr($text, 0, -$padding);
        $text = utf8_decode($text);
        return $text;
    }
    private function encrypt_lic($text, $key) {
        // Rellena el texto para que sea múltiplo de 16 bytes
        $text = utf8_encode($text);
        $block_size = openssl_cipher_iv_length('AES-256-CBC');
        $padding = $block_size - (strlen($text) % $block_size);
        $text .= str_repeat(chr($padding), $padding);
        // Crea el objeto de cifrado
        $iv = random_bytes($block_size); // Vector de inicialización (debe ser aleatorio)
        $ciphertext = openssl_encrypt($text, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        // Codifica el resultado en base64
        $ciphertext_base64 = base64_encode($iv . $ciphertext);
        return $ciphertext_base64;
    }
}
