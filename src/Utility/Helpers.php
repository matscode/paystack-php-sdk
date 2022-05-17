<?php
/**
 * @package Paystack\Utility
 */

namespace Matscode\Paystack\Utility;

use Matscode\Paystack\Exceptions\JsonException;

final class Helpers
{
    /**
     * Parse response PSR7 stream to Obj
     *
     * @param $jsonString
     * @return \StdClass
     * @throws JsonException
     */
    public static function JSONStringToObj($jsonString): \StdClass
    {
        return self::parseJSON((string)$jsonString);
    }

    /**
     * Parse JSON string to Object
     *
     * @param string $string Valid JSON string to parse
     * @param bool $asObject Parses JSON string as StdClass Object by default, set to false if you want to parse as associate array
     *
     * @throws JsonException
     */
    public static function parseJSON(string $string, bool $asObject = true): \stdClass
    {
        if (!$string) {
            return json_decode('{}', !$asObject, 4);
        }
        // limit json string parse depth
        $decodedJson = json_decode($string, !$asObject, 16);

        // see if json parsed successfully
        $jsonErrorCode = json_last_error();

        if ($jsonErrorCode) {
            $exceptionMessage = '';
            switch ($jsonErrorCode) {
                /*
                 case JSON_ERROR_NONE:
                    $exceptionMessage = 'No errors';
                    break;
                */
                case JSON_ERROR_DEPTH:
                    $exceptionMessage = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $exceptionMessage = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $exceptionMessage = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $exceptionMessage = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $exceptionMessage = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $exceptionMessage = 'Unknown error';
                    break;
            }

            throw new JsonException($exceptionMessage);
        }

        return $decodedJson;
    }
}
