<?php

namespace ZebraMC\GamilinoMC;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use ZebraMC\GamilinoMC\commands\StatsCommand;
use ZebraMC\GamilinoMC\listener\player\PlayerListener;

class Stats extends PluginBase
{
    use SingletonTrait;

    protected function onEnable(): void
    {
        self::setInstance($this);

        $this->registerListeners();
        $this->registerCommands();
    }

    protected function registerListeners(): void
    {
        $pm = Server::getInstance()->getPluginManager();

        $pm->registerEvents(new PlayerListener(), $this);
    }

    protected function registerCommands(): void
    {
        $map = Server::getInstance()->getCommandMap();

        $map->register("stats", new StatsCommand());
    }
}