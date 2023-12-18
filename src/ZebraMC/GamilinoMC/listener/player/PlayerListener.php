<?php

namespace ZebraMC\GamilinoMC\listener\player;

use JsonException;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use ZebraMC\GamilinoMC\api\StatsAPI;

class PlayerListener implements Listener
{
    /**
     * @throws JsonException
     */
    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();

        StatsAPI::getInstance()->createPlayer($player);
        StatsAPI::getInstance()->addJoin($player->getName());
    }

    /**
     * @throws JsonException
     */
    public function onDeath(PlayerDeathEvent $event): void
    {
        $player = $event->getPlayer();

        StatsAPI::getInstance()->addDeath($player->getName());
    }

    /**
     * @throws JsonException
     */
    public function onEntityDamageEvent(EntityDamageByEntityEvent $event): void
    {
        $entity = $event->getEntity();
        $damager = $event->getDamager();

        if ($entity && $damager instanceof Player) {
            if (($entity->getHealth() - $event->getFinalDamage()) <= 0) {
                StatsAPI::getInstance()->addKill($damager->getName());
                StatsAPI::getInstance()->addDeath($entity->getName());
            }
        }
    }
}