<?php
declare(strict_types=1);

require_once __DIR__."/../../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use UCRM\Plugins\Plugin;



class PluginTest extends TestCase
{
    protected const PLUGIN_PATH =
        __DIR__.
        DIRECTORY_SEPARATOR."..".
        DIRECTORY_SEPARATOR."ucrm-plugin-example";

    protected $plugin;

    public function testExecuting()
    {
        if($this->plugin === null)
            $this->plugin = new Plugin(self::PLUGIN_PATH);

        $result = $this->plugin->executing();
        $this->assertTrue($result);
    }

    public function testRunning()
    {
        if($this->plugin === null)
            $this->plugin = new Plugin(self::PLUGIN_PATH);

        $result = $this->plugin->running();
        $this->assertTrue($result);
    }



    public function testConfig()
    {
        if($this->plugin === null)
            $this->plugin = new Plugin(self::PLUGIN_PATH);

        $config = $this->plugin->config();
        print_r($config);
        $this->assertNotNull($config);
    }


    public function testUcrmUrl()
    {
        if($this->plugin === null)
            $this->plugin = new Plugin(self::PLUGIN_PATH);

        $setting = $this->plugin->ucrmUrl();
        echo "$setting\n";
        $this->assertNotNull($setting);
    }

    public function testPluginUrl()
    {
        if($this->plugin === null)
            $this->plugin = new Plugin(self::PLUGIN_PATH);

        $setting = $this->plugin->pluginUrl();
        echo "$setting\n";
        $this->assertNotNull($setting);
    }

    public function testAppKey()
    {
        if($this->plugin === null)
            $this->plugin = new Plugin(self::PLUGIN_PATH);

        $setting = $this->plugin->appKey();
        echo "$setting\n";
        $this->assertNotNull($setting);
    }




}
