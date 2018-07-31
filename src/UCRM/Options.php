<?php
declare(strict_types=1);




final class Options
{
    private const CONFIG_FILE =
        __DIR__.
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."data".
        DIRECTORY_SEPARATOR."config.json";

    private const PLUGIN_FILE =
        __DIR__.
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."ucrm.json";



    public static function config(string $config_file = ""): ?array
    {
        $config_file = $config_file ?: self::CONFIG_FILE;

        if(!file_exists($config_file))
            return null;

        return json_decode(file_get_contents($config_file), true);
    }

    public static function plugin(string $plugin_file = ""): ?array
    {
        $plugin_file = $plugin_file ?: self::PLUGIN_FILE;

        if(!file_exists($plugin_file))
            return null;

        return json_decode(file_get_contents($plugin_file), true);
    }

}

