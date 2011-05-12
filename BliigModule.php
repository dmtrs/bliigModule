<?php
// We import the module level components immediately
Yii::import("bliig.models.*");
Yii::import("bliig.components.*");

/**
 * The bliig blog module.
 * @package application.modules.bliig
 */
class BliigModule extends CWebModule
{
	/**
	 * The default controller for this module
	 * @var string
	 */
	public $defaultController = "post";
	
	/**
	 * Called when the module is being created.
	 * Put any module specific configuration here
	 */
	public function init()
	{
			
	}
	/**
	 * This function is called before the controller action is run
	 * @param CController $controller The controller to run
	 * @param CAction $action The action to run on the controller
	 * @return boolean True if the action should be executed, false if the action should be stopped
	 */
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	/**
	 * Gets the database connection to use with this module
	 * If a separate connection is not specified, the application default
	 * will be used
	 * @return CDbConnection The database connection
	 */
	public function getDb() {
		$component = $this->getComponent("db");
		if ($component === null) {
			$component = Yii::app()->getDb();
		}
		return $component;
	}
	
	/**
	 * Sets the module level components
	 * @param array $components module components or instances
	 * @param boolean $merge whether to merge the new component configuration
	 * with the existing one. Defaults to true, meaning the previously
	 * registered component configuration of the same ID will be merged
	 * with the new configuration. If false, the existing configuration
	 * will be replaced completely.
	 */
	public function setComponents($components, $merge = true) {
		foreach($components as $id => $config) {
			if (is_array($config) && $id === "db" && !isset($config["class"])) {
				$components[$id]['class'] = "CDbConnection";
			}
		}
		return parent::setComponents($components, $merge);
	}
}
