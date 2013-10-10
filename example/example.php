<?php
namespace fullPhp;

require("../src/autoload.php");

$phpFull = new lib\PhpFullPower();

$phpFull->addFunctionality(new functionality\ParamConverter());
$phpFull->addFunctionality(new functionality\ParamSwitcher());

$phpFull->enable();

// Hack for paramConverter

class ArrayObject extends \ArrayObject implements interfaces\Converter {

    public static function fromCast($element)
    {
        return new self((array) $element);
    }

    public function toCast($element)
    {
    }
}

class test
{
    public function tuFait(ArrayObject $tableau)
    {
        echo implode(",", $tableau->getArrayCopy());
    }

    public function testSwitcher($x, $y)
    {
    	echo "\r\n".$x.",".$y;
    }
}

$test = new test();
//$non->tuFait("sdqd");

$test->testSwitcher(new lib\SwitchableParameters(array(
	"phone" => array(50, 50),
	"tablet" => array(100, 100),
	"other" => array(150, 150)
), "phone"));

$test->tuFait("un texte");

?>
