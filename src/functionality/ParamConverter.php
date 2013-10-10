<?php

namespace fullPhp\functionality;

use \AopJoinPoint;
use \ReflectionClass;

use \fullPhp\lib;

class ParamConverter {


    public function before(AopJoinPoint $joinPoint)
    {
        $arguments = $joinPoint->getArguments();

        //echo "//".$joinPoint->getClassName()."//";

        $class = new ReflectionClass($joinPoint->getClassName());

        $methode = $class->getMethod($joinPoint->getMethodName());

        foreach($methode->getParameters() as $key => $parameter)
        {
            $type = lib\Tools::resolveParameter($parameter);

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

?>