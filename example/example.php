<?php
namespace fullPhp;

use errorPhp\errorPhp;

require(__DIR__."/../vendor/autoload.php");
require(__DIR__."/../src/autoload.php");

$phpFull = new lib\PhpFullPower();

$phpFull->addFunctionality(new functionality\ParamConverter());
$phpFull->addFunctionality(new functionality\ParamSwitcher());
$phpFull->addFunctionality(new functionality\Suggest());

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
    public function testParamConverter(ArrayObject $tableau)
    {
        //echo $tableau->count();
    }

    public function testSwitcher($x, $y)
    {
    	echo "\r\n".$x.",".$y;
    }
}

$test = new test();
$test->testParamConverter("sdqd");

$test->testSwitcher(new lib\SwitchableParameters(array(
	"phone" => array(50, 50),
	"tablet" => array(100, 100),
	"other" => array(150, 150)
), "phone"));

$errorPhp = new errorPhp();

$errorPhp->register();

$test->mamamiya();

?>
