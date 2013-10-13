<?php

namespace fullPhp\functionality;

use \AopJoinPoint;

use \fullPhp\lib;

class ParamSwitcher {

    public static function before(AopJoinPoint $joinPoint)
    {
        $arguments = array_filter($joinPoint->getArguments(), function($var) { return null !== $var; });

        if(count($arguments) == 1)
        {
            $argument = current($arguments);

            if($argument instanceof lib\SwitchableParameters)
            {
                $d = $argument->getParameters();

                $joinPoint->setArguments($argument->getParameters());
            }
        }
    }
}

?>