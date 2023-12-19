<?php

namespace ZebraMC\GamilinoMC\form;

use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Input;
use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use pocketmine\player\Player;
use ZebraMC\GamilinoMC\api\StatsAPI;

class MainForm extends MenuForm
{
    public function __construct()
    {
        parent::__construct(
            "§3Stats",
            "",
            [
                new MenuOption("§l§eYour Stats\n§r§8View your Stats"),
                new MenuOption("§l§aOther Player's Stats§r\n§8View other Player's Stats")
            ],
            function (Player $player, int $data): void {
                if ($data === 0) {
                    $mystatsform = (new MenuForm(
                        "§3Stats",
                        "§7Joins: §e" . StatsAPI::getInstance()->getJoins(strtolower($player->getName())) . "\n\n§7Kills: §e" . StatsAPI::getInstance()->getKills(strtolower($player->getName())) . "\n§7Deaths: §e" . StatsAPI::getInstance()->getDeaths(strtolower($player->getName())),
                        [
                            new MenuOption("§cClose")
                        ],
                        function (Player $player, int $data): void {

                        })
                    );
                    $player->sendForm($mystatsform);
                }
                if ($data === 1) {
                    $inputForm = (new CustomForm(
                        "§aOther Player",
                        [
                            new Input("playername", "§2Please enter a other player's name to continue!")
                        ],
                        function (Player $player, CustomFormResponse $response): void {
                            $nameinput = $response->getString("playername");

                            if (StatsAPI::getInstance()->doesPlayerExist($nameinput)) {
                                $otherplayerstats = (new MenuForm(
                                    $nameinput,
                                    "§7Joins: §e" . StatsAPI::getInstance()->getJoins($nameinput) . "\n\n§7Kills: §e" . StatsAPI::getInstance()->getKills($nameinput) . "\n§7Deaths: §e" . StatsAPI::getInstance()->getDeaths($nameinput),
                                    [
                                        new MenuOption("§cClose")
                                    ],
                                    function (Player $player, int $data): void {

                                    })
                                );
                                $player->sendForm($otherplayerstats);
                            } else $player->sendMessage("§cThat player does not exist!");
                        })
                    );
                    $player->sendForm($inputForm);
                }
            }
        );
    }
}
