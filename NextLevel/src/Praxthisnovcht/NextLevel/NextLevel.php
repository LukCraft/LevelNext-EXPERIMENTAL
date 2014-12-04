<?php

namespace Praxthisnovcht\utils\NextLevel;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use 

/**
 * NextLevel
 */
class NextLevel extends PluginBase {,

    /**
     * The onLoad function - empty.
     */
	public function onLoad() {
	
	}
	
	/**
	 * OnEnable
	 *
	 * (non-PHPdoc)
	 * 
	 * @see \pocketmine\plugin\PluginBase::onEnable()
	 */
	public function onEnable() {
		$this->enabled = true;
        $this->getServer()->getPluginManager()->registerEvents(new NextLevelListener($this), $this);
		$this->log ( TextFormat::GREEN . "- NextLevel - Enabled!" );
		$this->loadConfig ();
	}
	
	/**
	 * OnDisable
	 * (non-PHPdoc)
	 * 
	 * @see \pocketmine\plugin\PluginBase::onDisable()
	 */
	public function onDisable() {
		$this->log ( TextFormat::RED . "NextLevel - Disabled" );
		$this->enabled = false;
	}
	
	/**
	 * OnCommand
	 * (non-PHPdoc)
	 * 
	 * @see \pocketmine\plugin\PluginBase::onCommand()
	 */