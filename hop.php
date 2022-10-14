<?php

/*
 * This file is part of the toobo/hop.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Hop;

if (defined('Hop\T_ARRAY')) {
    return;
}

const T_ARRAY = 'array';
const T_ARRAY_LIKE = 'array_accessible';
const T_BOOL = 'bool';
const T_BOOLEAN = 'boolean';
const T_DOUBLE = 'double';
const T_FLOAT = 'float';
const T_INT = 'int';
const T_INTEGER = 'integer';
const T_ITERABLE = 'iterable';
const T_NULL = 'null';
const T_NUMBER = 'number';
const T_NUMERIC = 'numeric';
const T_OBJECT = 'object';
const T_RESOURCE = 'resource';
const T_STRING = 'string';
const T_TRAVERSABLE = 'traversable';
const T_VOID = 'void';

require_once 'src/utils.php';
require_once 'src/composition.php';
require_once 'src/iterated.php';
require_once 'src/boolean.php';
require_once 'src/comparison.php';
require_once 'src/type.php';
require_once 'src/filter.php';
require_once 'src/size.php';
require_once 'src/contain.php';
require_once 'src/keys.php';
require_once 'src/methods.php';
require_once 'src/misc.php';
