<?php

namespace fullPhp\functionality;

class Suggest
{
    public function before(\AopJoinPoint $joinPoint)
    {
        echo "...".PHP_EOL;
    }
}