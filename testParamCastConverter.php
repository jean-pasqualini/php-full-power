<?php
namespace fullPhp;
use \AopJoinPoint;
use \ReflectionClass;
use \ReflectionParameter;

class paramConverter {


    public function before(AopJoinPoint $joinPoint)
    {
        $arguments = $joinPoint->getArguments();

        //echo "//".$joinPoint->getClassName()."//";

        $class = new ReflectionClass($joinPoint->getClassName());

        $methode = $class->getMethod($joinPoint->getMethodName());

        foreach($methode->getParameters() as $key => $parameter)
        {
            $type = tools::resolveParameter($parameter);

            $classTypeParameter = new ReflectionClass($type);

            if($classTypeParameter->implementsInterface("\\fullPhp\\Cast"))
            {
                $arguments[$key] = $classTypeParameter->getMethod("fromCast")->invoke(null, $arguments[$key]);
            }
            else
            {
                if(!isset($arguments[$key]))
                {
                    $arguments[$key] = null;
                }
            }
        }

        $joinPoint->setArguments($arguments);
    }
}

class tools {
    public static function resolveParameter($refParam)
    {
        $export = ReflectionParameter::export(
            array(
                $refParam->getDeclaringClass()->name,
                $refParam->getDeclaringFunction()->name
            ),
            $refParam->name,
            true
        );

        $type = preg_replace('/.*?([A-Za-z\\\\]+)\s+\$'.$refParam->name.'.*/', '\\1', $export);

        return $type;
    }
}

class swichtableParameters  {
	private $calls = array();
	private $choice;

	public function construct(array $calls, $choice)
	{
		$this->calls = $calls;
		$this->choice = $choice;
	}

	public function getParameters()
	{

	}
}

class paramSwitcher {

	public static function before(AopJoinPoint $joinPoint)
    {
        $arguments = $joinPoint->getArguments();


        if(count($arguments) == 1)
        {
        	$argument = current($arguments);

        	echo "[".get_class($argument)."]";

        	if($argument instanceof swichtableParameters)
        	{
        		echo "cool";
        	}

        	//$joinPoint->setArguments($arguments);
        }
    }
}


interface Cast
{
    public static function fromCast($element);

    public function toCast($element);
}


class arrayCast extends \ArrayObject implements Cast {

    public static function fromCast($element)
    {
        return new arrayCast((array) $element);
    }

    public function toCast($element)
    {
    }

    public function __invoke()
    {
        return $this->getArrayCopy();
    }
}

class phpFullPower {

	private $functionalitys = array();

	public function __construct(array $functionalitys = array())
	{

	}

	public function addFunctionality($functionality)
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

$phpFull = new phpFullPower();

$phpFull->addFunctionality(new paramConverter());
$phpFull->addFunctionality(new paramSwitcher());

$phpFull->enable();

// Hack for paramConverter


class etsi
{
    public function tuFait(arrayCast $tableau)
    {
        echo implode(",", $tableau());
    }

    public function testSwitcher($x, $y)
    {
    	echo ":::".$x.",".$y;
    }
}

$non = new etsi();
$non->tuFait("sdqd");

$non->testSwitcher(new paramSwitcher(array(
	"phone" => array(50, 50),
	"tablet" => array(100, 100),
	"other" => array(150, 150)
), "phone"));

?>
