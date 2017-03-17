<?php

namespace tests;

use IntlNumbersToWords\Numbers;
use PHPUnit\Framework\TestCase;

/**
 * Class NumbersTest
 * @package tests
 */
class NumbersTest extends TestCase
{
    /**
     * @var Numbers
     */
    protected $object;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->object = new Numbers();
    }

    /**
     * Test method
     */
    public function testToWordsObjectLocale()
    {
        $this->object->locale = 'de';
        $this->assertEquals('eins', $this->object->toWords(1));
    }

    /**
     * Test method
     */
    public function testToWordsObjectLocale2()
    {
        $this->object->locale = 'es_EC';
        $this->assertEquals('uno', $this->object->toWords(1));
    }

    /**
     * @expectedException \IntlNumbersToWords\Exception\NumbersToWordsException
     * @expectedExceptionMessage Unable to load locale class IntlNumbersToWords\Words\doesnotexist
     */
    public function testToWordsInvalidLocale()
    {
        $this->object->toWords(1, 'doesnotexist');
    }

    /**
     * @expectedException \IntlNumbersToWords\Exception\NumbersToWordsException
     * @expectedExceptionMessage Unable to load locale class IntlNumbersToWords\Words\doesnotexist
     */
    public function testToCurrencyInvalidLocale()
    {
        $this->object->toCurrency(1, 'doesnotexist');
    }

    /**
     * Test method
     */
    public function testGetLocales()
    {
        $locales = $this->object->getLocales();
        $this->assertInternalType('array', $locales);
        $this->assertEquals(29, count($locales));
        foreach ($locales as $locale) {
            $this->assertEquals(
                1,
                preg_match('#^[a-z]{2}(_[A-Z]{2})?$#', $locale)
            );
        }
    }

    /**
     * Test method
     */
    public function testGetLocalesString()
    {
        $locales = $this->object->getLocales('de');
        $this->assertInternalType('array', $locales);
        $this->assertEquals(1, count($locales));
        $this->assertContains('de', $locales);
    }


    /**
     * Test method
     */
    public function testGetLocalesArray()
    {
        $locales = $this->object->getLocales(['de', 'en_US']);
        $this->assertInternalType('array', $locales);
        $this->assertEquals(2, count($locales));
        $this->assertContains('de', $locales);
        $this->assertContains('en_US', $locales);
    }

    /**
     * Test method
     */
    public function testAllLocales()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $locales = $this->object->getLocales();
        foreach ($locales as $locale) {
            $nw   = new Numbers();
            $word = $nw->toWords(101, $locale);
            $this->assertNotEmpty(
                $word,
                'Word for "101" is empty in locale '.$locale
            );
        }
    }

    /**
     * @expectedException \IntlNumbersToWords\Exception\NumbersToWordsException
     * @expectedExceptionMessage Unable to load locale class IntlNumbersToWords\Words\doesnotexist
     */
    public function testLoadLocaleMissing()
    {
        $this->object->loadLocale('doesnotexist');
    }
}
