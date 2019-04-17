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

namespace Toobo\Hop\Tests;

use PHPUnit\Framework\TestCase;
use Toobo\Hop as _;

class MiscTest extends TestCase
{
    public function testApplyAfter()
    {
        $cb = _\applyAfter('strrev', function (string $str): bool {
            return strpos($str, 'a') === 0;
        });

        static::assertTrue($cb('d-c-b-a'));
        static::assertFalse($cb('a-b-c-d'));
    }

    public function testApplyAfterMethod()
    {
        $cb = _\applyAfterMethod('getArrayCopy', function (array $arr): bool {
            return ($arr['x'] ?? 1) === 2;
        });

        static::assertTrue($cb(new \ArrayObject(['x' => 2])));
        static::assertFalse($cb(new \ArrayObject(['x' => 3])));
    }
}
