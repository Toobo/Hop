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

class TypeTest extends TestCase
{
    /**
     * @dataProvider typeTestDataProvider
     * @test
     */
    public function testType(string $type, mixed $subject, bool $expected): void
    {
        $cb = _\isType($type);

        static::assertSame($expected, $cb($subject));
    }

    /**
     * @test
     */
    public function testObjectIs(): void
    {
        $isInterface = _\objectIs(\Countable::class);
        $isClass = _\objectIs(\ArrayObject::class);

        $class = new class implements \Countable {
            // phpcs:disable Inpsyde.CodeQuality.ReturnTypeDeclaration
            public function count()
            {
                // phpcs:enable Inpsyde.CodeQuality.ReturnTypeDeclaration
                return 0;
            }
        };

        static::assertTrue($isInterface(new \ArrayObject()));
        static::assertTrue($isInterface($class));
        static::assertTrue($isClass(new \ArrayObject()));
        static::assertFalse($isClass($class));
    }

    /**
     * @return array
     *
     * phpcs:disable Inpsyde.CodeQuality.FunctionLength
     */
    public function typeTestDataProvider(): array
    {
        // phpcs:enable Inpsyde.CodeQuality.FunctionLength

        $gen1 = static function (): \Generator {
            yield 1;
        };

        $gen2 = static function (): \Generator {
            yield 2;
        };

        return [
            ['string', '', true],
            ['string', 'foo', true],
            ['string', null, false],
            ['string', 1, false],
            ['string', [], false],
            ['bool', true, true],
            ['bool', false, true],
            ['bool', 1, false],
            ['bool', 0, false],
            ['bool', null, false],
            ['bool', 'true', false],
            ['boolean', true, true],
            ['boolean', false, true],
            ['boolean', 1, false],
            ['boolean', 0, false],
            ['boolean', null, false],
            ['boolean', 'true', false],
            ['double', 0.0, true],
            ['double', -1.1, true],
            ['double', 1, false],
            ['double', '1.1', false],
            ['float', 0.0, true],
            ['float', -1.1, true],
            ['float', 1, false],
            ['float', '1.1', false],
            ['int', 0, true],
            ['int', -1, true],
            ['int', '1', false],
            ['int', 1.1, false],
            ['integer', 0, true],
            ['integer', -1, true],
            ['integer', '1', false],
            ['integer', 1.1, false],
            ['iterable', [], true],
            ['iterable', ['a', 'b'], true],
            ['iterable', new \ArrayIterator(['a']), true],
            ['iterable', $gen1(), true],
            ['iterable', new \stdClass(), false],
            ['iterable', 'xyz', false],
            ['traversable', [], true],
            ['traversable', ['a', 'b'], true],
            ['traversable', new \ArrayIterator(['a']), true],
            ['traversable', $gen2(), true],
            ['traversable', new \stdClass(), false],
            ['traversable', 'xyz', false],
            ['null', null, true],
            ['null', 'null', false],
            ['null', '', false],
            ['null', [], false],
            ['void', null, true],
            ['void', 'null', false],
            ['void', '', false],
            ['void', [], false],
            ['number', 1, true],
            ['number', -1, true],
            ['number', 1.1, true],
            ['number', '1.1', true],
            ['number', '1', true],
            ['number', 'one', false],
            ['number', 'a1', false],
            ['numeric', 1, true],
            ['numeric', -1, true],
            ['numeric', 1.1, true],
            ['numeric', '1.1', true],
            ['numeric', '1', true],
            ['numeric', 'one', false],
            ['numeric', 'a1', false],
            ['object', new \stdClass(), true],
            ['object', (object)['x' => 'y'], true],
            ['object', static function () {
            }, true, ],
            ['object', [], false],
            ['object', \ArrayObject::class, false],
            ['resource', STDIN, true],
            ['resource', STDOUT, true],
            ['resource', 'STDOUT', false],
            ['array', [], true],
            ['array', range(0, 2), true],
            ['array', 'array', false],
            ['array', new \ArrayObject(), false],
            ['array_accessible', [], true],
            ['array_accessible', range(0, 2), true],
            ['array_accessible', new \ArrayObject(), true],
            ['array_accessible', 'array', false],
            ['array_accessible', new \stdClass(), false],
            [\ArrayAccess::class, new \ArrayObject(), true],
            [\ArrayAccess::class, \ArrayObject::class, true],
            [\ArrayAccess::class, \ArrayAccess::class, true],
            [\ArrayAccess::class, '\ArrayAccess::class', false],
            [\ArrayAccess::class, [], false],
        ];
    }
}
