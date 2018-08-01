<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use JsonSerializable;

/**
 * Class InputField
 *
 * @package UCRM\Plugins
 */
class InputField implements JsonSerializable
{
    /** @var string The key/name to be used for the JSON key/value pair. */
    protected $key;

    /** @var string The label displayed on the plugin's settings page. */
    protected $label;

    /** @var string|null An optional description of this field to be displayed on the plugin's settings page. */
    protected $description;

    /** @var int|null An optional flag to indicate if this field's value is required, 0 = false, 1 = true (default). */
    protected $required;

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
    protected $type;

    /**
     * @var array|null
     * @since 2.13.0-beta1
     */
    protected $choices;


    /**
     * InputField constructor.
     *
     * @param string $json
     */
    public function __construct(string $json = "")
    {
        // DEFAULTS...
        $this->key = "";
        $this->label = "";
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


    public function valid(): bool
    {

        return true;
    }



    /**
     * @return array|mixed
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
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this, JSON_UNESCAPED_SLASHES);
    }


    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function getRequired(): bool
    {
        return (bool)$this->required;
    }

    /**
     * @param bool $required
     */
    public function setRequired(bool $required)
    {
        $this->required = $required ? 1 : 0;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return array|null
     */
    public function getChoices(): ?array
    {
        return $this->choices;
    }

    /**
     * @param array $choices
     */
    public function setChoices(array $choices)
    {
        $this->choices = $choices;
    }



}

