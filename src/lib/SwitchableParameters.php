<?php

namespace fullPhp\lib;

class SwitchableParameters  {
	private $calls = array();
	private $choice;

	public function __construct(array $calls, $choice)
	{
		$this->calls = $calls;
		$this->choice = $choice;
	}

	public function getParameters()
	{
        return $this->calls[$this->choice];
	}
}

?>