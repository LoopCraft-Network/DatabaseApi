<?php

namespace TarunCodes;

use pocketmine\plugin\PluginBase;
use TarunCodes\database\DatabaseManager;

class DatabaseApi extends PluginBase {

	public static self $instance;
	public DatabaseManager $database;


	public function onLoad(): void
	{
		self::$instance = $this;
	}

	public static function getInstance() : self {
		return self::$instance;
	}

	public function onEnable(): void {
		$this->database = new DatabaseManager($this);
	}

	public function getDatabase() : DatabaseManager {
		return $this->database;
	}

	public function onDisable(): void {
		$this->database->close();
	}
}