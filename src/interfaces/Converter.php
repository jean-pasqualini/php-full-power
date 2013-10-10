<?php

namespace fullPhp\interfaces;

interface Converter
{
    public static function fromCast($element);

    public function toCast($element);
}