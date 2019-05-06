<?php
namespace Kit;
/**
 * DotArr, use "a.b.c" mode set\get config data.
 *
 * @author MirQin https://github.com/wazsmwazsm
 */
class DotArr
{
    /**
     * "dot" operator.
     *
     * @var string
     */
    protected static $_operator = '.';

    /**
     * Set Operator.
     *
     * @param  string   $operator
     * @return void
     */
    public static function setOperator($operator)
    {
        static::$_operator = $operator;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public static function dotSet(array &$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode(static::$_operator, $key);
        
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if ( ! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;
    }
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public static function dotGet(array $array, $key, $default = NULL)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode(static::$_operator, $key) as $segment) {
            if ( ! is_array($array) || ! array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }

        return $array;
    }
    /**
     * Check if an item exists in an array using "dot" notation.
     *
     * @param  array   $array
     * @param  string  $key
     * @return bool
     */
    public static function dotHas(array $array, $key)
    {
        if (empty($array) || is_null($key)) {
            return FALSE;
        }

        if (array_key_exists($key, $array)) {
            return TRUE;
        }

        foreach (explode(static::$_operator, $key) as $segment) {
            if (! is_array($array) || ! array_key_exists($segment, $array)) {
                return FALSE;
            }
            $array = $array[$segment];
        }

        return TRUE;
    }
}
