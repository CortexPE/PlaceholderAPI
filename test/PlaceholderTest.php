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
/**
 * @name PlaceholderTest
 * @main CortexPE\PlaceholderTest
 * @version 0.0.1
 * @api 3.0.0
 * @description Test PlaceholderAPI
 * @author CortexPE
 */
namespace CortexPE {
    use CortexPE\PlaceholderAPI;
    use pocketmine\Server;
    use pocketmine\command\Command;
    use pocketmine\command\CommandSender;
    use pocketmine\command\ConsoleCommandSender;
    use pocketmine\plugin\PluginBase;
    use pocketmine\utils\TextFormat;
    class PlaceholderTest extends PluginBase {
        public function onEnable() {
			$this->getServer()->getCommandMap()->register("phatest", new class extends Command {
				public function __construct(){
					parent::__construct("phatest", "Test PlaceholderAPI");
				}
				
				public function execute(CommandSender $sender, string $commandLabel, array $args){
					$sender->sendMessage("> Testing Static Placeholder...");
					
					$plugin = Server::getInstance()->getPluginManager()->getPlugin("PlaceholderAPI");
					$testName = "testSTATIC";
					$testValue = "works";
					
					$ph = new StaticPlaceholder($testName, $testValue, $plugin);
					PlaceholderAPI::registerPlaceholder($ph, true);
					
					$ph = PlaceholderAPI::getPlaceholder($testName);
					$sender->sendMessage($ph->getName() . " => " . $ph->getValue());
					if($ph->getValue() == $testValue){
						$sender->sendMessage(TextFormat::GREEN . "PASSED!");
					} else {
						$sender->sendMessage(TextFormat::RED . "FAIL. I don't know how tf that happened but somehow, within the depths of the Universe, it did.");
					}
					
					$sender->sendMessage("> Testing value setter...");
					$ph->setValue(($testValue = "WORKS"));
					if($ph->getValue() == $testValue){
						$sender->sendMessage(TextFormat::GREEN . "PASSED!");
					} else {
						$sender->sendMessage(TextFormat::RED . "FAIL. I don't know how tf that happened but somehow, within the depths of the Universe, it did.");
					}
					$sender->sendMessage("> Unsetting placeholder...");
					PlaceholderAPI::unregisterPlaceholder($ph);

					$sender->sendMessage("> Testing Dynamic Placeholders...");
					$ph = new DynamicPlaceholder("testDYNAMICplayerCoords", function($p){
						if(!($p instanceof Player)){
							return "N/A";
						}
						return (string) $p->asVector3(); // Vector3::__toString() exists so this'll work... just for testing xD
					}, $plugin);
					$ph2 = new DynamicPlaceholder("testDYNAMICrand", function($data){
						return (string) mt_rand(100, 999);
					}, $plugin);
					PlaceholderAPI::registerPlaceholder($ph, true);
					PlaceholderAPI::registerPlaceholder($ph2, true);
					
					$sender->sendMessage("> Test random number generator...");
					for($i = 0; $i < 10; $i++){
						$sender->sendMessage("random number: " . PlaceholderAPI::get("testDYNAMICrand", $sender));
					}
					$sender->sendMessage(TextFormat::GREEN . "PASSED!"); // no exceptions thrown.... yay
					$sender->sendMessage("> Test player coords...");
					$sender->sendMessage("Pos: " . PlaceholderAPI::get("testDYNAMICplayerCoords", $sender));
					$sender->sendMessage(TextFormat::GREEN . "PASSED!"); // no exceptions thrown... again. yay
					
					$sender->sendMessage("> Unsetting placeholders...");
					PlaceholderAPI::unregisterPlaceholder($ph);
					PlaceholderAPI::unregisterPlaceholder($ph2);
				}
			});
			//Server::getInstance()->dispatchCommand(new ConsoleCommandSender(), "phatest");
		}
    }
}