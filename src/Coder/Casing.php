<?php
declare(strict_types=1);

namespace Coder;
require __DIR__."/../../vendor/autoload.php";

final class Casing
{

    public static function class_name(string $class): string
    {
        $class_parts = explode("\\", $class);
        return end($class_parts);
    }



    public static function pascal_to_snake(string $string)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    public static function snake_to_pascal(string $string): string
    {
        return str_replace('_', '', ucwords($string, '_'));
    }

    public static function snake_to_camel(string $string): string
    {
        return lcfirst(str_replace('_', '', ucwords($string, '_')));
    }



}