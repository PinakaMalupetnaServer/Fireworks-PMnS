<?php

namespace princepines\FireworksPMnS;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;


class main extends PluginBase implements Listener
{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("Fireworks Enabled");
    }

    public $tasks = [];

    public static function playMusic(Player $player, string $soundName, float $volume = 0, float $pitch = 0) {
        $pk = new PlaySoundPacket;
        $pk->soundName = $soundName;
        $pk->x = (int)$player->x;
        $pk->y = (int)$player->y;
        $pk->z = (int)$player->z;
        $pk->volume = $volume;
        $pk->pitch = $pitch;
        $player->dataPacket($pk);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "launch":
                if ($sender instanceof Player) {
                    foreach($this->getServer()->getOnlinePlayers() as $players) {
                        self::playMusic($players, "medley", 1, 1);
                    }
                    $sender->sendMessage("Fireworks Starting.");
                    $task = new FireworkTask();
                    $this->tasks[$sender->getId()] = $task;
                    $this->getScheduler()->scheduleDelayedRepeatingTask($task, 20,20);
                }
                break;
            case "stoplaunch":
                if ($sender instanceof Player) {
                    $player = $this->getServer()->getOnlinePlayers();
                    $sender->sendMessage("Fireworks Stopping.");
                    $task = $this->tasks[$sender->getId()];
                    unset($this->tasks[$sender->getId()]);
                    $task->getHandler()->cancel();
                }
                break;
        }
        return 0;
    }

    public function onDisable()
    {
        $this->getLogger()->info("Fireworks Disabled");
    }
}