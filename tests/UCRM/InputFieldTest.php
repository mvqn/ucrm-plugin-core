<?php
declare(strict_types=1);

require_once __DIR__."/../../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use UCRM\Plugins\InputField;


class InputFieldTest extends TestCase
{
    protected const MANIFEST_PATH =
        __DIR__.
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."ucrm-plugin-example".
        DIRECTORY_SEPARATOR."manifest.json";

    protected $manifest = [];

    protected $inputField;

    protected function setUp(): void
    {
        $this->manifest = json_decode(file_get_contents(self::MANIFEST_PATH), true);
        $field = $this->manifest["configuration"][0];
        $json = json_encode($field);

        $this->inputField = new InputField($json);

    }



    public function testToString()
    {
        if($this->inputField === null)
            $this->inputField = new InputField();

        echo $this->inputField."\n";
        $this->assertNotEquals("[]", (string)$this->inputField);
    }



    public function testGetKey()
    {
        if($this->inputField === null)
            $this->inputField = new InputField();

        echo $this->inputField->getKey()."\n";
        $this->assertNotEmpty($this->inputField->getKey());
    }

    public function testSetKey()
    {
        if($this->inputField === null)
            $this->inputField = new InputField();

        $value = $this->inputField->getKey();
        $value = strrev($value);
        $this->inputField->setKey($value);

        echo $this->inputField->getKey()."\n";
        $this->assertEquals($value, $this->inputField->getKey());
    }








    public function testGetType()
    {
        if($this->inputField === null)
            $this->inputField = new InputField();

        echo $this->inputField->getType()."\n";
        $this->assertEmpty($this->inputField->getType());
    }

    public function testSetType()
    {
        if($this->inputField === null)
            $this->inputField = new InputField();

        $value = $this->inputField->getType();
        $value = "datetime";
        $this->inputField->setType($value);

        echo $this->inputField->getType()."\n";
        $this->assertEquals($value, $this->inputField->getType());
    }




    public function testGetChoices()
    {
        if($this->inputField === null)
            $this->inputField = new InputField();

        $inputField = new InputField(json_encode($this->manifest["configuration"][2]));

        print_r($inputField->getChoices());
        $this->assertNotEmpty($inputField->getChoices());
    }

    public function testSetChoices()
    {
        if($this->inputField === null)
            $this->inputField = new InputField();

        $inputField = new InputField(json_encode($this->manifest["configuration"][2]));
        $choices = $inputField->getChoices();
        $choices["Public Schema"] = "public";
        $inputField->setChoices($choices);

        print_r($inputField->getChoices());
        $this->assertArrayHasKey("Public Schema", $inputField->getChoices());
    }










}
