<?php
class EModuleActiveRecord extends CActiveRecord
{
    public function getDbConnection()
    {
        $db = Yii::app()->controller->module->db;
        return Yii::createComponent($db);
    }
}
