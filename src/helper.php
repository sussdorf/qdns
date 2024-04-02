<?php

namespace Qdns;

class Helper
{
    /**
     * returns canonical domain (e.g. always returns root dot)
     *
     * @param string $name
     *
     * @return string
     */
    public static function canonical($name)
    {
        if (substr($name, -1) !== '.') {
            return $name . '.';
        }

        return $name;
    }
}
