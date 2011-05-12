<?php
class EModuleActiveRecord extends CActiveRecord
{
    public function getDbConnection()
    {
        return Yii::app()->controller->module->db;
    }
}
