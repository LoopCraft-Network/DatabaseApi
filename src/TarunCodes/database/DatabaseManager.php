<?php

namespace TarunCodes\database;

use pocketmine\player\Player;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;
use poggit\libasynql\SqlError;
use TarunCodes\DatabaseApi;

class DatabaseManager {
	public DataConnector $database;
	private DatabaseApi $plugin;

	public static array $playerdata = [];


	public function __construct(DatabaseApi $plugin) {
		$this->plugin = $plugin;
		$this->init();
	}

	private function init(): void {
		$config = [
			"type" => "mysql",
			"mysql" => [
				"host" => $this->plugin->getConfig()->get("mysql-host"),
				"username" => $this->plugin->getConfig()->get("mysql-user"),
				"password" => $this->plugin->getConfig()->get("mysql-password"),
				"schema" => $this->plugin->getConfig()->get("mysql-database")
			]
		];

		$this->database = libasynql::create($this->plugin, $config, [
			"mysql" => "mysql/schema.sql"
		]);

		$this->database->executeGeneric("playerdata.init");

		$this->database->waitAll();
	}

	public function registerPlayer(Player $player, callable $callback = null): void {
		$name = $player->getName();

		$this->database->executeSelect("playerdata.get", [
			"name" => $name
		], function(array $rows) use ($name, $callback) {
			if (count($rows) === 0) {
				$this->database->executeInsert("playerdata.register", [
					"name" => $name,
					"kills" => 0,
					"death" => 0,
					"coin" => 0
				]);
			}
		});
	}

	public  function initPlayerData(Player $player): void {
		$this->database->executeSelect("playerdata.get", [
			"name" => $player->getName()
		], function(array $rows) use ($player) {
			if (count($rows) > 0) {
				$data = $rows[0];
				self::$playerdata[$player->getName()] = [
					"Kill" => (int)$data["Kills"],
					"Death" => (int)$data["Death"],
					"Coin" => (int)$data["Coin"]
				];
			}
		});
	}

	public  function getPlayerKill(Player $player): int {
		if (!isset(self::$playerdata[$player->getName()])) {
			self::initPlayerData($player);
			return 0;
		}
		return self::$playerdata[$player->getName()]["Kill"] ?? 0;
	}

	public  function getPlayerDeath(Player $player): int {
		if (!isset(self::$playerdata[$player->getName()])) {
			self::initPlayerData($player);
			return 0;
		}
		return self::$playerdata[$player->getName()]["Death"] ?? 0;
	}

	public  function getPlayerCoin(Player $player): int {
		if (!isset(self::$playerdata[$player->getName()])) {
			self::initPlayerData($player);
			return 0;
		}
		return self::$playerdata[$player->getName()]["Coin"] ?? 0;
	}

	public  function loadData(Player $player): void {
		$this->database->executeSelect("playerdata.get", [
			"name" => $player->getName()
		], function(array $rows) use ($player) {
			if (count($rows) > 0) {
				$data = $rows[0];
				self::$playerdata[$player->getName()] = [
					"Kill" => (int)$data["Kills"],
					"Death" => (int)$data["Death"],
					"Coin" => (int)$data["Coin"]
				];
			}
		});
	}

	public  function addPlayerKill(Player $player): void {
		$newKills = self::getPlayerKill($player) + 1;
		self::$playerdata[$player->getName()]["Kill"] = $newKills;

		$this->database->executeChange("playerdata.updateKills", [
			"name" => $player->getName(),
			"kills" => $newKills
		]);
	}

	public  function addPlayerDeath(Player $player): void {
		$newDeaths = self::getPlayerDeath($player) + 1;
		self::$playerdata[$player->getName()]["Death"] = $newDeaths;

		$this->database->executeChange("playerdata.updateDeaths", [
			"name" => $player->getName(),
			"deaths" => $newDeaths
		]);
	}

	public  function addPlayerCoin(Player $player, int $amount): void {
		$newCoins = self::getPlayerCoin($player) + $amount;
		self::$playerdata[$player->getName()]["Coin"] = $newCoins;

		$this->database->executeChange("playerdata.updateCoins", [
			"name" => $player->getName(),
			"coins" => $newCoins
		]);
	}

	public  function reducePlayerCoin(Player $player, int $coin): void {
		$newCoins = self::getPlayerCoin($player) - $coin;
		self::$playerdata[$player->getName()]["Coin"] = $newCoins;

		$this->database->executeChange("playerdata.updateCoins", [
			"name" => $player->getName(),
			"coins" => $newCoins
		]);
	}


	public function close(): void {
		if (isset($this->database)) {
			$this->database->close();
		}
	}
}