<?php

namespace tests\units\fullPhp\lib;


use \atoum;

class SwitchableParameters extends atoum
{
	public function testGetParameters()
	{

		$switchableParameters = new \fullPhp\lib\SwitchableParameters(array(
			"phone" => array(50, 50),
			"tablet" => array(100, 100)
		), "phone");

		$this
			->array($switchableParameters->getParameters())
				->isNotEmpty()
				->hasSize(2)
				->containsValues(array(50, 50))
		;


		$this
			->exception(
				function()
				{
					new \fullPhp\lib\SwitchableParameters(array(
						"phone" => array(50, 50),
						"tablet" => array(100, 100)
					), "unknow");
				}
			)
				->isInstanceOf("\InvalidArgumentException")
			
		;
/**
		$this
			->when(
				function() {
					new \fullPhp\lib\SwitchableParameters(2, "ds");
				}
			)
				->error()
					->exists()
		;
**/
	}
}

?>