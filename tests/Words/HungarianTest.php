<?php

namespace App\Tests\Words;

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 autoindent: */

use IntlNumbersToWords\Numbers;
use PHPUnit\Framework\TestCase;

/**
 * Numbers_Words class extension to spell numbers in British English.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Numbers
 * @package   Numbers_Words
 * @author    M�ty�s Somfai <somfai.matyas@gmail.com>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://pear.php.net/package/Numbers_Words
 *
 * @covers    \IntlNumbersToWords\Words\Hu\Hu
 */
class HungarianTest extends TestCase
{
    public Numbers $handle;

    public string $lang = 'hu_HU';

    public function setUp(): void
    {
        $this->handle = new Numbers();
    }

    /**
     * Testing numbers between 0 and 9
     */
    public function testDigits(): void
    {
        $digits = [
            'nulla',
            'egy',
            'kettő',
            'három',
            'négy',
            'öt',
            'hat',
            'hét',
            'nyolc',
            'kilenc',
        ];
        for ($i = 0; $i < 10; $i++) {
            $number = $this->handle->toWords($i, $this->lang);
            self::assertEquals($digits[$i], $number);
        }
    }

    /**
     * Testing numbers between 10 and 99
     */
    public function testTens(): void
    {
        $tens = [
            11 => 'tizenegy',
            12 => 'tizenkettő',
            16 => 'tizenhat',
            19 => 'tizenkilenc',
            20 => 'húsz',
            21 => 'huszonegy',
            26 => 'huszonhat',
            30 => 'harminc',
            31 => 'harmincegy',
            40 => 'negyven',
            43 => 'negyvenhárom',
            50 => 'ötven',
            55 => 'ötvenöt',
            60 => 'hatvan',
            67 => 'hatvanhét',
            70 => 'hetven',
            79 => 'hetvenkilenc',
        ];
        foreach ($tens as $number => $word) {
            self::assertEquals(
                $word,
                $this->handle->toWords($number, $this->lang)
            );
        }
    }

    /**
     * Testing numbers between 100 and 999
     */
    public function testHundreds(): void
    {
        $hundreds = [
            100 => 'egyszáz',
            101 => 'egyszázegy',
            199 => 'egyszázkilencvenkilenc',
            203 => 'kettőszázhárom',
            287 => 'kettőszáznyolcvanhét',
            300 => 'háromszáz',
            356 => 'háromszázötvenhat',
            410 => 'négyszáztíz',
            434 => 'négyszázharmincnégy',
            578 => 'ötszázhetvennyolc',
            689 => 'hatszáznyolcvankilenc',
            729 => 'hétszázhuszonkilenc',
            894 => 'nyolcszázkilencvennégy',
            999 => 'kilencszázkilencvenkilenc',
        ];
        foreach ($hundreds as $number => $word) {
            self::assertEquals(
                $word,
                $this->handle->toWords($number, $this->lang)
            );
        }
    }

    /**
     * Testing numbers between 1000 and 9999
     */
    function testThousands()
    {
        self::markTestIncomplete(
            'temporary disabled.'
        );
        $thousands = [
            1000 => 'egyezer',
            1001 => 'egyezeregy',
            1097 => 'egyezerkilencvenhét',
            1104 => 'egyezeregyszáznégy',
            1243 => 'egyezerkettőszáznegyvenhárom',
            2385 => 'kettőezer-háromszáznyolcvanöt',
            3766 => 'háromezer-hétszázhatvanhat',
            4196 => 'négyezer-egyszázkilencvenhat',
            5846 => 'ötezer-nyolcszáznegyvenhat',
            6459 => 'hatezer-négyszázötvenkilenc',
            7232 => 'hétezer-kettőszázharminckettő',
            8569 => 'nyolcezer-ötszázhatvankilenc',
            9539 => 'kilencezer-ötszázharminckilenc',
        ];
        foreach ($thousands as $number => $word) {
            self::assertEquals(
                $word,
                $this->handle->toWords($number, $this->lang)
            );
        }
    }

    /**
     */
    function testMore()
    {
        self::markTestIncomplete(
            'temporary disabled.'
        );

        $this->assertEquals(
            'egymillió',
            $this->handle->toWords(1000000, $this->lang)
        );
        $this->assertEquals(
            'egymillió-egyezer-ötszáz',
            $this->handle->toWords(1001500, $this->lang)
        );
        $this->assertEquals(
            'kettőmillió-egy',
            $this->handle->toWords(2000001, $this->lang)
        );
        $this->assertEquals(
            'nyolcmillió-kettőezer-egy',
            $this->handle->toWords(8002001, $this->lang)
        );
        $this->assertEquals(
            'kettőmilliárd',
            $this->handle->toWords(2000000000, $this->lang)
        );

        // 32 bit systems vs PHP_INT_SIZE - 3 billion is a little high, so use a string version.
        $number = '3000000000000' > PHP_INT_SIZE ? '3000000000000'
            : 3000000000000;

        $this->assertEquals(
            'hárombillió',
            $this->handle->toWords($number, $this->lang)
        );
    }
}
