<?php

declare(strict_types=1);

namespace UCRM\Coder;
//require __DIR__."/../../vendor/autoload.php";

/**
 * Code
 *
 * Used to modify code snippets or any other text strings as desired.
 *
 * @package Coder
 * @author Ryan Spaeth <rspaeth@mvqn.net>
 *
 * @since 1.0.0
 */
final class Code
{







    public static function str_pop_l(string $string, int $count = 1): string
    {
        return substr($string, 0, $count);
    }

    public static function str_pop_r(string $string, int $count = 1): string
    {
        return substr($string, strlen($string) - $count, $count);
    }




    public static function str_shift_l(string $string, int $count = 1): string
    {
        return substr($string, $count, strlen($string) - $count);
    }

    public static function str_shift_r(string $string, int $count = 1): string
    {
        return substr($string, 0, strlen($string) - $count);
    }



    public static function str_trim_l(string $string, array $chars = [" ", "\t"]): string
    {
        // If the string is already empty, no need to do anything!
        if($string === "" || count($chars) === 0)
            return $string;

        // Remove leading matching characters, until a non-matching character is reached...
        while(in_array($string[0], $chars)) {
            $string = substr($string, 1, strlen($string) - 1);
        }

        // Finally, return the "trimmed" string.
        return $string;

    }

    public static function str_trim_r(string $string, array $chars = [" ", "\t"]): string
    {
        // If the string is already empty, no need to do anything!
        if($string === "" || count($chars) === 0)
            return $string;

        // Remove trailing matching characters, until a non-matching character is reached...
        while(in_array($string[-1], $chars)) {
            $string = substr($string, 0, strlen($string) - 1);
        }

        // Finally, return the "trimmed" string.
        return $string;

    }



    public static function adjust_indent(string $string, int $line, int $amount, string $newline = PHP_EOL): string
    {
        // If no indentation adjustments are needed, then simply return the same string.
        if($amount === 0)
            return $string;

        // Split each line on any of the possible line endings.
        $lines = preg_split('/\r\n|\r|\n|\n\r/', $string);

        // Create a variable to track the minimum indentation amount.
        $minimum_indent = 0;

        $selected = $lines[$line];

        // Create a counter to store the amount of indentation characters encountered so far on this line.
        $i = 0;

        // Then loop through the starting characters, one by one until a non-indentation character is encountered...
        while($selected !== "" && $selected[$i] === " ") { $i++; }

        // Set the minimum indentation to the least amount encountered so far.
        $minimum_indent = $minimum_indent === 0 || $i < $minimum_indent ? $i : $minimum_indent;

        // If the minimum indentation is 0 and the requested indentation is less than 0, return the original string...
        if($minimum_indent === 0 && $amount < 0)
            return $string;

        // ...otherwise, stop any negative indentation amounts from exceeding the minimum indentation amount.
        $amount = $amount < -$minimum_indent ? -$minimum_indent : $amount;

        // If the indentation is negative...
        if($amount < 0) {
            // ... then remove the indentation from the head.
            $lines[$line] = substr($selected, -$amount, strlen($selected) - (-$amount));
        } else {
            // ... otherwise, add the indentation to the head.
            $lines[$line] = str_repeat(" ", $amount).$selected;
        }

        // Finally, return the imploded lines using the specified newline character(s).
        return implode($newline, $lines);

    }





    /**
     * adjust_indents()
     *
     * Adjusts the indentation level of the provided string of code, given an amount of spaces. This function also
     * simultaneously replaces all varying forms of newline character with the specified character for consistency. Any
     * adjustments in the negative (left) direction, will never result in the outermost indentation being less than 0.
     *
     * @param string $string The code string to indent.
     * @param int $amount The amount to indent the code string, either positive or negative.
     * @param string $newline The newline character to use on the newly indented code string.
     * @return string The newly indented code string.
     */
    public static function adjust_indents(string $string, int $amount, string $newline = PHP_EOL): string {

        // If no indentation adjustments are needed, then simply return the same string.
        if($amount === 0)
            return $string;

        // Split each line on any of the possible line endings.
        $lines = preg_split('/\r\n|\r|\n|\n\r/', $string);

        // Create a variable to track the minimum indentation amount.
        $minimum_indent = 0;

        // Then loop through every line to what that amount is...
        foreach($lines as $line) {

            // Create a counter to store the amount of indentation characters encountered so far on this line.
            $i = 0;

            // Then loop through the starting characters, one by one until a non-indentation character is encountered...
            while($string[$i] === " ") { $i++; }

            // Set the minimum indentation to the least amount encountered so far.
            $minimum_indent = $minimum_indent === 0 || $i < $minimum_indent ? $i : $minimum_indent;

        }

        // If the minimum indentation is 0 and the requested indentation is less than 0, return the original string...
        if($minimum_indent === 0 && $amount < 0)
            return $string;

        // ...otherwise, stop any negative indentation amounts from exceeding the minimum indentation amount.
        $amount = $amount < -$minimum_indent ? -$minimum_indent : $amount;

        // Create an array to store the newly indented lines.
        $indented_lines = [];

        // Then loop through each of the lines again and adjust the indentation accordingly...
        foreach($lines as $line) {

            // If the indentation is negative...
            if($amount < 0) {
                // ... then remove the indentation from the head.
                $line = substr($line, -$amount, strlen($line) - (-$amount));
            } else {
                // ... otherwise, add the indentation to the head.
                $line = str_repeat(" ", $amount).$line;
            }

            // Append the newly indented line to the array.
            $indented_lines[] = $line;
        }

        // Finally, return the imploded lines using the specified newline character(s).
        return implode($newline, $indented_lines);

    }


    /**
     * inline()
     *
     * Trims and adjusts indentation of the specified code to allow for more well formatted code styles in other files.
     *
     * @param string $code The code to be adjusted.
     * @param int $indent The new indentation level of the code as an offset from the current indentation, default 0.
     * @return string The newly adjusted code.
     */
    public static function inline(string $code, int $indent = 0): string {

        // Trims newline characters from the leading and whitespace characters from the trailing ends of the code.
        $code = self::str_trim_l($code, ["\n", "\r"]);
        $code = self::str_trim_r($code, [" ", "\t"]);

        // Adjust the indentation (and silently verify the line-endings) of the code.
        $code = self::adjust_indents($code, $indent);

        // Finally, return the newly adjusted code.
        return $code;

    }





}
