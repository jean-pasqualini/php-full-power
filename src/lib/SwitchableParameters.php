<?php

namespace fullPhp\lib;

class SwitchableParameters  {
	private $calls = array();
	private $choice;

	/**
	* @param array liste les 
	* @param mixed key of array
	*/
	public function __construct(array $calls, $choice)
	{
		$this->calls = $calls;
		$this->choice = $choice;

		if(!array_key_exists($this->choice, $this->calls))
		{
			throw new \InvalidArgumentException("choice is not available in calls array");
		}
	}

	public function getParameters()
	{
        return $this->calls[$this->choice];
	}
}

?>