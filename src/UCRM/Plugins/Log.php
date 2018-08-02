<?php
declare(strict_types=1);

namespace UCRM\Plugins;

use UCRM\Exceptions\RequiredFileNotFoundException;


final class Log
{
    /** @const string TIMESTAMP_FORMAT The format to be used by the logging functions as a timestamp. */
    private const TIMESTAMP_FORMAT = "Y-m-d H:i:s.u";



    /**
     * Writes a message to this Plugin's log file.
     *
     * @param string $message The message to be appended to this Plugin's log file.
     * @param string $eol
     * @return string Returns the same message that was logged.
     */
    public static function write(string $message, string $eol = "\r\n"): string
    {
        $log_file =
            Plugin::dataPath().
            DIRECTORY_SEPARATOR."plugin.log";

        if(!file_exists(dirname($log_file)))
            mkdir(dirname($log_file));

        $line = sprintf(
            "[%s] %s",
            //(new DateTimeImmutable())->format("Y-m-d G:i:s.u"),
            (new \DateTime())->format(self::TIMESTAMP_FORMAT),
            $message
        );

        file_put_contents(
            $log_file,
            $line.$eol,
            FILE_APPEND | LOCK_EX
        );

        return $line;
    }

    /**
     * @param array $array
     * @return string
     */
    public static function writeArray(array $array): string
    {
        /*
        $pairs = [];

        foreach($array as $key => $value)
            $pairs[] = "$key => $value";

        $text = "[ ".implode(", ", $pairs)." ]";
        */
        $text = json_encode($array, JSON_UNESCAPED_SLASHES);

        return self::write($text);
    }






    /**
     * Clears this Plugin's log file.
     */
    public static function clear(): void
    {
        $log_file =
            Plugin::dataPath().
            DIRECTORY_SEPARATOR."plugin.log";

        if(!file_exists(dirname($log_file)))
            mkdir(dirname($log_file));

        file_put_contents(
            $log_file,
            "",
            LOCK_EX
        );
    }

    /**
     * Reads the specified number of trailing lines from this Plugin's log file.
     *
     * @param int $tail The number of lines at the end of the file for which to return. 0 = All Lines (default)
     * @return array|null An array of the requested lines.
     * @throws RequiredFileNotFoundException Thrown when a plugin.log file cannot be found.
     */
    public static function lines(int $tail = 0): ?array
    {
        $log_file =
            Plugin::dataPath().
            DIRECTORY_SEPARATOR."plugin.log";

        if(!file_exists($log_file))
            throw new RequiredFileNotFoundException(
                "A plugin.log file could not be found at '".Plugin::rootPath()."'.");

        $lines = preg_split("/[\r\n|\r|\n]+/", file_get_contents($log_file));

        // Remove the final empty line...
        if($lines[count($lines) - 1] === "")
            unset($lines[count($lines) - 1]);

        if($tail < 0)
            return null;

        if($tail === 0)
            return $lines;

        return array_slice($lines, -$tail, $tail);
    }


    /**
     * @param int $number
     * @return null|string
     * @throws RequiredFileNotFoundException
     */
    public static function line(int $number): ?string
    {
        $lines = self::lines();

        if($number < 0 || $number > count($lines) - 1)
            return null;

        return $lines[$number];
    }


    /**
     * @param int $tail
     * @param string $eol
     * @return null|string
     * @throws RequiredFileNotFoundException
     */
    public static function text(int $tail = 0, string $eol = "\r\n"): ?string
    {
        $lines = self::lines($tail);
        return implode($eol, $lines);
    }


}
