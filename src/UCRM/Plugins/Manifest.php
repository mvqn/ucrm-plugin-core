<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use Exception;
use JsonSerializable;



class Manifest implements JsonSerializable
{
    private $path;



    protected $format;

    protected $name;
    protected $displayName;
    protected $description;
    protected $url;
    protected $version;
    protected $ucrmMinVersion;
    protected $ucrmMaxVersion;
    protected $author;

    /**
     * @var $configuration ConfigItem[][]
     */
    protected $configuration;



    public function __construct(string $path, string $json = "")
    {
        $this->path = realpath($path);

        if($json === null || $json === "")
            $json = file_get_contents($this->path);

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
        unset($assoc["path"]);
        $assoc = array_filter($assoc, function($value) {
            return ($value !== null); // && $value !== FALSE && $value !== "");
        });

        return $assoc;
    }


    public function __toString(): string
    {
        return json_encode($this, JSON_UNESCAPED_SLASHES);
    }



    private function values(): ?array
    {
        if(!file_exists($this->root_path))
            return null;

        return json_decode(file_get_contents($this->root_path), true);
    }


    /**
     * @return ConfigItem[]|null
     */
    public function getConfiguration(): ?array
    {
        return $this->configuration;

    }


}

