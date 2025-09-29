<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 12/03/2021
 * Time: 10:30
 */

class Almacen{
    private $pdo;
    private $log;
    public function __construct(){
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }
    public function listar_almacenes(){
        try{
            $sql = 'select * from almacenes a inner join negocios n on a.id_negocio = n.id_negocio inner join sucursal s on a.id_sucursal = s.id_sucursal  order by rand()';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function almacen($id){
        try{
            $sql = 'select * from almacenes WHERE id_almacen = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //Registrar nuevo almacen
    public function guardar_almacen($model){
        try{
            if(isset($model->id_almacen)){
                $sql = 'update almacenes set
                        almacen_nombre = ?,
                        almacen_capacidad = ?,
                        almacen_estado = ?,
                        id_negocio = ?,
                        id_sucursal = ?
                        where id_almacen = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->almacen_nombre,
                    $model->almacen_capacidad,
                    $model->almacen_estado,
                    $model->id_negocio,
                    $model->id_sucursal,
                    $model->id_almacen
                ]);
            } else {
                $sql = 'insert into almacenes (id_negocio, id_sucursal, almacen_nombre, almacen_capacidad, almacen_estado) values (?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_negocio,
                    $model->id_sucursal,
                    $model->almacen_nombre,
                    $model->almacen_capacidad,
                    $model->almacen_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    //Lista la información del almacen según id
    public function listar_almacen($id_almacen){
        try{
            $sql = 'select * from almacenes a inner join negocios n on a.id_negocio = n.id_negocio inner join sucursal s on a.id_sucursal = s.id_surcursal where a.id_almacen = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_almacen]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    //Eliminar almacen
    public function eliminar_almacen($id_almacen){
        try{
            $sql = 'delete from almacenes where id_almacen = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id_almacen]);
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }

    public function listar_sucursal_negocio($id){
        try{
            $sql = 'select * from sucursal where id_negocio = ?';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$id]);
            $result = $stm->fetchAll();

        } catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = [];
        }
        return $result;
    }

}