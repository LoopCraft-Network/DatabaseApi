<?php

namespace TarunCodes;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;

class EventListener implements Listener {

	public function onLogin(PlayerLoginEvent $event) {
		$player = $event->getPlayer();
		DatabaseApi::getInstance()->getDatabase()->registerPlayer($player);
	}

	public function onJoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		DatabaseApi::getInstance()->getDatabase()->loadData($player);
	}
}