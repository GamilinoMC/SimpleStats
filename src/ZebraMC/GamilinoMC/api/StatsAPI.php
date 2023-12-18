<?php

namespace ZebraMC\GamilinoMC\api;

use JsonException;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use ZebraMC\GamilinoMC\Stats;

class StatsAPI
{
    use SingletonTrait;

    /**
     * @throws JsonException
     */
    public function createPlayer(Player $player): void
    {
        $config = new Config(Stats::getInstance()->getDataFolder() . "stats.yml", Config::YAML);

        if (!$config->exists(strtolower($player->getName()))) {
            $config->setNested(strtolower($player->getName()) . ".joins", 0);
            $config->setNested(strtolower($player->getName()) . ".kills", 0);
            $config->setNested(strtolower($player->getName()) . ".deaths", 0);
        }
        $config->save();
        $config->reload();
    }

    public function doesPlayerExist(string $playername): bool
    {
        $config = new Config(Stats::getInstance()->getDataFolder() . "stats.yml", Config::YAML);

        if ($config->exists(strtolower($playername))) {
            return true;
        } else return false;
    }

    /**
     * @throws JsonException
     */
    public function addJoin(string $playername): void
    {
        $config = new Config(Stats::getInstance()->getDataFolder() . "stats.yml", Config::YAML);

        $config->setNested(strtolower($playername) . ".joins", $this->getJoins($playername) +1);
        $config->save();
        $config->reload();
    }

    /**
     * @throws JsonException
     */
    public function addKill(string $playername): void
    {
        $config = new Config(Stats::getInstance()->getDataFolder() . "stats.yml", Config::YAML);

        $config->setNested(strtolower($playername) . ".kills", $this->getKills($playername) +1);
        $config->save();
        $config->reload();
    }

    /**
     * @throws JsonException
     */
    public function addDeath(string $playername): void
    {
        $config = new Config(Stats::getInstance()->getDataFolder() . "stats.yml", Config::YAML);

        $config->setNested(strtolower($playername) . ".deaths", $this->getDeaths($playername) +1);
        $config->save();
        $config->reload();
    }

    public function getJoins(string $playername): ?int
    {
        $config = new Config(Stats::getInstance()->getDataFolder() . "stats.yml", Config::YAML);

        return $config->getNested(strtolower($playername) . ".joins");
    }

    public function getKills(string $playername): ?int
    {
        $config = new Config(Stats::getInstance()->getDataFolder() . "stats.yml", Config::YAML);

        return $config->getNested(strtolower($playername) . ".kills");
    }

    public function getDeaths(string $playername): ?int
    {
        $config = new Config(Stats::getInstance()->getDataFolder() . "stats.yml", Config::YAML);

        return $config->getNested(strtolower($playername) . ".deaths");
    }
}