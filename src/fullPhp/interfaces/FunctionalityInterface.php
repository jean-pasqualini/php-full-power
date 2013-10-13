<?php

namespace fullPhp\interfaces;

interface FunctionalityInterface {
    public function before(\AopJoinPoint $joinPoint);
}