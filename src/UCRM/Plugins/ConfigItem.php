<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use JsonSerializable;

/**
 * Class ConfigItem
 *
 * A class used to interact with the configuration fields of the manifest.json.
 *
 * @package UCRM\Plugins
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 */
final class ConfigItem implements JsonSerializable
{
    /** @var string The key to be used for the JSON key/value pair, also the file name when "file" type is chosen. */
    private $key;

    /** @var string The label displayed on the plugin's settings page. */
    private $label;

    /** @var string|null An optional description of this field to be displayed on the plugin's settings page. */
    private $description;

    /** @var int|null An optional flag to indicate if this field's value is required, 0 = false, 1 = true (default). */
    private $required;

    /**
     * @var string|null An optional input type for rendering on the plugin's settings page, defaults to "text".
     * @since 2.13.0-beta1
     *
     * Acceptable values are:
     * - text       Standard text input
     * - textarea   Multi-line text input
     * - checkbox   True/False values
     * - choice     Dropdown list with pre-defined options (see also "choices")
     * - date       Date input with calendar
     * - datetime   Date and time input with calendar
     * - file       File upload input (file name will be the same as "key", saved in "data/config.json" and the file
     *              itself will be stored in the "data/files" folder.
     */
    private $type;

    /**
     * @var array|null An array of choices that is required when the "choice" type is chosen. ("Label" => Value)
     * @since 2.13.0-beta1
     */
    private $choices;



    /**
     * ConfigItem constructor.
     *
     * @param string $json An optional JSON string used to initialize this ConfigItem's properties.
     */
    public function __construct(string $json = "")
    {
        // DEFAULTS...
        $this->key = ""; // Required
        $this->label = ""; // Required
        $this->description = null;
        $this->required = 1;
        $this->type = "text";
        $this->choices = null;

        if($json !== "")
        {
            $assoc = json_decode($json, true);

            $this->key = $assoc["key"];
            $this->label = $assoc["label"];
            $this->description = key_exists("description", $assoc) ? $assoc["description"] : $this->description;
            $this->required = key_exists("required", $assoc) ? $assoc["required"] : $this->required;
            $this->type = key_exists("type", $assoc) ? $assoc["type"] : $this->type;
            $this->choices = key_exists("choices", $assoc) ? $assoc["choices"] : $this->choices;
        }
    }



    /**
     * @return array|mixed Returns an array ready for serialization to JSON.
     */
    public function jsonSerialize()
    {
        $assoc = get_object_vars($this);
        $assoc = array_filter($assoc, function($value) {
            return ($value !== null); // && $value !== FALSE && $value !== "");
        });

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
     * @return string Gets the Key value of this ConfigItem.
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key Sets the Key value of this ConfigItem.
     */
    public function setKey(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string Gets the Label value of this ConfigItem.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label Sets the Label value of this ConfigItem.
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * @return string|null Gets the Description value of this ConfigItem, can be null.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description Sets the Description value of this ConfigItem.
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return bool Gets the Required value of this ConfigItem.
     */
    public function getRequired(): bool
    {
        return (bool)$this->required;
    }

    /**
     * @param bool $required Sets the Required value of this ConfigItem.
     */
    public function setRequired(bool $required)
    {
        $this->required = $required ? 1 : 0;
    }

    /**
     * @return string|null Gets the Type value of this ConfigItem, can be null.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type Sets the Type value of this ConfigItem.
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return array|null Gets the Choices array of this ConfigItem, can be null.
     */
    public function getChoices(): ?array
    {
        return $this->choices;
    }

    /**
     * @param array $choices Sets the Choices array of this ConfigItem.
     */
    public function setChoices(array $choices)
    {
        $this->choices = $choices;
    }



    /**
     * @return bool Returns true if all information for this ConfigItem is valid, otherwise false.
     */
    public function valid(): bool
    {
        if($this->key === null || $this->key === "")
            return false;

        if($this->label === null || $this->label === "")
            return false;

        if($this->type === "choice" && ($this->choices === null || $this->choices === []))
            return false;

        // TODO: Add other validation code here...

        return true;
    }

}

