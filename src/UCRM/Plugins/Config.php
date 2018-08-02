<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use JsonSerializable;

/**
 * Class Config
 *
 * A class used to interact with the configuration fields of data/config.json.
 *
 * @package UCRM\Plugins
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 * @final
 */
final class Config implements JsonSerializable
{
    /** @var array  */
    protected $values;




    /**
     * Config constructor.
     *
     * @param string $json A JSON string used to initialize this Config objects' properties.
     */
    public function __construct(string $json = "")
    {
        // DEFAULTS...
        $this->values = [];

        if($json !== "")
        {
            $this->values = json_decode($json, true);
        }
    }



    /**
     * @return array|mixed Returns an array ready for serialization to JSON.
     */
    public function jsonSerialize()
    {

        return $this->values;
    }

    /**
     * @return string Returns a string representation of this Config object.
     */
    public function __toString(): string
    {
        return json_encode($this->values, JSON_UNESCAPED_SLASHES);
    }






}

