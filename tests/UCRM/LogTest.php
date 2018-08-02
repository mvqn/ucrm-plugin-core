<?php
/**
 * Created by PhpStorm.
 * User: rspaeth
 * Date: 8/1/2018
 * Time: 5:50 PM
 */

use UCRM\Plugins\{Log, Plugin};

use PHPUnit\Framework\TestCase;

class LogTest extends TestCase
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
        Plugin::rootPath(self::ROOT_PATH, true);
    }


    /**
     * @throws \UCRM\Exceptions\RequiredFileNotFoundException
     */
    public function testClear()
    {
        Log::clear();
        $this->assertEquals("", implode(Log::lines()));
    }

    /**
     *
     */
    public function testWrite()
    {
        $line = Log::write("This is a test!");
        $line = Log::write("This is a test!");
        $line = Log::write("This is a test!");
        $line = Log::write("This is a test!");
        $line = Log::write("This is a test!");
        $this->assertStringEndsWith("This is a test!", $line);

        echo "Log::write()              : $line\r\n";
    }

    /**
     *
     */
    public function testWriteArray()
    {
        $array = [
            "blue" => "BLUE",
            "green" => "GREEN",
            "red" => "RED"
        ];
        $line = Log::writeArray($array);
        $this->assertNotEmpty($line);

        echo "Log::writeArray()         : $line\r\n";
    }

    /**
     * @throws \UCRM\Exceptions\RequiredFileNotFoundException
     */
    public function testLines()
    {
        $lines = Log::lines(4);
        $this->assertNotEmpty($lines);

        echo "Log::lines()              : ".(array_shift($lines))."\r\n";
        foreach($lines as $line)
            echo "                          : ".$line."\r\n";
    }

    /**
     * @throws \UCRM\Exceptions\RequiredFileNotFoundException
     */
    public function testText()
    {
        $text = Log::text(1);
        $this->assertNotEmpty($text);

        echo "Log::text()               : $text\r\n";

    }

}
