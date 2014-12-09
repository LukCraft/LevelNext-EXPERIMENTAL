<?php

namespace Praxthisnovcht\utils\NextLevel;

// The source comes from Tschrock https://github.com/Tschrock/PM-XPerience

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\item\item;
use 

/**
 * NextLevel
 */
class NextLevel extends PluginBase {,
	public function onLoad() {
	
	}
tmine\plugin\PluginBase::onEnable()
	 */
	public function onEnable() {
		$this->enabled = true;
        $this->getServer()->getPluginManager()->registerEvents(new NextLevelListener($this), $this);
		$this->log ( TextFormat::GREEN . "- NextLevel - Enabled!" );
		$this->loadConfig ();
	}
	public function onDisable() {
		$this->log ( TextFormat::RED . "NextLevel - Disabled" );
		$this->enabled = false;
	}
	
    public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
        switch ($command->getName()) {
            case "xp":
                if ($sender instanceof \pocketmine\Player) {
                    NextLevelData::showLevelBarTo($sender);
                }
                return true;
            case "upgrade":
                if ($sender instanceof \pocketmine\Player && (count($args) == 0 || count($args) == 1)) {

                    $item = $sender->getInventory()->getItemInHand();
                    $upgrade = NextLevelData::getItemUpgrade($item);

                    if ($upgrade[1] == false) {
                        $sender->sendMessage(TextFormat::RED ."[ScMCPE] You can't upgrade that!");
                    } elseif (count($args) == 0) {
                        if (NextLevelData::getXP($sender) < $upgrade[1]) {
                            $sender->sendMessage(TextFormat::RED ."[ScMCPE] You dont have enough xp to upgrade that!");
                            $sender->sendMessage(TextFormat::RED ."[ScMCPE] You need " . $upgrade[1] . " xp to upgrade " . $item->getName() . " to " . $upgrade[0]->getName() . ".");
                        } else {
                            XPerienceAPI::removeXP($sender, $upgrade[1]);
                            $sender->getInventory()->setItemInHand($upgrade[0]);
                            $sender->sendMessage(TextFormat::GREEN ."[ScMCPE] upgraded " . $item->getName() . " to " . $upgrade[0]->getName() . " for " . $upgrade[1] . " xp.");
                        }
                    } elseif (count($args) == 1 && ($args[0] == "view" || $args[0] == "cost")) {
                        $sender->sendMessage(TextFormat::RED ."[ScMCPE] You will need " . $upgrade[1] . " xp to upgrade " . $item->getName() . " to " . $upgrade[0]->getName() . ".");
                    } else {
                        $sender->sendMessage(TextFormat::YELLOW ."Usage: /upgrade [view]");
                    }
                }
                return true;
            case "repair":
                if ($sender instanceof \pocketmine\Player && (count($args) == 0 || count($args) == 1)) {

                    $item = $sender->getInventory()->getItemInHand();

                    $repairCost = XPerienceAPI::getItemRepairCost($item);

                    if ($repairCost == false) {
                        $sender->sendMessage(TextFormat::RED ."[ScMCPE] You can't repair that!");
                    } elseif (count($args) == 0) {
                        if (XPerienceAPI::getXP($sender) < $repairCost) {
                            $sender->sendMessage(TextFormat::RED ."[ScMCPE] You dont have enough xp to repair that!");
                            $sender->sendMessage(TextFormat::RED ."[ScMCPE] You need " . $repairCost . " xp to fix " . $item->getName() . ".");
                        } else {
                            XPerienceAPI::removeXP($sender, $repairCost);
                            $item->setDamage(0);
                            $sender->getInventory()->setItemInHand($item);
                            $sender->sendMessage(TextFormat::GREEN ."[ScMCPE] fixed " . $item->getName() . " for " . $repairCost . " xp.");
                        }
                    } elseif (count($args) == 1 && ($args[0] == "view" || $args[0] == "cost")) {
                        $sender->sendMessage(TextFormat::RED ."[ScMCPE] You will need " . $repairCost . " xp to repair " . $item->getName() . ".");
                    } else {
                        $sender->sendMessage(TextFormat::YELLOW ."Usage: /repair [view]");
                    }
                }
                return true;
            default:
                return false;
        }
    }

}
