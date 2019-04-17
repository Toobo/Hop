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

$vendor = dirname(__DIR__).'/vendor';

if (! realpath($vendor)) {
    die('Please install via Composer before running tests.');
}

require_once "{$vendor}/autoload.php";
unset($vendor);
