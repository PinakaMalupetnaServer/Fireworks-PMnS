<?php


namespace princepines\FireworksPMnS;


use BlockHorizons\Fireworks\entity\FireworksRocket;
use BlockHorizons\Fireworks\item\Fireworks;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class FireworkTask extends Task
{

    /**
     * @inheritDoc
     */
    public function onRun(int $currentTick)
    {
        $min = 1;
        $max = 3;
        /** @var Fireworks $fw */
        $fw = ItemFactory::get(Item::FIREWORKS);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_BLACK, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_RED, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_DARK_GREEN, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_BROWN, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_BLUE, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_DARK_PURPLE, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_DARK_AQUA, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_GRAY, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_DARK_GRAY, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_PINK, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_GREEN, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_YELLOW, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_LIGHT_AQUA, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_DARK_PINK, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_GOLD, "", false, true);
        $fw->addExplosion(Fireworks::TYPE_HUGE_SPHERE, Fireworks::COLOR_WHITE, "", false, true);
        $fw->setFlightDuration(mt_rand($min, $max));

        // Use whatever level you'd like here. Must be loaded
        $level = Server::getInstance()->getLevelByName("lobby");
        $posArray = [new Vector3(262, 72, 341), new Vector3(262, 72, 334), new Vector3(262, 72, 321), new Vector3(262, 72, 310)];
        foreach ($posArray as $array) {
            $getBlockPos = $level->getBlock($array);
            // Choose some coordinates
            $pos = $getBlockPos->add(0.5, 1, 0.5);
            //$vector3 = $level->getSpawnLocation()
            // Create the NBT data
            $nbt = FireworksRocket::createBaseNBT($pos, new Vector3(0.001, 0.05, 0.001), lcg_value() * 360, 90);
            // Construct and spawn
            $entity = FireworksRocket::createEntity("FireworksRocket", $level, $nbt, $fw);
            if ($entity instanceof FireworksRocket) {
                $entity->spawnToAll();
            }
        }
    }
}