<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use JsonSerializable;


class Manifest implements JsonSerializable
{
    private $root_path;



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
     * @var $configuration InputField[][]
     */
    protected $configuration;



    public function __construct(string $root_path, string $json = "")
    {
        $this->root_path = realpath($root_path);

        if($json !== "")
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
            foreach($configuration as $config)
            {
                $json = json_encode($config);
                $inputField = new InputField($json);
                $this->configuration[] = $inputField;
                //echo (string)$inputField;
            }




        }



    }


    public function jsonSerialize()
    {
        $assoc = get_object_vars($this);
        unset($assoc["root_path"]);
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
     * @return InputField[]|null
     */
    public function getConfiguration(): ?array
    {
        return $this->configuration;

    }


}

