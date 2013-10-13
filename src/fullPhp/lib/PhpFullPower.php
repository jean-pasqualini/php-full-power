<?php

namespace fullPhp\lib;

use \AopJoinPoint;
use fullPhp\interfaces\FunctionalityInterface;

class PhpFullPower {

	private $functionalitys = array();
    private $match = "fullPhp\\*->*()";

	public function __construct(array $functionalitys = array())
	{

	}

	public function addFunctionality(FunctionalityInterface $functionality)
	{
		$this->functionalitys[] = $functionality;
	}

    public function setMatch($match = "fullPhp\\*->*()")
    {
        $this->match = $match;
    }

	public function enable()
	{
		foreach($this->functionalitys as $functionality)
		{
			aop_add_before($this->match,
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