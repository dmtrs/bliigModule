<?php
/** 
 * EModuleActiveRecord
 * ===================
 * What would you do if you want/need to have a different than the main database connection in an module's models?
 *
 * ###How to use
 * Let's say we create a module with name test under the <code>protected/modules/</code> folder.
 *
 * ####Configuration
 * In your config file you can declare a module like:
 * ~~~
 * [php]
 *
 * 'modules'=>array(••••••
 *       'test'=>array(
 *          'db'=>array(
 *              'class'=>'CDbConnection',
 *              'connectionString'=>'sqlite:'.dirname(__FILE__).'/../modules/bliig/data/blog.db',
 *          ),                
 *      ),		
 * ~~~
 * __Important:__ The <code>'class'=>'CDbConnection'</code> is required, for this simple implementation.
 *
 * ####CModule
 * In your <code>TestModule.php</code> file ( the class that extends the <code>CModule</code> ) under the <code>protected/modules/test</code>
 * folder, declare a public property named db.
 * ~~~
 * [php]
 * class TestModule extends CModule
 * {
 *     public function $db;
 *     ...
 * }
 * ~~~
 * ####Your models
 * Then you have to simple change the <code>CActiveRecord</code> class your module's models extends to <code>EModuleActiveRecord</code>
 *
 * ####Last but not least
 * Make sure you import the <code>EModuleActiveRecord</code>. If you have generated the module with gii, just add file under the 
 * components or models folder.
 *
 * ###Notes
 * In this scenario we had a module that we wanted to change database for, but the extension of the <code>CActiveRecord</code> and the 
 * override of the <code>getDdConnection()</code> is common general a common case.
 *
 * ###Resources
 * - [while(true) blog](http://dmtrs.devio.us/blog/index.php/post/27/%7Byii%7D+%7Bwiki%7D+A+simple+class+to+use+a+different+db+for+a+module)
 *
 * @author Dimitrios Mengidis
 */
class EModuleActiveRecord extends CActiveRecord
{
    public function getDbConnection()
    {
        $db = Yii::app()->controller->module->db;
        return Yii::createComponent($db);
    }
}
