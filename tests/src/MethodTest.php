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

class MethodTest extends TestCase
{
    public function testHasMethod()
    {
        $cb = _\hasMethod('getArrayCopy');

        static::assertTrue($cb(new \ArrayObject()));
        static::assertFalse($cb(new \stdClass()));
    }

    public function testClassHasMethod()
    {
        $cb = _\classHasMethod('getArrayCopy');

        static::assertTrue($cb(\ArrayObject::class));
        static::assertFalse($cb(\stdClass::class));
    }

    public function testMethodReturns()
    {
        $by2 = new class {
            public function test(int $value): int
            {
                return $value * 2;
            }
        };

        $by3 = new class {
            public function test(int $value): int
            {
                return $value * 3;
            }
        };

        $cb = _\methodReturns('test', 4, 2);

        static::assertTrue($cb($by2));
        static::assertFalse($cb($by3));
    }
}
