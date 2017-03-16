<?php
namespace tests;

use IntlNumbersToWords\Numbers;
use PHPUnit\Framework\TestCase;

class NumbersTest extends TestCase
{
    /**
     * @var Numbers
     */
    var $object;

    function setUp()
    {
        $this->object = new Numbers();
    }


    function testToWordsObjectLocale()
    {
        $this->object->locale = 'de';
        $this->assertEquals('eins', $this->object->toWords(1));
    }

    /**
     * @expectedException \IntlNumbersToWords\Exception\NumbersToWordsException
     * @expectedExceptionMessage Unable to load locale class IntlNumbersToWords\Words\doesnotexist
     */
    function testToWordsInvalidLocale()
    {
        $this->object->toWords(1, 'doesnotexist');
    }

    /**
     * @expectedException \IntlNumbersToWords\Exception\NumbersToWordsException
     * @expectedExceptionMessage Unable to load locale class IntlNumbersToWords\Words\doesnotexist
     */
    function testToCurrencyInvalidLocale()
    {
        $this->object->toCurrency(1, 'doesnotexist');
    }

    function testGetLocales()
    {
        $locales = $this->object->getLocales();
        $this->assertInternalType('array', $locales);
        $this->assertGreaterThan(27, count($locales));
        foreach ($locales as $locale) {
            $this->assertEquals(
                1, preg_match('#^[a-z]{2}(_[A-Z]{2})?$#', $locale)
            );
        }
    }

    function testGetLocalesString()
    {
        $locales = $this->object->getLocales('de');
        $this->assertInternalType('array', $locales);
        $this->assertEquals(1, count($locales));
        $this->assertContains('de', $locales);
    }


    function testGetLocalesArray()
    {
        $locales = $this->object->getLocales(array('de', 'en_US'));
        $this->assertInternalType('array', $locales);
        $this->assertEquals(2, count($locales));
        $this->assertContains('de', $locales);
        $this->assertContains('en_US', $locales);
    }

    function testAllLocales()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $locales = $this->object->getLocales();
        foreach ($locales as $locale) {
            $nw = new Numbers();
            $word = $nw->toWords(101, $locale);
            $this->assertNotEmpty(
                $word,
                'Word for "101" is empty in locale ' . $locale
            );
        }
    }

    /**
     * @expectedException \IntlNumbersToWords\Exception\NumbersToWordsException
     * @expectedExceptionMessage Unable to find method 'doesnotexist' in class 'IntlNumbersToWords\Words\de'
     */
    function testLoadLocaleMethodMissing()
    {
        $this->object->loadLocale('de', 'doesnotexist');
    }

}
