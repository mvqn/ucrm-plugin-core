<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use JsonSerializable;

/**
 * Class Data
 *
 * A class used to interact with the configuration fields of ucrm.json.
 *
 * @package UCRM\Plugins
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 */
final class Data implements JsonSerializable
{
    /** @var string  */
    private $serverUrl;

    /** @var string  */
    private $pluginUrl;

    /** @var string */
    private $appKey;

    // TODO: Add Data fields as they become available!



    /**
     * Data constructor.
     *
     * @param string $json A JSON string used to initialize this Data object's properties.
     */
    public function __construct(string $json = "")
    {
        // DEFAULTS...
        $this->serverUrl = "";
        $this->pluginUrl = "";
        $this->appKey = "";

        if($json !== "")
        {
            $assoc = json_decode($json, true);

            $this->serverUrl = key_exists("ucrmPublicUrl", $assoc) ? $assoc["ucrmPublicUrl"] : $this->serverUrl;
            $this->pluginUrl = key_exists("pluginPublicUrl", $assoc) ? $assoc["pluginPublicUrl"] : $this->pluginUrl;
            $this->appKey = key_exists("pluginAppKey", $assoc) ? $assoc["pluginAppKey"] : $this->appKey;
        }
    }



    /**
     * @return array|mixed Returns an array ready for serialization to JSON.
     */
    public function jsonSerialize()
    {
        $assoc = [
            "ucrmPublicUrl" => $this->serverUrl,
            "pluginPublicUrl" => $this->pluginUrl,
            "pluginAppKey" => $this->appKey
        ];

        return $assoc;
    }

    /**
     * @return string Returns a string representation of this ConfigItem.
     */
    public function __toString(): string
    {
        return json_encode($this, JSON_UNESCAPED_SLASHES);
    }



    /**
     * @return string Gets the PublicURL value of this Data object.
     */
    public function getServerUrl(): string
    {
        return $this->serverUrl;
    }

    /**
     * @return string Gets the PluginURL value of this Data object.
     */
    public function getPluginUrl(): string
    {
        return $this->pluginUrl;
    }

    /**
     * @return string Gets the AppKey value of this Data object.
     */
    public function getAppKey(): string
    {
        return $this->appKey;
    }


}

