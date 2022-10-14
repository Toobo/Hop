<?php

/*
 * This file is part of the toobo/hop package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Toobo\Hop\Utils;

/**
 * @param mixed $value
 * @param string $description
 * @return int
 */
function measure(mixed $value, string $description): int
{
    if (is_string($value)) {
        return strlen($value);
    }

    if (is_array($value) || ($value instanceof \Countable)) {
        return count($value);
    }

    throw new \TypeError(
        sprintf(
            'Argument 1 passed to %s must be an array, a string, or an object '
            . 'implementing Countable, %s given.',
            $description,
            is_object($value) ? 'instance of ' . get_class($value) : gettype($value)
        )
    );
}

/**
 * @param string $str
 * @param int $start
 * @param int|null $length
 * @return string
 */
function subStr(string $str, int $start, ?int $length = null): string
{
    static $func;
    if (!$func) {
        $func = function_exists('mb_substr') ? 'mb_substr' : 'substr';
    }
    /** @var callable(string,int,?int):string $func */
    return $func($str, $start, $length);
}

/**
 * @param string $str
 * @param string $needle
 * @param int $offset
 * @return int
 */
function strPos(string $str, string $needle, int $offset = 0): int
{
    static $func;
    if (!$func) {
        $func = function_exists('mb_strpos') ? 'mb_strpos' : 'strpos';
    }
    /**
     * @var callable $func
     * @var int|false $result
     */
    $result = $func($str, $needle, $offset);

    return ($result === false) ? -1 : $result;
}

/**
 * @param string $str
 * @return int
 */
function strLen(string $str): int
{
    static $func;
    if (!$func) {
        $func = function_exists('mb_strlen') ? 'mb_strlen' : 'strlen';
    }
    /** @var callable(string):int $func */
    return $func($str);
}
