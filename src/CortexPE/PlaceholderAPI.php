<?php

/*
 * Copyright (c) 2018 CortexPE
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
 * THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

declare(strict_types=1);

namespace CortexPE;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginLogger;
use pocketmine\utils\TextFormat;

/**
 * Static hell
 */
class PlaceholderAPI extends PluginBase {
	/** @var Placeholder[] */
	private static $placeholders = [];
	/** @var PluginLogger */
	private static $logger;
	
	public function onLoad() {
		self::$logger = $this->getLogger();
	}
	
	public static function registerPlaceholder(Placeholder $placeholder, bool $force = false) : void {
		$name = strtolower($placeholder->getName());
		
		if(self::placeholderExists($name)){
			if(!$force){
				throw new PlaceholderException("A placeholder named " . $name . " already exists, registered by " . $placeholder->getRegistrantName());
			}
			self::getPluginLogger()->info("Plugin " . $placeholder->getRegistrantName() . " has overwritten placeholder: " . $name);
		}
		self::getPluginLogger()->info("Plugin " . $placeholder->getRegistrantName() . " registered placeholder: " . $name);
		self::$placeholders[$name] = $placeholder;
	}
	
	public static function unregisterPlaceholder(Placeholder $placeholder) : void {
		$name = strtolower($placeholder->getName());
		
		if(!self::placeholderExists($name)){
			throw new PlaceholderException("Unknown placeholder: " . $name);
		}
		unset(self::$placeholders[$name]);
		self::getPluginLogger()->info("Unregistered placeholder: " . $placeholder->getName());
	}
	
	public static function get(string $name, $data = null) : string {
		$p = self::getPlaceholder($name);
		if($p instanceof StaticPlaceholder){
			return $p->getValue();
		}elseif($p instanceof DynamicPlaceholder){
			return $p->getValueFor($data);
		}
	}
	
	public static function placeholderExists(string $name) : bool {
		return (isset(self::$placeholders[strtolower($name)]));
	}
	
	public static function getPlaceholder(string $name) : Placeholder {
		$name = strtolower($name);
		
		if(!self::placeholderExists($name)){
			throw new PlaceholderException("Unknown placeholder: " . $name);
		}
		
		return self::$placeholders[$name];
	}
	
	protected static function getPluginLogger() : PluginLogger {
		return self::$logger;
	}
}
