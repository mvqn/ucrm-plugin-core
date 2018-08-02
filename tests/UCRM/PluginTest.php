<?php
declare(strict_types=1);

require_once __DIR__."/../../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use UCRM\Plugins\Plugin;



class PluginTest extends TestCase
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



    protected function setUp()
    {
        Plugin::rootPath(realpath(self::ROOT_PATH), true);
    }



    public function testRootPath()
    {
        $root_path = Plugin::rootPath();
        $this->assertEquals(realpath(self::ROOT_PATH), $root_path);

        echo "Plugin::rootPath()        : $root_path\r\n";
    }

    public function testDataPath()
    {
        $data_path = Plugin::dataPath();
        $this->assertEquals(realpath(self::DATA_PATH), $data_path);

        echo "Plugin::dataPath()        : $data_path\r\n";
    }



    public function testExecuting()
    {
        $result = Plugin::executing();
        $this->assertTrue($result);

        echo "Plugin::executing()       : ".($result ? "TRUE" : "FALSE")."\r\n";
    }

    public function testRunning()
    {
        $result = Plugin::running();
        $this->assertTrue($result);

        echo "Plugin::running()         : ".($result ? "TRUE" : "FALSE")."\r\n";
    }



    public function testConfig()
    {
        $config = Plugin::config();
        $this->assertNotNull($config);

        //$json = json_encode($config);

        echo "Plugin::config()          : $config\r\n";
    }

    public function testManifest()
    {
        $manifest = Plugin::manifest();
        $this->assertNotEmpty($manifest);

        echo "Plugin::manifest()        : $manifest\r\n";
    }

    public function testLog()
    {
        $line = Plugin::log("This is a test message!");
        $this->assertStringEndsWith("This is a test message!", $line);

        echo "Plugin::log()             : $line\r\n";
    }













}
