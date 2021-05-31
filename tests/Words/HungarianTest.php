<?php
namespace tests;

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
 */


class HungarianTest extends TestCase
{
    var $handle;

    var $lang = 'hu_HU';

    function setUp(): void
    {
        $this->handle = new Numbers();
    }

    /**
     * Testing numbers between 0 and 9
     */
    function testDigits()
    {
        $digits = array('nulla',
                        'egy',
                        'kett�',
                        'h�rom',
                        'n�gy',
                        '�t',
                        'hat',
                        'h�t',
                        'nyolc',
                        'kilenc'
                       );
        for ($i = 0; $i < 10; $i++) {
            $number = $this->handle->toWords($i, $this->lang);
            $this->assertEquals($digits[$i], $number);
        }
    }

    /**
     * Testing numbers between 10 and 99
     */
    function testTens()
    {
        $tens = array(11 => 'tizenegy',
                      12 => 'tizenkett�',
                      16 => 'tizenhat',
                      19 => 'tizenkilenc',
                      20 => 'h�sz',
                      21 => 'huszonegy',
                      26 => 'huszonhat',
                      30 => 'harminc',
                      31 => 'harmincegy',
                      40 => 'negyven',
                      43 => 'negyvenh�rom',
                      50 => '�tven',
                      55 => '�tven�t',
                      60 => 'hatvan',
                      67 => 'hatvanh�t',
                      70 => 'hetven',
                      79 => 'hetvenkilenc'
                     );
        foreach ($tens as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, $this->lang));
        }
    }

    /**
     * Testing numbers between 100 and 999
     */
    function testHundreds()
    {
        $hundreds = array(100 => 'egysz�z',
                          101 => 'egysz�zegy',
                          199 => 'egysz�zkilencvenkilenc',
                          203 => 'kett�sz�zh�rom',
                          287 => 'kett�sz�znyolcvanh�t',
                          300 => 'h�romsz�z',
                          356 => 'h�romsz�z�tvenhat',
                          410 => 'n�gysz�zt�z',
                          434 => 'n�gysz�zharmincn�gy',
                          578 => '�tsz�zhetvennyolc',
                          689 => 'hatsz�znyolcvankilenc',
                          729 => 'h�tsz�zhuszonkilenc',
                          894 => 'nyolcsz�zkilencvenn�gy',
                          999 => 'kilencsz�zkilencvenkilenc'
                         );
        foreach ($hundreds as $number => $word) {
            $this->assertEquals($word, $this->handle->toWords($number, $this->lang));
        }
    }

    /**
     * Testing numbers between 1000 and 9999
     */
    function testThousands()
    {
        $this->markTestIncomplete(
            'temporary disabled.'
        );
        $thousands = array(1000 => 'egyezer',
                           1001 => 'egyezeregy',
                           1097 => 'egyezerkilencvenh�t',
                           1104 => 'egyezeregysz�zn�gy',
                           1243 => 'egyezerkett�sz�znegyvenh�rom',
                           2385 => 'kett�ezer-h�romsz�znyolcvan�t',
                           3766 => 'h�romezer-h�tsz�zhatvanhat',
                           4196 => 'n�gyezer-egysz�zkilencvenhat',
                           5846 => '�tezer-nyolcsz�znegyvenhat',
                           6459 => 'hatezer-n�gysz�z�tvenkilenc',
                           7232 => 'h�tezer-kett�sz�zharminckett�',
                           8569 => 'nyolcezer-�tsz�zhatvankilenc',
                           9539 => 'kilencezer-�tsz�zharminckilenc'
                          );
        foreach ($thousands as $number => $word) {
            self::assertEquals($word, $this->handle->toWords($number, $this->lang));
        }
    }

    /**
    */
    function testMore()
    {
        $this->markTestIncomplete(
            'temporary disabled.'
        );
        $this->assertEquals('egymilli�', $this->handle->toWords(1000000, $this->lang));
		$this->assertEquals('egymilli�-egyezer-�tsz�z', $this->handle->toWords(1001500, $this->lang));
		$this->assertEquals('kett�milli�-egy', $this->handle->toWords(2000001, $this->lang));
		$this->assertEquals('nyolcmilli�-kett�ezer-egy', $this->handle->toWords(8002001, $this->lang));
        $this->assertEquals('kett�milli�rd', $this->handle->toWords(2000000000, $this->lang));


        // 32 bit systems vs PHP_INT_SIZE - 3 billion is a little high, so use a string version.
        $number = '3000000000000' > PHP_INT_SIZE? '3000000000000' : 3000000000000;

        $this->assertEquals('h�rombilli�', $this->handle->toWords($number, $this->lang));

    }
}
