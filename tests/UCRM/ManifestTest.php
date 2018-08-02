<?php
declare(strict_types=1);

require_once __DIR__."/../../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use UCRM\Plugins\{Manifest, Plugin};



class ManifestTest extends TestCase
{
    protected const ROOT_PATH =
        __DIR__.
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."ucrm-plugin-example".
        DIRECTORY_SEPARATOR;

    protected const DATA_PATH =
        self::ROOT_PATH.
        DIRECTORY_SEPARATOR."data".
        DIRECTORY_SEPARATOR;

    protected const MANIFEST_PATH =
        __DIR__.
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."ucrm-plugin-example".
        DIRECTORY_SEPARATOR."manifest.json";


    /** @var Manifest */
    protected $manifest;



    protected function setUp(): void
    {
        Plugin::rootPath(self::ROOT_PATH, true);

        $this->manifest = Manifest::load();
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


    public function testLoad()
    {
        $manifest = Manifest::load();
        $this->assertInstanceOf(Manifest::class, $manifest);

        echo "$manifest\r\n";
    }

    public function testSave()
    {
        $json = $this->manifest->save();
        $this->assertNotEmpty($json);

        echo "$json\r\n";
    }

}
