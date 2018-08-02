<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use Exception;
use JsonSerializable;



final class Manifest implements JsonSerializable
{


    private $format;

    private $name;
    private $displayName;
    private $description;
    private $url;
    private $version;
    private $ucrmMinVersion;
    private $ucrmMaxVersion;
    private $author;

    /**
     * @var $configuration ConfigItem[][]
     */
    private $configuration;






    public function __construct(?string $json = "")
    {
        //$this->path = realpath($path);

        //if($json === null || $json === "")
        //    $json = file_get_contents($this->path);

        try
        {
            $assoc = json_decode($json, true);

            $this->format = $assoc["version"] ?: "";

            $this->name = $assoc["information"]["name"] ?: "";
            $this->displayName = $assoc["information"]["displayName"] ?: "";
            $this->description = $assoc["information"]["description"] ?: "";
            $this->url = $assoc["information"]["url"] ?: "";
            $this->version = $assoc["information"]["version"] ?: "";
            $this->ucrmMinVersion = $assoc["information"]["ucrmVersionCompliancy"]["min"] ?: null;
            $this->ucrmMaxVersion = $assoc["information"]["ucrmVersionCompliancy"]["max"] ?: null;
            $this->author = $assoc["information"]["author"] ?: "";

            $configuration = $assoc["configuration"];

            $this->configuration = [];
            foreach ($configuration as $config) {
                $json = json_encode($config);
                $inputField = new ConfigItem($json);
                $this->configuration[] = $inputField;
                //echo (string)$inputField;
            }
        }
        catch(Exception $e)
        {

        }



    }








    public function jsonSerialize()
    {
        $assoc = get_object_vars($this);
        $assoc = array_filter($assoc, function($value) {
            return ($value !== null); // && $value !== FALSE && $value !== "");
        });

        return $assoc;
    }


    public function __toString(): string
    {
        return json_encode($this, JSON_UNESCAPED_SLASHES);
    }


    /**
     * @param string|null $path
     * @return Manifest
     */
    public static function load(?string $path = null): Manifest
    {
        $manifest_file = ($path !== null && $path !== "" && file_exists($path)) ?
            $path :
            Plugin::rootPath()."/manifest.json";

        $json = file_get_contents($manifest_file);

        return new Manifest($json);
    }

    /**
     * @param string|null $path
     * @return string
     */
    public function save(?string $path = null): string
    {
        $manifest_file = ($path !== null && $path !== "" && file_exists($path)) ?
            $path :
            Plugin::rootPath()."/manifest.json";

        $json = json_encode($this, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        //file_put_contents($manifest_file, $json);
        return $json;
    }





    /**
     * @return ConfigItem[]|null
     */
    public function getConfiguration(): ?array
    {
        return $this->configuration;

    }


}

