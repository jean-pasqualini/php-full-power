<?php

namespace fullPhp\lib;

use \AopJoinPoint;
use fullPhp\interfaces\FunctionalityInterface;

class PhpFullPower {

	private $functionalitys = array();

	public function __construct(array $functionalitys = array())
	{

	}

	public function addFunctionality(FunctionalityInterface $functionality)
	{
		$this->functionalitys[] = $functionality;
	}

	public function enable()
	{
		foreach($this->functionalitys as $functionality)
		{
			aop_add_before('fullPhp\\*->*()', 
				function(AopJoinPoint $joinPoint) use ($functionality) { 
					$functionality->before($joinPoint);
			});
		}
	}

	public function disable()
	{

	}
}
?>