<?php

namespace princepines\FireworksPMnS;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

use BlockHorizons\Fireworks\item\Fireworks;
use BlockHorizons\Fireworks\entity\FireworksRocket;

class main extends PluginBase implements Listener
{

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("Fireworks Enabled");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        switch ($command->getName()) {
            case "launch":
                if ($sender instanceof Player) {
                    $fw = ItemFactory::get(Item::FIREWORKS);
                    $fw->addExplosion(Fireworks::TYPE_CREEPER_HEAD, Fireworks::COLOR_GREEN, "", false, false);
                    $fw->setFlightDuration(2);

                    // Use whatever level you'd like here. Must be loaded
                    $level = Server::getInstance()->getLevelByName("lobby")->getBlock(new Vector3(0.5, 1, 0.5));
                    $name = $level->getLevel();
                    if ($level->getId() === 98) {
                        // Choose some coordinates
                        //$vector3 = $level->->add(0.5, 1, 0.5);
                        // Create the NBT data
                        $nbt = FireworksRocket::createBaseNBT($level, new Vector3(0.001, 0.05, 0.001), lcg_value() * 360, 90);
                        // Construct and spawn
                        $entity = FireworksRocket::createEntity("FireworksRocket", $name, $nbt, $fw);
                        if ($entity instanceof FireworksRocket) {
                            $entity->spawnToAll();
                        }
                    }
                }
        }
        return 0;
    }

    public function onDisable()
    {
        $this->getLogger()->info("Fireworks Disabled");
    }
}