<?php
namespace fullPhp;
use \AopJoinPoint;
use \ReflectionClass;
use \ReflectionParameter;

class paramConverter {
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

	public static function convert(AopJoinPoint $joinPoint)
	{
		$arguments = $joinPoint->getArguments();

		//echo "//".$joinPoint->getClassName()."//";

		$class = new ReflectionClass($joinPoint->getClassName());

		$methode = $class->getMethod($joinPoint->getMethodName());

		foreach($methode->getParameters() as $key => $parameter)
		{
			$type = paramConverter::resolveParameter($parameter);

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

// Hack for paramConverter
aop_add_before('fullPhp\\*->*()', function(AopJoinPoint $joinPoint) { \fullPhp\paramConverter::convert($joinPoint); });

class etsi
{
	public function tuFait(arrayCast $tableau)
	{
		echo implode(",", $tableau());
	}
}

$non = new etsi();
$non->tuFait("sdqd");

?>
