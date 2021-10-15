<?php

/**
 * Filters class
 *
 *
 * @author Qexy admin@qexy.org
 *
 * @copyright © 2021 Alonity
 *
 * @package alonity\filter
 *
 * @license MIT
 *
 * @version 1.0.0
 *
 */

namespace alonity\filter;

class Filters {
    const VERSION = '1.0.0';

    const POST = INPUT_POST;

    const GET = INPUT_GET;

    const COOKIE = INPUT_COOKIE;

    const ENV = INPUT_ENV;

    const SERVER = INPUT_SERVER;

    const VARIABLE = 3;

    const STRING = 0;
    const STR = 0;

    const INTEGER = 1;
    const INT = 1;

    const FLOAT = 2;

    const BOOLEAN = 3;
    const BOOL = 3;

    const ARRAY = 4;



    /**
     * @param array $keys
     *
     * @param string|null $regexp
     *
     * @param int $type
     *
     * @param mixed $default
     *
     *
     * @return FilterArray
     */
    public static function postArray(array $keys, ?string $regexp = null, int $type = 0, $default = '') : FilterArray {
        return self::FilterArray($keys, self::POST, $regexp, $type, $default);
    }



    /**
     * @param array $keys
     *
     * @param string|null $regexp
     *
     * @param int $type
     *
     * @param mixed $default
     *
     *
     * @return FilterArray
     */
    public static function getArray(array $keys, ?string $regexp = null, int $type = 0, $default = '') : FilterArray {
        return self::FilterArray($keys, self::GET, $regexp, $type, $default);
    }



    /**
     * @param array $keys
     *
     * @param string|null $regexp
     *
     * @param int $type
     *
     * @param mixed $default
     *
     *
     * @return FilterArray
     */
    public static function serverArray(array $keys, ?string $regexp = null, int $type = 0, $default = '') : FilterArray {
        return self::FilterArray($keys, self::SERVER, $regexp, $type, $default);
    }



    /**
     * @param array $keys
     *
     * @param string|null $regexp
     *
     * @param int $type
     *
     * @param mixed $default
     *
     *
     * @return FilterArray
     */
    public static function cookieArray(array $keys, ?string $regexp = null, int $type = 0, $default = '') : FilterArray {
        return self::FilterArray($keys, self::COOKIE, $regexp, $type, $default);
    }



    /**
     * @param array $keys
     *
     * @param string|null $regexp
     *
     * @param int $type
     *
     * @param mixed $default
     *
     *
     * @return FilterArray
     */
    public static function envArray(array $keys, ?string $regexp = null, int $type = 0, $default = '') : FilterArray {

        return self::FilterArray($keys, self::ENV, $regexp, $type, $default);
    }



    /**
     * @param array $input
     *
     * @param array $keys
     *
     * @param string|null $regexp
     *
     * @param int $type
     *
     * @param mixed $default
     *
     *
     * @return FilterArray
     */
    public static function variableArray(array $input, array $keys, ?string $regexp = null, int $type = 0, $default = '') : FilterArray {
        return self::FilterArray($keys, self::VARIABLE, $regexp, $type, $default, $input);
    }



    public static function FilterArray(array $keys, int $method = self::GET, ?string $regexp = null, int $type = 0, $default = '', array $input = []) : FilterArray {
        return new FilterArray($keys, $method, $regexp, $type, $default, $input);
    }

    public static function post(string $key, ?string $regexp = null, int $type = 0, $default = '') : Filter {
        return self::method(self::POST, $key, $regexp, $type, $default);
    }

    public static function get(string $key, ?string $regexp = null, int $type = 0, $default = '') : Filter {
        return self::method(self::GET, $key, $regexp, $type, $default);
    }

    public static function cookie(string $key, ?string $regexp = null, int $type = 0, $default = '') : Filter {
        return self::method(self::COOKIE, $key, $regexp, $type, $default);
    }

    public static function server(string $key, ?string $regexp = null, int $type = 0, $default = '') : Filter {
        return self::method(self::SERVER, $key, $regexp, $type, $default);
    }

    public static function env(string $key, ?string $regexp = null, int $type = 0, $default = '') : Filter {
        return self::method(self::ENV, $key, $regexp, $type, $default);
    }

    public static function variable($input, string $key, ?string $regexp = null, int $type = 0, $default = '') : Filter {
        return self::method(self::VARIABLE, $key, $regexp, $type, $default, $input);
    }

    public static function method(int $method, string $key, ?string $regexp = null, int $type = 0, $default = '', array $input = []) : Filter {

        switch($method){
            case 0: $value = $_POST[$key] ?? $default; break;
            case 1: $value = $_GET[$key] ?? $default; break;
            case 2: $value = $_COOKIE[$key] ?? $default; break;
            case 3: $value = $input[$key] ?? $default; break;
            case 4: $value = $_ENV[$key] ?? $default; break;
            case 5: $value = $_SERVER[$key] ?? $default; break;

            default: $value = $default;
        }

        return new Filter($value, $regexp, $type, $key);
    }
}