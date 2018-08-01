<?php
declare(strict_types=1);

require_once __DIR__."/../../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use UCRM\Plugins\Manifest;



class ManifestTest extends TestCase
{
    protected const MANIFEST_PATH =
        __DIR__.
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."ucrm-plugin-example".
        DIRECTORY_SEPARATOR."manifest.json";


    /** @var Manifest */
    protected $manifest;



    protected function setUp(): void
    {
        $json = file_get_contents(self::MANIFEST_PATH);
        $assoc = json_decode($json, true);

        $this->manifest = new Manifest(self::MANIFEST_PATH, $json);
    }



    public function testToString()
    {
        if($this->manifest === null)
            $this->manifest = new Manifest(self::MANIFEST_PATH);

        echo $this->manifest."\n";


    }


    public function testGetConfiguration()
    {
        //if($this->manifest === null)
        //    $this->manifest = new Manifest(self::MANIFEST_PATH);

        $config = $this->manifest->getConfiguration();

        foreach($config as $cfg)
        {
            $test = $cfg->getKey();
            echo $test."\n";
        }

        //print_r();

    }


}
