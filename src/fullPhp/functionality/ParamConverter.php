<?php

namespace fullPhp\functionality;

use \AopJoinPoint;
use \ReflectionClass;

use \fullPhp\lib;

class ParamConverter {


    public function before(AopJoinPoint $joinPoint)
    {
        $arguments = $joinPoint->getArguments();

        $class = new ReflectionClass($joinPoint->getClassName());

        $methode = $class->getMethod($joinPoint->getMethodName());

        foreach($methode->getParameters() as $key => $parameter)
        {
            $classTypeParameter = $parameter->getClass();

            if(null !== $classTypeParameter && $classTypeParameter->implementsInterface("\\fullPhp\\interfaces\\Converter"))
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