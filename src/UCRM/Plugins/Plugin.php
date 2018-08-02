<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use UCRM\Exceptions\RequiredFileNotFoundException;


/**
 * Class Plugin
 * @package UCRM\Plugins
 */
final class Plugin
{
    /** @var string The root path of this Plugin. */
    private static $_rootPath = "";



    /**
     * @param string|null $path An optional overridden path to use in place of the automatically detected path.
     * @param bool $save An optional flag to determine whether or not the overridden path is saved for future use.
     * @return string Returns the absolute ROOT path of this Plugin, regardless of development or production server.
     */
    public static function rootPath(?string $path = "", bool $save = false): string
    {
        // IF an override path has been provided...
        if($path !== "" && $path !== null)
        {
            // AND save is set, save this overridden path for future use...
            if($save)
                self::$_rootPath = $path;

            // OTHERWISE, return this overridden path only this one-time!
            return $path;
        }
        // OTHERWISE, no override path has been provided...
        else
        {
            // AND save is set, reset to automatic detection...
            if($save)
                self::$_rootPath = "";

            // OTHERWISE, get the previously saved/detected path!
            if(self::$_rootPath !== "")
                return self::$_rootPath;
        }

        // .../ucrm-plugin-core/
        $this_root = realpath(
            __DIR__.
            DIRECTORY_SEPARATOR."..".
            DIRECTORY_SEPARATOR."..".
            DIRECTORY_SEPARATOR."..".
            DIRECTORY_SEPARATOR
        );

        // .../mvqn/
        $mvqn_root = realpath(
            $this_root.
            DIRECTORY_SEPARATOR."..".
            DIRECTORY_SEPARATOR
        );

        // .../vendor/
        $vend_root = realpath(
            $mvqn_root.
            DIRECTORY_SEPARATOR."..".
            DIRECTORY_SEPARATOR
        );

        // .../<ucrm-plugin-name>/  (in plugins/ on UCRM Server)
        $ucrm_root = realpath(
            $vend_root.
            DIRECTORY_SEPARATOR."..".
            DIRECTORY_SEPARATOR
        );

        // IF the next two upper directories are recognized as composer's vendor folder and this package name...
        if(dirname($mvqn_root) === "mvqn" && $vend_root === "vendor")
        {
            // THEN set and return the path to the root of the Plugin using this library!
            self::$_rootPath = $ucrm_root;
            return $ucrm_root;
        }
        else
        {
            // OTHERWISE, set and return the path to the root of this library! (FOR TESTING)
            self::$_rootPath = $this_root;
            return $this_root;
        }
    }

    /**
     * @return string Returns the absolute DATA path of this Plugin, regardless of development or production server.
     */
    public static function dataPath(): string
    {
        return realpath(
            self::rootPath().
            DIRECTORY_SEPARATOR."data".
            DIRECTORY_SEPARATOR
        );
    }



    /**
     * @return bool Returns true if this Plugin is pending execution, otherwise false.
     */
    public static function executing(): bool
    {
        return file_exists(
            self::rootPath().
            DIRECTORY_SEPARATOR.
            ".ucrm-plugin-execution-requested"
        );
    }

    /**
     * @return bool Returns true if this Plugin is currently executing, otherwise false.
     */
    public static function running(): bool
    {
        return file_exists(
            self::rootPath().
            DIRECTORY_SEPARATOR.
            ".ucrm-plugin-running"
        );
    }



    /**
     * @return Config Returns the data/config.json of this Plugin.
     * @throws RequiredFileNotFoundException Thrown when a config.json file cannot be found.
     */
    public static function config(): Config
    {
        $config_file =
            self::dataPath().
            DIRECTORY_SEPARATOR."config.json";

        if(!file_exists($config_file))
            throw new RequiredFileNotFoundException(
                "A 'config.json' file could not be found at '".self::$_rootPath."'.");

        $json = file_get_contents($config_file);

        return new Config($json);
    }

    /**
     * @return Manifest Returns the manifest.json of this Plugin as a Manifest object.
     * @throws RequiredFileNotFoundException Thrown when a manifest.json file cannot be found.
     */
    public static function manifest(): Manifest
    {
        $manifest_file =
            self::rootPath().
            DIRECTORY_SEPARATOR."manifest.json";

        if(!file_exists($manifest_file))
            throw new RequiredFileNotFoundException(
                "A manifest.json file could not be found at '".self::$_rootPath."'.");

        return new Manifest($manifest_file);
    }



    /**
     * @param string $message
     * @return string
     */
    public static function log(string $message): string
    {
        return Log::write($message);
    }



    /**
     * @return Data
     * @throws RequiredFileNotFoundException
     */
    private static function data(): Data
    {
        $data_file =
            self::rootPath().
            DIRECTORY_SEPARATOR."ucrm.json";

        if(!file_exists($data_file))
            throw new RequiredFileNotFoundException(
                "The 'ucrm.json' file could not be found at '".self::$_rootPath."'.");

        $json = file_get_contents($data_file);

        return new Data($json);
    }





}

