<?php

class Egresos
{
    private $pdo;
    private $log;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->log = new Log();
    }


    public function guardar_egresos($model){
        try{
            if(isset($model->id_movimiento)){
                $sql = 'update movimientos set
                        id_usuario = ?,
                        id_sucursal = ?,
                        movimiento_tipo = ?,
                        egreso_descripcion = ?,
                        egreso_monto = ?,
                        egreso_fecha_registro = ?
                        where id_movimiento = ?';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_usuario,
                    $model->id_sucursal,
                    $model->movimiento_tipo,
                    $model->egreso_descripcion,
                    $model->egreso_monto,
                    $model->egreso_fecha_registro,
                    $model->id_movimiento
                ]);
            } else {
                $sql = 'insert into movimientos (id_usuario,id_caja_numero, id_sucursal,movimiento_tipo, egreso_descripcion, egreso_monto, egreso_fecha_registro, egreso_estado) 
                        values (?,?,?,?,?,?,?,?)';
                $stm = $this->pdo->prepare($sql);
                $stm->execute([
                    $model->id_usuario,
                    $model->id_caja_numero,
                    $model->id_sucursal,
                    $model->movimiento_tipo,
                    $model->egreso_descripcion,
                    $model->egreso_monto,
                    $model->egreso_fecha_registro,
                    $model->egreso_estado
                ]);
            }
            return 1;
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return 2;
        }
    }


    public function listar_egresos(){
        try{
            $sql = 'select * from movimientos e inner join sucursal s on e.id_sucursal = s.id_sucursal where egreso_estado = 1 order by egreso_fecha_registro desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }

    public function listar_egresos_filtro($fecha_filtro,$fecha_filtro_fin){
        try{
            $sql = 'select * from movimientos e inner join sucursal s on e.id_sucursal = s.id_sucursal where date(egreso_fecha_registro) 
                    between  ? and  ? and egreso_estado = 1 order by egreso_fecha_registro desc';
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$fecha_filtro,$fecha_filtro_fin]);
            return $stm->fetchAll();
        } catch (Throwable $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            return [];
        }
    }


    public function eliminar_egreso($id_movimiento){
        try {
            $sql = "update movimientos set
                egreso_estado = 0
                where id_movimiento = ?";

            $stm = $this->pdo->prepare($sql);
            $stm->execute([
                $id_movimiento
            ]);
            $result = 1;
        }catch (Exception $e){
            $this->log->insertar($e->getMessage(), get_class($this).'|'.__FUNCTION__);
            $result = 2;
        }
        return $result;
    }

}