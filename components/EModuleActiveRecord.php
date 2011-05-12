<?php
class EModuleActiveRecord extends CActiveRecord
{
    public function getDbConnection()
    {
        $moduleDb = new CDbConnection(Yii::app()->controller->module->db);
        $moduleDb->active = true;
        return $moduleDb;
    }
}
