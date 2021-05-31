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
 * @author   Nils Homp
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/Numbers_Words
 */

// Numbers_Words class extension to spell numbers in Hungarian language.
// NOTE: toCurrency() was not localized and is from the en_US class.
//

/**
 * Class for translating numbers into Hungarian.
 *
 * @author Nils Homp
 * @package Numbers_Words
 */

namespace IntlNumbersToWords\Words\hu;

use IntlNumbersToWords\AbstractWords;

/**
 * Class for translating numbers into Hungarian.
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Nils Homp
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @link     http://pear.php.net/package/Numbers_Words
 */
class HU extends AbstractWords
{

    // {{{ properties

    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale = 'hu_HU';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang = 'Hungarian';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'Magyar';

    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'M�nusz '; // minus sign

    /**
     * The suffixes for exponents (singular and plural)
     * Names based on:
     * http://mek.oszk.hu/adatbazis/lexikon/phplex/lexikon/d/kisokos/186.html
     * @var array
     * @access private
     */
    var $_exponent = [
        0 => [''],
        3 => ['ezer'],
        6 => ['milli�'],
        9 => ['milli�rd'],
       12 => ['billi�'],
       15 => ['billi�rd'],
       18 => ['trilli�'],
       21 => ['trilli�rd'],
       24 => ['kvadrilli�'],
       27 => ['kvadrilli�rd'],
       30 => ['kvintilli�'],
       33 => ['kvintilli�rd'],
       36 => ['szextilli�'],
       39 => ['szextilli�rd'],
       42 => ['szeptilli�'],
       45 => ['szeptilli�rd'],
       48 => ['oktilli�'],
       51 => ['oktilli�rd'],
       54 => ['nonilli�'],
       57 => ['nonilli�rd'],
       60 => ['decilli�'],
       63 => ['decilli�rd'],
       600 => ['centilli�']
    ];

    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    var $_digits = [
        0 => 'nulla', 'egy', 'kett�', 'h�rom', 'n�gy',
        '�t', 'hat', 'h�t', 'nyolc', 'kilenc'
    ];

    /**
     * The word separator
     * @var string
     * @access private
     */
    var $_sep = '';

    /**
     * The thousands word separator
     * @var string
     * @access private
     */
    var $_thousand_sep = '-';

    /**
     * The currency names (based on the below links,
     * informations from central bank websites and on encyclopedias)
     *
     * @var array
     * @link http://30-03-67.dreamstation.com/currency_alfa.htm World Currency Information
     * @link http://www.jhall.demon.co.uk/currency/by_abbrev.html World currencies
     * @link http://www.shoestring.co.kr/world/p.visa/change.htm Currency names in English
     * @access private
     */
    var $_currency_names = [
      'ALL' => [['lek'], ['qindarka']],
      'AUD' => [['Australian dollar'], ['cent']],
      'BAM' => [['convertible marka'], ['fenig']],
      'BGN' => [['lev'], ['stotinka']],
      'BRL' => [['real'], ['centavos']],
      'BYR' => [['Belarussian rouble'], ['kopiejka']],
      'CAD' => [['Canadian dollar'], ['cent']],
      'CHF' => [['Swiss franc'], ['rapp']],
      'CYP' => [['Cypriot pound'], ['cent']],
      'CZK' => [['Czech koruna'], ['halerz']],
      'DKK' => [['Danish krone'], ['ore']],
      'EEK' => [['kroon'], ['senti']],
      'EUR' => [['euro'], ['euro-cent']],
      'GBP' => [['pound', 'pounds'], ['pence', 'pence']],
      'HKD' => [['Hong Kong dollar'], ['cent']],
      'HRK' => [['Croatian kuna'], ['lipa']],
      'HUF' => [['forint'], ['filler']],
      'ILS' => [['new sheqel','new sheqels'], ['agora','agorot']],
      'ISK' => [['Icelandic kr�na'], ['aurar']],
      'JPY' => [['yen'], ['sen']],
      'LTL' => [['litas'], ['cent']],
      'LVL' => [['lat'], ['sentim']],
      'MKD' => [['Macedonian dinar'], ['deni']],
      'MTL' => [['Maltese lira'], ['centym']],
      'NOK' => [['Norwegian krone'], ['oere']],
      'PLN' => [['zloty', 'zlotys'], ['grosz']],
      'ROL' => [['Romanian leu'], ['bani']],
      'RUB' => [['Russian Federation rouble'], ['kopiejka']],
      'SEK' => [['Swedish krona'], ['oere']],
      'SIT' => [['Tolar'], ['stotinia']],
      'SKK' => [['Slovak koruna'], []],
      'TRL' => [['lira'], ['kuru�']],
      'UAH' => [['hryvna'], ['cent']],
      'USD' => [['dollar'], ['cent']],
      'YUM' => [['dinars'], ['para']],
      'ZAR' => [['rand'], ['cent']]
    ];

    /**
     * The default currency name
     * @var string
     * @access public
     */
    var $def_currency = 'HUF'; // forint

    // }}}
    // {{{ _toWords()

    /**
     * Converts a number to its word representation
     * in the Hungarian language
     *
     * @param integer $num       An integer between -infinity and infinity inclusive :)
     *                           that need to be converted to words
     * @param integer $power     The power of ten for the rest of the number to the right.
     *                           Optional, defaults to 0.
     *                           Used internally. Optional, defaults to ''.
     *
     * @return string  The corresponding word representation
     *
     * @access protected
     * @author Nils Homp
     * @since  Numbers_Words 0.16.3
     */
    function fromNumber(int $num, int $power = 0, string $powSuffix = ''): string
    {
        $chk_gt2000 = true;

        /**
         * Loads user options
         */
        // extract($powSuffix, EXTR_IF_EXISTS);

        /**
         * Return string
         */
    	$ret = '';

        // add a minus sign
        if (substr($num, 0, 1) == '-') {
            $ret = $this->_sep . $this->_minus;
            $num = substr($num, 1);
        }

        // strip excessive zero signs and spaces
        $num = trim($num);
        $num = preg_replace('/^0+/', '', $num);

        if ($chk_gt2000) $gt2000 = $num > 2000;

        if (strlen($num) > 3) {
            $maxp = strlen($num)-1;
            $curp = $maxp;
            for ($p = $maxp; $p > 0; --$p) { // power

                // check for highest power
                if (isset($this->_exponent[$p])) {
                    // send substr from $curp to $p
                    $snum = substr($num, $maxp - $curp, $curp - $p + 1);
                    $snum = preg_replace('/^0+/', '', $snum);
                    if ($snum !== '' && $powSuffix) {
                        $cursuffix = $this->_exponent[$powSuffix][count($this->_exponent[$powSuffix])-1];
                        if ($powSuffix != '') {
                            $cursuffix .= $this->_sep . $powSuffix;
                        }

                        $ret .= $this->fromNumber(
                            $snum,
                            ['chk_gt2000' => false],
                            $p,
                            $cursuffix,
                            $gt2000
                        );

                    	if ($gt2000) $ret .= $this->_thousand_sep;
                    }
                    $curp = $p - 1;
                    continue;
                }
            }
            $num = substr($num, $maxp - $curp, $curp - $p + 1);
            if ($num == 0) {
                return rtrim($ret, $this->_thousand_sep);
            }
        } elseif ($num == 0 || $num == '') {
            return $this->_sep . $this->_digits[0];
        }

        $h = $t = $d = 0;

        switch(strlen($num)) {
        case 3:
            $h = (int)substr($num, -3, 1);

        case 2:
            $t = (int)substr($num, -2, 1);

        case 1:
            $d = (int)substr($num, -1, 1);
            break;

        case 0:
            return '';
            break;
        }

        if ($h) {
            $ret .= $this->_sep . $this->_digits[$h] . $this->_sep . 'sz�z';
        }

        // ten, twenty etc.
        switch ($t) {
        case 9:
        case 5:
            $ret .= $this->_sep . $this->_digits[$t] . 'ven';
            break;
        case 8:
        case 6:
            $ret .= $this->_sep . $this->_digits[$t] . 'van';
            break;
        case 7:
            $ret .= $this->_sep . 'hetven';
            break;
        case 3:
            $ret .= $this->_sep . 'harminc';
            break;
        case 4:
            $ret .= $this->_sep . 'negyven';
            break;
        case 2:
            switch ($d) {
            case 0:
                $ret .= $this->_sep . 'h�sz';
                break;
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
                $ret .= $this->_sep . 'huszon';
                break;
            }
            break;
        case 1:
            switch ($d) {
            case 0:
                $ret .= $this->_sep . 't�z';
                break;
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
                $ret .= $this->_sep . 'tizen';
                break;
            }
            break;
        }

        if ($d > 0) { // add digits only in <0> and <1,inf)
            $ret .= $this->_sep . $this->_digits[$d];
        }

        if ($powSuffix > 0) {
            if (isset($this->_exponent[$powSuffix])) {
                $lev = $this->_exponent[$powSuffix];
            }

            if (!isset($lev) || !is_array($lev)) {
                return '';
            }

            $ret .= $this->_sep . $lev[0];
        }

        if ($powSuffix != '') {
            $ret .= $this->_sep . $powSuffix;
        }

        return $ret;
    }
    // }}}
    // {{{ toCurrencyWords()

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in English language
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
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  Numbers_Words 0.4
     */
    function toCurrencyWords($int_curr, $decimal, $fraction = false, $convert_fraction = true)
    {
        $int_curr = strtoupper($int_curr);
        if (!isset($this->_currency_names[$int_curr])) {
            $int_curr = $this->def_currency;
        }
        $curr_names = $this->_currency_names[$int_curr];

        $ret = trim($this->_toWords($decimal));
        $lev = ($decimal == 1) ? 0 : 1;
        if ($lev > 0) {
            if (count($curr_names[0]) > 1) {
                $ret .= $this->_sep . $curr_names[0][$lev];
            } else {
                $ret .= $this->_sep . $curr_names[0][0] . 's';
            }
        } else {
            $ret .= $this->_sep . $curr_names[0][0];
        }

        if ($fraction !== false) {
            if ($convert_fraction) {
                $ret .= $this->_sep . trim($this->_toWords($fraction));
            } else {
                $ret .= $this->_sep . $fraction;
            }
            $lev = ($fraction == 1) ? 0 : 1;
            if ($lev > 0) {
                if (count($curr_names[1]) > 1) {
                    $ret .= $this->_sep . $curr_names[1][$lev];
                } else {
                    $ret .= $this->_sep . $curr_names[1][0] . 's';
                }
            } else {
                $ret .= $this->_sep . $curr_names[1][0];
            }
        }
        return $ret;
    }
}
