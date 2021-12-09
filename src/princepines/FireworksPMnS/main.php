<?php

namespace princepines\FireworksPMnS;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;


class main extends PluginBase implements Listener
{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("Fireworks Enabled");
    }

    public $tasks = [];

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "launch":
                if ($sender instanceof Player) {
                    $task = new FireworkTask();
                    $this->tasks[$sender->getId()] = $task;
                    $this->getScheduler()->scheduleDelayedRepeatingTask($task, 20,20);
                }
                break;
            case "stoplaunch":
                if ($sender instanceof Player) {
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