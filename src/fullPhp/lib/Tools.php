<?php

namespace fullPhp\lib;

use \ReflectionParameter;

class Tools {
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

        echo "\r\n$type\r\n";

        return $type;
    }
}

?>