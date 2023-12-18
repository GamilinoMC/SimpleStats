<?php

namespace ZebraMC\GamilinoMC\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use ZebraMC\GamilinoMC\form\MainForm;

class StatsCommand extends Command
{
    public function __construct()
    {
        parent::__construct("stats", "Stats Command", "/stats");
        $this->setPermission("stats.cmd");
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return void
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (!$sender instanceof Player) return;

        if ($sender->hasPermission("stats.cmd")) {
            $sender->sendForm(new MainForm());
        }
    }
}