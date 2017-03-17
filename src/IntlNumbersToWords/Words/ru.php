<?php
/**
 * Numbers_Words
 *
 * PHP version 5
 *
 * Copyright (c) 1997-2006 The PHP Group
 *
 * This source file is subject to version 3.01 of the PHP license,
 * that is bundled with this package in the file LICENSE, and is
 * available at through the world-wide-web at
 * http://www.php.net/license/3_01.txt
 * If you did not receive a copy of the PHP license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * license@php.net so we can mail you a copy immediately.
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Piotr Klaban <makler@man.torun.pl>
 * @author   Andrey Demenev <demenev@gmail.com>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/Numbers_Words
 */

/**
 * Class for translating numbers into Russian.
 *
 * @author Andrey Demenev
 * @package Numbers_Words
 */

namespace IntlNumbersToWords\Words;

use IntlNumbersToWords\Numbers;

/**
 * Class for translating numbers into Russian.
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Piotr Klaban <makler@man.torun.pl>
 * @author   Andrey Demenev <demenev@gmail.com>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @link     http://pear.php.net/package/Numbers_Words
 */
class ru extends Numbers
{

    // {{{ properties

    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale = 'ru';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang = 'Russian';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'Русский';

    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'минус'; // minus sign

    /**
     * The sufixes for exponents (singular)
     * Names partly based on:
     * http://home.earthlink.net/~mrob/pub/math/largenum.html
     * http://mathforum.org/dr.math/faq/faq.large.numbers.html
     * http://www.mazes.com/AmericanNumberingSystem.html
     * @var array
     * @access private
     */
    var $_exponent = [
        0 => '',
        6 => 'миллион',
        9 => 'миллиард',
       12 => 'триллион',
       15 => 'квадриллион',
       18 => 'квинтиллион',
       21 => 'секстиллион',
       24 => 'септиллион',
       27 => 'октиллион',
       30 => 'нониллион',
       33 => 'дециллион',
       36 => 'ундециллион',
       39 => 'дуодециллион',
       42 => 'тредециллион',
       45 => 'кватуордециллион',
       48 => 'квиндециллион',
       51 => 'сексдециллион',
       54 => 'септендециллион',
       57 => 'октодециллион',
       60 => 'новемдециллион',
       63 => 'вигинтиллион',
       66 => 'унвигинтиллион',
       69 => 'дуовигинтиллион',
       72 => 'тревигинтиллион',
       75 => 'кватуорвигинтиллион',
       78 => 'квинвигинтиллион',
       81 => 'сексвигинтиллион',
       84 => 'септенвигинтиллион',
       87 => 'октовигинтиллион',
       90 => 'новемвигинтиллион',
       93 => 'тригинтиллион',
       96 => 'унтригинтиллион',
       99 => 'дуотригинтиллион',
       102 => 'третригинтиллион',
       105 => 'кватортригинтиллион',
       108 => 'квинтригинтиллион',
       111 => 'секстригинтиллион',
       114 => 'септентригинтиллион',
       117 => 'октотригинтиллион',
       120 => 'новемтригинтиллион',
       123 => 'квадрагинтиллион',
       126 => 'унквадрагинтиллион',
       129 => 'дуоквадрагинтиллион',
       132 => 'треквадрагинтиллион',
       135 => 'кваторквадрагинтиллион',
       138 => 'квинквадрагинтиллион',
       141 => 'сексквадрагинтиллион',
       144 => 'септенквадрагинтиллион',
       147 => 'октоквадрагинтиллион',
       150 => 'новемквадрагинтиллион',
       153 => 'квинквагинтиллион',
       156 => 'унквинкагинтиллион',
       159 => 'дуоквинкагинтиллион',
       162 => 'треквинкагинтиллион',
       165 => 'кваторквинкагинтиллион',
       168 => 'квинквинкагинтиллион',
       171 => 'сексквинкагинтиллион',
       174 => 'септенквинкагинтиллион',
       177 => 'октоквинкагинтиллион',
       180 => 'новемквинкагинтиллион',
       183 => 'сексагинтиллион',
       186 => 'унсексагинтиллион',
       189 => 'дуосексагинтиллион',
       192 => 'тресексагинтиллион',
       195 => 'кваторсексагинтиллион',
       198 => 'квинсексагинтиллион',
       201 => 'секссексагинтиллион',
       204 => 'септенсексагинтиллион',
       207 => 'октосексагинтиллион',
       210 => 'новемсексагинтиллион',
       213 => 'септагинтиллион',
       216 => 'унсептагинтиллион',
       219 => 'дуосептагинтиллион',
       222 => 'тресептагинтиллион',
       225 => 'кваторсептагинтиллион',
       228 => 'квинсептагинтиллион',
       231 => 'секссептагинтиллион',
       234 => 'септенсептагинтиллион',
       237 => 'октосептагинтиллион',
       240 => 'новемсептагинтиллион',
       243 => 'октогинтиллион',
       246 => 'уноктогинтиллион',
       249 => 'дуооктогинтиллион',
       252 => 'треоктогинтиллион',
       255 => 'кватороктогинтиллион',
       258 => 'квиноктогинтиллион',
       261 => 'сексоктогинтиллион',
       264 => 'септоктогинтиллион',
       267 => 'октооктогинтиллион',
       270 => 'новемоктогинтиллион',
       273 => 'нонагинтиллион',
       276 => 'уннонагинтиллион',
       279 => 'дуононагинтиллион',
       282 => 'тренонагинтиллион',
       285 => 'кваторнонагинтиллион',
       288 => 'квиннонагинтиллион',
       291 => 'секснонагинтиллион',
       294 => 'септеннонагинтиллион',
       297 => 'октононагинтиллион',
       300 => 'новемнонагинтиллион',
       303 => 'центиллион'
    ];

    /**
     * The array containing the teens' :) names
     * @var array
     * @access private
     */
    var $_teens = [
        11=>'одиннадцать',
        12=>'двенадцать',
        13=>'тринадцать',
        14=>'четырнадцать',
        15=>'пятнадцать',
        16=>'шестнадцать',
        17=>'семнадцать',
        18=>'восемнадцать',
        19=>'девятнадцать'
    ];

    /**
     * The array containing the tens' names
     * @var array
     * @access private
     */
    var $_tens = [
        2=>'двадцать',
        3=>'тридцать',
        4=>'сорок',
        5=>'пятьдесят',
        6=>'шестьдесят',
        7=>'семьдесят',
        8=>'восемьдесят',
        9=>'девяносто'
    ];

    /**
     * The array containing the hundreds' names
     * @var array
     * @access private
     */
    var $_hundreds = [
        1=>'сто',
        2=>'двести',
        3=>'триста',
        4=>'четыреста',
        5=>'пятьсот',
        6=>'шестьсот',
        7=>'семьсот',
        8=>'восемьсот',
        9=>'девятьсот'
    ];

    /**
     * The array containing the digits
     * for neutral, male and female
     * @var array
     * @access private
     */
    var $_digits = [
        ['ноль', 'одно', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ['ноль', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ['ноль', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять']
    ];

    /**
     * The word separator
     * @var string
     * @access private
     */
    var $_sep = ' ';

    /**
     * The currency names (based on the below links,
     * informations from central bank websites and on encyclopedias)
     *
     * @var array
     * @link http://www.jhall.demon.co.uk/currency/by_abbrev.html World currencies
     * @link http://www.rusimpex.ru/Content/Reference/Refinfo/valuta.htm Foreign currencies names
     * @link http://www.cofe.ru/Finance/money.asp Currencies names
     * @access private
     */
    var $_currency_names = [
      'ALL' => [
                [1, 'лек', 'лека', 'леков'],
                [2, 'киндарка', 'киндарки', 'киндарок']
      ],
      'AUD' => [
                [1, 'австралийский доллар', 'австралийских доллара', 'австралийских долларов'],
                [1, 'цент', 'цента', 'центов']
      ],
      'BGN' => [
                [1, 'лев', 'лева', 'левов'],
                [2, 'стотинка', 'стотинки', 'стотинок']
      ],
      'BRL' => [
                [1, 'бразильский реал', 'бразильских реала', 'бразильских реалов'],
                [1, 'сентаво', 'сентаво', 'сентаво']
      ],
      'BYR' => [
                [1, 'белорусский рубль', 'белорусских рубля', 'белорусских рублей'],
                [2, 'копейка', 'копейки', 'копеек']
      ],
      'CAD' => [
                [1, 'канадский доллар', 'канадских доллара', 'канадских долларов'],
                [1, 'цент', 'цента', 'центов']
      ],
      'CHF' => [
                [1, 'швейцарский франк', 'швейцарских франка', 'швейцарских франков'],
                [1, 'сантим', 'сантима', 'сантимов']
      ],
      'CYP' => [
                [1, 'кипрский фунт', 'кипрских фунта', 'кипрских фунтов'],
                [1, 'цент', 'цента', 'центов']
      ],
      'CZK' => [
                [2, 'чешская крона', 'чешских кроны', 'чешских крон'],
                [1, 'галирж', 'галиржа', 'галиржей']
      ],
      'DKK' => [
                [2, 'датская крона', 'датских кроны', 'датских крон'],
                [1, 'эре', 'эре', 'эре']
      ],
      'EEK' => [
                [2, 'эстонская крона', 'эстонских кроны', 'эстонских крон'],
                [1, 'сенти', 'сенти', 'сенти']
      ],
      'EUR' => [
                [1, 'евро', 'евро', 'евро'],
                [1, 'евроцент', 'евроцента', 'евроцентов']
      ],
      'GBP' => [
                [1, 'фунт стерлингов', 'фунта стерлингов', 'фунтов стерлингов'],
                [1, 'пенс', 'пенса', 'пенсов']
      ],
      'HKD' => [
                [1, 'гонконгский доллар', 'гонконгских доллара', 'гонконгских долларов'],
                [1, 'цент', 'цента', 'центов']
      ],
      'HRK' => [
                [2, 'хорватская куна', 'хорватских куны', 'хорватских кун'],
                [2, 'липа', 'липы', 'лип']
      ],
      'HUF' => [
                [1, 'венгерский форинт', 'венгерских форинта', 'венгерских форинтов'],
                [1, 'филлер', 'филлера', 'филлеров']
      ],
      'ISK' => [
                [2, 'исландская крона', 'исландских кроны', 'исландских крон'],
                [1, 'эре', 'эре', 'эре']
      ],
      'JPY' => [
                [2, 'иена', 'иены', 'иен'],
                [2, 'сена', 'сены', 'сен']
      ],
      'LTL' => [
                [1, 'лит', 'лита', 'литов'],
                [1, 'цент', 'цента', 'центов']
      ],
      'LVL' => [
                [1, 'лат', 'лата', 'латов'],
                [1, 'сентим', 'сентима', 'сентимов']
      ],
      'MKD' => [
                [1, 'македонский динар', 'македонских динара', 'македонских динаров'],
                [1, 'дени', 'дени', 'дени']
      ],
      'MTL' => [
                [2, 'мальтийская лира', 'мальтийских лиры', 'мальтийских лир'],
                [1, 'сентим', 'сентима', 'сентимов']
      ],
      'NOK' => [
                [2, 'норвежская крона', 'норвежских кроны', 'норвежских крон'],
                [0, 'эре', 'эре', 'эре']
      ],
      'PLN' => [
                [1, 'злотый', 'злотых', 'злотых'],
                [1, 'грош', 'гроша', 'грошей']
      ],
      'ROL' => [
                [1, 'румынский лей', 'румынских лей', 'румынских лей'],
                [1, 'бани', 'бани', 'бани']
      ],
       // both RUR and RUR are used, I use RUB for shorter form
      'RUB' => [
                [1, 'рубль', 'рубля', 'рублей'],
                [2, 'копейка', 'копейки', 'копеек']
      ],
      'RUR' => [
                [1, 'российский рубль', 'российских рубля', 'российских рублей'],
                [2, 'копейка', 'копейки', 'копеек']
      ],
      'SEK' => [
                [2, 'шведская крона', 'шведских кроны', 'шведских крон'],
                [1, 'эре', 'эре', 'эре']
      ],
      'SIT' => [
                [1, 'словенский толар', 'словенских толара', 'словенских толаров'],
                [2, 'стотина', 'стотины', 'стотин']
      ],
      'SKK' => [
                [2, 'словацкая крона', 'словацких кроны', 'словацких крон'],
                [0, '', '', '']
      ],
      'TRL' => [
                [2, 'турецкая лира', 'турецких лиры', 'турецких лир'],
                [1, 'пиастр', 'пиастра', 'пиастров']
      ],
      'UAH' => [
                [2, 'гривна', 'гривны', 'гривен'],
                [1, 'цент', 'цента', 'центов']
      ],
      'USD' => [
                [1, 'доллар США', 'доллара США', 'долларов США'],
                [1, 'цент', 'цента', 'центов']
      ],
      'YUM' => [
                [1, 'югославский динар', 'югославских динара', 'югославских динаров'],
                [1, 'пара', 'пара', 'пара']
      ],
      'ZAR' => [
                [1, 'ранд', 'ранда', 'рандов'],
                [1, 'цент', 'цента', 'центов']
      ]
    ];

    /**
     * The default currency name
     * @var string
     * @access public
     */
    var $def_currency = 'RUB'; // Russian rouble

    // }}}
    // {{{ _toWords()

    /**
     * Converts a number to its word representation
     * in Russian language
     *
     * @param integer $num    An integer between -infinity and infinity inclusive :)
     *                        that need to be converted to words
     * @param integer $gender Gender of string, 0=neutral, 1=male, 2=female.
     *                        Optional, defaults to 1.
     *
     * @return string  The corresponding word representation
     *
     * @access protected
     * @author Andrey Demenev <demenev@on-line.jar.ru>
     * @since  Numbers_Words 0.16.3
     */
    function _toWords($num, $options = [])
    {
        $dummy  = null;
        $gender = 1;

        /**
         * Loads user options
         */
        extract($options, EXTR_IF_EXISTS);

        return $this->_toWordsWithCase($num, $dummy, $gender);
    }

    /**
     * Converts a number to its word representation
     * in Russian language and determines the case of string.
     *
     * @param integer $num    An integer between -infinity and infinity inclusive :)
     *                        that need to be converted to words
     * @param integer &$case  A variable passed by reference which is set to case
     *                        of the word associated with the number
     * @param integer $gender Gender of string, 0=neutral, 1=male, 2=female.
     *                        Optional, defaults to 1.
     *
     * @return string  The corresponding word representation
     *
     * @access private
     * @author Andrey Demenev <demenev@on-line.jar.ru>
     */
    function _toWordsWithCase($num, &$case, $gender = 1)
    {
        $ret  = '';
        $case = 3;

        $num = trim($num);

        $sign = "";
        if (substr($num, 0, 1) == '-') {
            $sign = $this->_minus . $this->_sep;
            $num  = substr($num, 1);
        }

        while (strlen($num) % 3) {
            $num = '0' . $num;
        }

        if ($num == 0 || $num == '') {
            $ret .= $this->_digits[$gender][0];
        } else {
            $power = 0;

            while ($power < strlen($num)) {
                if (!$power) {
                    $groupgender = $gender;
                } elseif ($power == 3) {
                    $groupgender = 2;
                } else {
                    $groupgender = 1;
                }

                $group = $this->_groupToWords(substr($num, -$power-3, 3), $groupgender, $_case);
                if (!$power) {
                    $case = $_case;
                }

                if ($power == 3) {
                    if ($_case == 1) {
                        $group .= $this->_sep . 'тысяча';
                    } elseif ($_case == 2) {
                        $group .= $this->_sep . 'тысячи';
                    } else {
                        $group .= $this->_sep . 'тысяч';
                    }
                } elseif ($group && $power>3 && isset($this->_exponent[$power])) {
                    $group .= $this->_sep . $this->_exponent[$power];
                    if ($_case == 2) {
                        $group .= 'а';
                    } elseif ($_case == 3) {
                        $group .= 'ов';
                    }
                }

                if ($group) {
                    $ret = $group . $this->_sep . $ret;
                }

                $power += 3;
            }
        }

        return $sign . $ret;
    }

    // }}}
    // {{{ _groupToWords()

    /**
     * Converts a group of 3 digits to its word representation
     * in Russian language.
     *
     * @param integer $num    An integer between -infinity and infinity inclusive :)
     *                        that need to be converted to words
     * @param integer $gender Gender of string, 0=neutral, 1=male, 2=female.
     * @param integer &$case  A variable passed by reference which is set to case
     *                        of the word associated with the number
     *
     * @return string  The corresponding word representation
     *
     * @access private
     * @author Andrey Demenev <demenev@on-line.jar.ru>
     */
    function _groupToWords($num, $gender, &$case)
    {
        $ret  = '';
        $case = 3;

        if ((int)$num == 0) {
            $ret = '';
        } elseif ($num < 10) {
            $ret = $this->_digits[$gender][(int)$num];
            if ($num == 1) {
                $case = 1;
            } elseif ($num < 5) {
                $case = 2;
            } else {
                $case = 3;
            }

        } else {
            $num = str_pad($num, 3, '0', STR_PAD_LEFT);

            $hundreds = (int)$num{0};
            if ($hundreds) {
                $ret = $this->_hundreds[$hundreds];
                if (substr($num, 1) != '00') {
                    $ret .= $this->_sep;
                }

                $case = 3;
            }

            $tens = (int)$num{1};
            $ones = (int)$num{2};
            if ($tens || $ones) {
                if ($tens == 1 && $ones == 0) {
                    $ret .= 'десять';
                } elseif ($tens == 1) {
                    $ret .= $this->_teens[$ones+10];
                } else {
                    if ($tens > 0) {
                        $ret .= $this->_tens[(int)$tens];
                    }

                    if ($ones > 0) {
                        $ret .= $this->_sep
                                . $this->_digits[$gender][$ones];

                        if ($ones == 1) {
                            $case = 1;
                        } elseif ($ones < 5) {
                            $case = 2;
                        } else {
                            $case = 3;
                        }
                    }
                }
            }
        }

        return $ret;
    }
    // }}}
    // {{{ toCurrencyWords()

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in Russian language
     *
     * @param integer $int_curr         An international currency symbol
     *                                  as defined by the ISO 4217 standard (three characters)
     * @param integer $decimal          A money total amount without fraction part (e.g. amount of dollars)
     * @param integer $fraction         Fractional part of the money amount (e.g. amount of cents)
     *                                  Optional. Defaults to false.
     * @param integer $convert_fraction Convert fraction to words (left as numeric if set to false).
     *                                  Optional. Defaults to true.
     *
     * @return string  The corresponding word representation for the currency
     *
     * @access public
     * @author Andrey Demenev <demenev@on-line.jar.ru>
     */
    function toCurrencyWords($int_curr, $decimal, $fraction = false, $convert_fraction = true)
    {
        $int_curr = strtoupper($int_curr);
        if (!isset($this->_currency_names[$int_curr])) {
            $int_curr = $this->def_currency;
        }

        $curr_names = $this->_currency_names[$int_curr];

        $ret  = trim($this->_toWordsWithCase($decimal, $case, $curr_names[0][0]));
        $ret .= $this->_sep . $curr_names[0][$case];

        if ($fraction !== false) {
            if ($convert_fraction) {
                $ret .= $this->_sep . trim($this->_toWordsWithCase($fraction, $case, $curr_names[1][0]));
            } else {
                $ret .= $this->_sep . $fraction;
            }

            $ret .= $this->_sep . $curr_names[1][$case];
        }
        return $ret;
    }
    // }}}

}
