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

use pocketmine\plugin\Plugin;

abstract class Placeholder {
	/** @var string */
	protected $name;
	/** @var Plugin */
	protected $registrant;
	
	public function __construct(string $name, Plugin $registrant){
		$this->name = $name;
		$this->registrant = $registrant;
	}
	
	public function getName() : string {
		return $this->name;
	}
	
	public function getRegistrant() : Plugin {
		return $this->registrant;
	}
	
	public function getRegistrantName() : string {
		return $this->registrant->getFullName();
	}
}
