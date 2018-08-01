<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use JsonSerializable;


class InputField implements JsonSerializable
{
    /** @var string  */
    protected $key;
    /** @var string  */
    protected $label;
    /** @var string  */
    protected $description;
    /** @var int  */
    protected $required;
    /** @var string|null  */
    protected $type;
    /** @var array|null  */
    protected $choices;


    /**
     * InputField constructor.
     *
     * @param string $json
     */
    public function __construct(string $json = "")
    {
        if($json !== "")
        {
            $assoc = json_decode($json, true);

            $this->key = $assoc["key"] ?: "";
            $this->label = $assoc["label"] ?: "";
            $this->description = $assoc["description"] ?: "";
            $this->required = $assoc["required"] ?: 0;
            $this->type = key_exists("type", $assoc) ? $assoc["type"] : null;
            $this->choices = key_exists("choices", $assoc) ? $assoc["choices"] : null;
        }
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
     * @return string
     */
    public function getDescription(): string
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

