<?php
/**
 * Numbers_Words
 *
 * PHP version 4
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
 * @author   Bogdan Stăncescu <bogdan@moongate.ro>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/Numbers_Words
 */

namespace IntlNumbersToWords\Words\Ro;

use IntlNumbersToWords\AbstractWords;
use IntlNumbersToWords\Numbers;

/**
 * Class for translating numbers into Romanian (Romania) with the correct diacritical signs (commas).
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Bogdan Stăncescu <bogdan@moongate.ro>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @link     http://pear.php.net/package/Numbers_Words
 */
class Ro extends AbstractWords
{

    // {{{ properties

    /**
     * Locale name.
     * @var string
     * @access public
     */
    var $locale = 'ro_RO';

    /**
     * Language name in English.
     * @var string
     * @access public
     */
    var $lang = 'Romanian';

    /**
     * Native language name.
     * @var string
     * @access public
     */
    var $lang_native = 'Română';

    /**
     * Anything higher than this is few or many
     * @var integer
     * @access private
     */
    var $_thresh_few=1;

    /**
     * Anything higher than this is many
     * @var integer
     * @access private
     */
    var $_thresh_many=19;

    /**
     * The words for some numbers.
     * @var string
     * @access private
     */
    var $_numbers = [
        'zero',        // 0
        [         // 1
          [           // masculine
            'un',              // article
            'unu',             // noun
          ],
          [           // feminine
            'o',               // article
            'una',             // noun
          ],
          'un',            // neutral
          'unu',           // abstract (stand-alone cardinal)
        ],
        [         //  2
          'doi',           // masculine and abstract
          'două',          // feminine and neutral
        ],
        'trei',        //  3
        'patru',       //  4
        'cinci',       //  5
        'șase',        //  6
        'șapte',       //  7
        'opt',         //  8
        'nouă',        //  9
        'zece',        // 10
        'unsprezece',  // 11
        [         // 12
          'doisprezece',   // masculine and abstract
          'douăsprezece',  // feminine and abstract
        ],
        'treisprezece',   // 13
        'paisprezece',    // 14
        'cincisprezece',  // 15
        'șaisprezece',    // 16
        'șaptesprezece',  // 17
        'optsprezece',    // 18
        'nouăsprezece',   // 19
        'douăzeci',       // 20
        30=>'treizeci',   // 30
        40=>'patruzeci',  // 40
        50=>'cincizeci',  // 50
        60=>'șaizeci',    // 60
        70=>'șaptezeci',  // 70
        80=>'optzeci',    // 80
        90=>'nouăzeci',   // 90
    ];

    /**
     * The word for infinity.
     * @var string
     * @access private
     */
    var $_infinity = 'infinit';

    /**
     * The word for the "and" language construct.
     * @var string
     * @access private
     */
    var $_and = 'și';

    /**
     * The word separator.
     * @var string
     * @access private
     */
    var $_sep = ' ';

    /**
     * Some currency names (as nouns, see {@link _toWords()} in Romanian
     * @access private
     */
    var $_currency_names = [
        'AUD' => [
            ['dolar australian', 'dolari australieni', Numbers::GENDER_MASCULINE],
            ['cent', 'cenți', Numbers::GENDER_MASCULINE],
        ],
        'CAD' => [
            ['dolar canadian', 'dolari canadieni', Numbers::GENDER_MASCULINE],
            ['cent', 'cenți', Numbers::GENDER_MASCULINE],
        ],
        'CHF' => [
            ['franc elvețian', 'franci elvețieni', Numbers::GENDER_MASCULINE],
            ['cent', 'cenți', Numbers::GENDER_MASCULINE],
        ],
        'CZK' => [
            ['coroană cehă', 'coroane cehe', Numbers::GENDER_FEMININE],
            ['haler', 'haleri', Numbers::GENDER_MASCULINE],
        ],
        'EUR' => [
            ['euro', 'euro', Numbers::GENDER_MASCULINE],
            ['cent', 'cenți', Numbers::GENDER_MASCULINE],
        ],
        'GBP' => [
            ['liră sterlină', 'lire sterline', Numbers::GENDER_FEMININE],
            ['penny', 'penny', Numbers::GENDER_MASCULINE],
        ],
        'HUF' => [
            ['forint', 'forinți', Numbers::GENDER_MASCULINE],
            ['filer', 'fileri', Numbers::GENDER_MASCULINE],
        ],
        'JPY' => [
            ['yen', 'yeni', Numbers::GENDER_MASCULINE],
            ['sen', 'seni', Numbers::GENDER_MASCULINE],
        ],
        'PLN' => [
            ['zlot', 'zloți', Numbers::GENDER_MASCULINE],
            ['gros', 'grosi', Numbers::GENDER_MASCULINE],
        ],
        'ROL' => [
            ['leu', 'lei', Numbers::GENDER_MASCULINE],
            ['ban', 'bani', Numbers::GENDER_MASCULINE],
        ],
        'RON' => [
            ['leu', 'lei', Numbers::GENDER_MASCULINE],
            ['ban', 'bani', Numbers::GENDER_MASCULINE],
        ],
        'RUB' => [
            ['rublă', 'ruble', Numbers::GENDER_FEMININE],
            ['copeică', 'copeici', Numbers::GENDER_FEMININE],
        ],
        'SKK' => [
            ['coroană slovacă', 'coroane slovace', Numbers::GENDER_FEMININE],
            ['haler', 'haleri', Numbers::GENDER_MASCULINE],
        ],
        'TRL' => [
            ['liră turcească', 'lire turcești', Numbers::GENDER_FEMININE],
            ['kuruș', 'kuruși', Numbers::GENDER_MASCULINE],
        ],
        'USD' => [
            ['dolar american', 'dolari americani', Numbers::GENDER_MASCULINE],
            ['cent', 'cenți', Numbers::GENDER_MASCULINE],
        ],
    ];

    /**
     * The default currency name
     * @var string
     * @access public
     */
    var $def_currency = 'RON'; // Romanian leu

    /**
     * The particle added for many items (>=20)
     */
    var $_many_part='de';

    /**
     * The word for the minus sign.
     * @var string
     * @access private
     */
    var $_minus = 'minus'; // minus sign

    /**
     * The suffixes for exponents (singular).
     * @var array
     * @access private
     */
    var $_exponent = [
        0 => '',
        2 => ['sută','sute',Numbers::GENDER_FEMININE],
        3 => ['mie','mii',Numbers::GENDER_FEMININE],
        6 => ['milion','milioane',Numbers::GENDER_NEUTER],
        9 => ['miliard','miliarde',Numbers::GENDER_NEUTER],
       12 => ['trilion','trilioane',Numbers::GENDER_NEUTER],
       15 => ['cvadrilion','cvadrilioane',Numbers::GENDER_NEUTER],
       18 => ['cvintilion','cvintilioane',Numbers::GENDER_NEUTER],
       21 => ['sextilion','sextilioane',Numbers::GENDER_NEUTER],
       24 => ['septilion','septilioane',Numbers::GENDER_NEUTER],
       27 => ['octilion','octilioane',Numbers::GENDER_NEUTER],
       30 => ['nonilion','nonilioane',Numbers::GENDER_NEUTER],
       33 => ['decilion','decilioane',Numbers::GENDER_NEUTER],
       36 => ['undecilion','undecilioane',Numbers::GENDER_NEUTER],
       39 => ['dodecilion','dodecilioane',Numbers::GENDER_NEUTER],
       42 => ['tredecilion','tredecilioane',Numbers::GENDER_NEUTER],
       45 => ['cvadrodecilion','cvadrodecilioane',Numbers::GENDER_NEUTER],
       48 => ['cvindecilion','cvindecilioane',Numbers::GENDER_NEUTER],
       51 => ['sexdecilion','sexdecilioane',Numbers::GENDER_NEUTER],
       54 => ['septdecilion','septdecilioane',Numbers::GENDER_NEUTER],
       57 => ['octodecilion','octodecilioane',Numbers::GENDER_NEUTER],
       60 => ['novemdecilion','novemdecilioane',Numbers::GENDER_NEUTER],
       63 => ['vigintilion','vigintilioane',Numbers::GENDER_NEUTER],
       66 => ['unvigintilion','unvigintilioane',Numbers::GENDER_NEUTER],
       69 => ['dovigintilion','dovigintilioane',Numbers::GENDER_NEUTER],
       72 => ['trevigintilion','trevigintilioane',Numbers::GENDER_NEUTER],
       75 => ['cvadrovigintilion','cvadrovigintilioane',Numbers::GENDER_NEUTER],
       78 => ['cvinvigintilion','cvinvigintilioane',Numbers::GENDER_NEUTER],
       81 => ['sexvigintilion','sexvigintilioane',Numbers::GENDER_NEUTER],
       84 => ['septvigintilion','septvigintilioane',Numbers::GENDER_NEUTER],
       87 => ['octvigintilion','octvigintilioane',Numbers::GENDER_NEUTER],
       90 => ['novemvigintilion','novemvigintilioane',Numbers::GENDER_NEUTER],
       93 => ['trigintilion','trigintilioane',Numbers::GENDER_NEUTER],
       96 => ['untrigintilion','untrigintilioane',Numbers::GENDER_NEUTER],
       99 => ['dotrigintilion','dotrigintilioane',Numbers::GENDER_NEUTER],
      102 => ['trestrigintilion','trestrigintilioane',Numbers::GENDER_NEUTER],
      105 => ['cvadrotrigintilion','cvadrotrigintilioane',Numbers::GENDER_NEUTER],
      108 => ['cvintrigintilion','cvintrigintilioane',Numbers::GENDER_NEUTER],
      111 => ['sextrigintilion','sextrigintilioane',Numbers::GENDER_NEUTER],
      114 => ['septentrigintilion','septentrigintilioane',Numbers::GENDER_NEUTER],
      117 => ['octotrigintilion','octotrigintilioane',Numbers::GENDER_NEUTER],
      120 => ['novemtrigintilion','novemtrigintilioane',Numbers::GENDER_NEUTER],
      123 => ['cvadragintilion','cvadragintilioane',Numbers::GENDER_NEUTER],
      126 => ['uncvadragintilion','uncvadragintilioane',Numbers::GENDER_NEUTER],
      129 => ['docvadragintilion','docvadragintilioane',Numbers::GENDER_NEUTER],
      132 => ['trecvadragintilion','trecvadragintilioane',Numbers::GENDER_NEUTER],
      135 => ['cvadrocvadragintilion','cvadrocvadragintilioane',Numbers::GENDER_NEUTER],
      138 => ['cvincvadragintilion','cvincvadragintilioane',Numbers::GENDER_NEUTER],
      141 => ['sexcvadragintilion','sexcvadragintilioane',Numbers::GENDER_NEUTER],
      144 => ['septencvadragintilion','septencvadragintilioane',Numbers::GENDER_NEUTER],
      147 => ['octocvadragintilion','octocvadragintilioane',Numbers::GENDER_NEUTER],
      150 => ['novemcvadragintilion','novemcvadragintilioane',Numbers::GENDER_NEUTER],
      153 => ['cvincvagintilion','cvincvagintilioane',Numbers::GENDER_NEUTER],
      156 => ['uncvincvagintilion','uncvincvagilioane',Numbers::GENDER_NEUTER],
      159 => ['docvincvagintilion','docvincvagintilioane',Numbers::GENDER_NEUTER],
      162 => ['trecvincvagintilion','trecvincvagintilioane',Numbers::GENDER_NEUTER],
      165 => ['cvadrocvincvagintilion','cvadrocvincvagintilioane',Numbers::GENDER_NEUTER],
      168 => ['cvincvincvagintilion','cvincvincvagintilioane',Numbers::GENDER_NEUTER],
      171 => ['sexcvincvagintilion','sexcvincvagintilioane',Numbers::GENDER_NEUTER],
      174 => ['septencvincvagintilion','septencvincvagintilioane',Numbers::GENDER_NEUTER],
      177 => ['octocvincvagintilion','octocvincvagintilioane',Numbers::GENDER_NEUTER],
      180 => ['novemcvincvagintilion','novemcvincvagintilioane',Numbers::GENDER_NEUTER],
      183 => ['sexagintilion','sexagintilioane',Numbers::GENDER_NEUTER],
      186 => ['unsexagintilion','unsexagintilioane',Numbers::GENDER_NEUTER],
      189 => ['dosexagintilion','dosexagintilioane',Numbers::GENDER_NEUTER],
      192 => ['tresexagintilion','tresexagintilioane',Numbers::GENDER_NEUTER],
      195 => ['cvadrosexagintilion','cvadrosexagintilioane',Numbers::GENDER_NEUTER],
      198 => ['cvinsexagintilion','cvinsexagintilioane',Numbers::GENDER_NEUTER],
      201 => ['sexsexagintilion','sexsexagintilioane',Numbers::GENDER_NEUTER],
      204 => ['septensexagintilion','septensexagintilioane',Numbers::GENDER_NEUTER],
      207 => ['octosexagintilion','octosexagintilioane',Numbers::GENDER_NEUTER],
      210 => ['novemsexagintilion','novemsexagintilioane',Numbers::GENDER_NEUTER],
      213 => ['septuagintilion','septuagintilioane',Numbers::GENDER_NEUTER],
      216 => ['unseptuagintilion','unseptuagintilioane',Numbers::GENDER_NEUTER],
      219 => ['doseptuagintilion','doseptuagintilioane',Numbers::GENDER_NEUTER],
      222 => ['treseptuagintilion','treseptuagintilioane',Numbers::GENDER_NEUTER],
      225 => ['cvadroseptuagintilion','cvadroseptuagintilioane',Numbers::GENDER_NEUTER],
      228 => ['cvinseptuagintilion','cvinseptuagintilioane',Numbers::GENDER_NEUTER],
      231 => ['sexseptuagintilion','sexseptuagintilioane',Numbers::GENDER_NEUTER],
      234 => ['septenseptuagintilion','septenseptuagintilioane',Numbers::GENDER_NEUTER],
      237 => ['octoseptuagintilion','octoseptuagintilioane',Numbers::GENDER_NEUTER],
      240 => ['novemseptuagintilion','novemseptuagintilioane',Numbers::GENDER_NEUTER],
      243 => ['octogintilion','octogintilioane',Numbers::GENDER_NEUTER],
      246 => ['unoctogintilion','unoctogintilioane',Numbers::GENDER_NEUTER],
      249 => ['dooctogintilion','dooctogintilioane',Numbers::GENDER_NEUTER],
      252 => ['treoctogintilion','treoctogintilioane',Numbers::GENDER_NEUTER],
      255 => ['cvadrooctogintilion','cvadrooctogintilioane',Numbers::GENDER_NEUTER],
      258 => ['cvinoctogintilion','cvinoctogintilioane',Numbers::GENDER_NEUTER],
      261 => ['sexoctogintilion','sexoctogintilioane',Numbers::GENDER_NEUTER],
      264 => ['septoctogintilion','septoctogintilioane',Numbers::GENDER_NEUTER],
      267 => ['octooctogintilion','octooctogintilioane',Numbers::GENDER_NEUTER],
      270 => ['novemoctogintilion','novemoctogintilioane',Numbers::GENDER_NEUTER],
      273 => ['nonagintilion','nonagintilioane',Numbers::GENDER_NEUTER],
      276 => ['unnonagintilion','unnonagintilioane',Numbers::GENDER_NEUTER],
      279 => ['dononagintilion','dononagintilioane',Numbers::GENDER_NEUTER],
      282 => ['trenonagintilion','trenonagintilioane',Numbers::GENDER_NEUTER],
      285 => ['cvadrononagintilion','cvadrononagintilioane',Numbers::GENDER_NEUTER],
      288 => ['cvinnonagintilion','cvinnonagintilioane',Numbers::GENDER_NEUTER],
      291 => ['sexnonagintilion','sexnonagintilioane',Numbers::GENDER_NEUTER],
      294 => ['septennonagintilion','septennonagintilioane',Numbers::GENDER_NEUTER],
      297 => ['octononagintilion','octononagintilioane',Numbers::GENDER_NEUTER],
      300 => ['novemnonagintilion','novemnonagintilioane',Numbers::GENDER_NEUTER],
      303 => ['centilion','centilioane',Numbers::GENDER_NEUTER],
    ];
    // }}}

    // {{{ _splitNumber()

    /**
     * Split a number to groups of three-digit numbers.
     *
     * @param mixed $num An integer or its string representation
     *                   that need to be split
     *
     * @return array  Groups of three-digit numbers.
     * @access private
     * @author Kouber Saparev <kouber@php.net>
     * @since  PHP 4.2.3
     */
    function _splitNumber($num)
    {
        if (is_string($num)) {
            $ret    = [];
            $strlen = strlen($num);
            $first  = substr($num, 0, $strlen%3);

            preg_match_all('/\d{3}/', substr($num, $strlen%3, $strlen), $m);
            $ret =& $m[0];

            if ($first) {
                array_unshift($ret, $first);
            }

            return $ret;
        }
        return explode(' ', number_format($num, 0, '', ' ')); // a faster version for integers
    }
    // }}}

    // {{{ _get_number_inflection_for_gender()
    /**
     * Returns the inflected form of the cardinal according to the noun's gender.
     *
     * @param mixed $number_atom A number atom, per {@link $_numbers}
     * @param array $noun        A noun, per {@link _toWords()}
     * @param boolean $as_noun   A flag indicating whether the inflected form should
     *                           behave as a noun (true, "unu") or as an article (false, "un")
     * @return string            The inflected form of the number
     * @access private
     * @author Bogdan Stăncescu <bogdan@moongate.ro>
     */
    function _get_number_inflection_for_gender($number_atom, $noun, $as_noun=false)
    {
        if (!is_array($number_atom)) {
            $num_names= [
                $number_atom,
                $number_atom,
                $number_atom,
                $number_atom,
            ];
        } elseif (count($number_atom)==2) {
            $num_names= [
                $number_atom[0],
                $number_atom[1],
                $number_atom[1],
                $number_atom[0],
            ];
        } else {
            $num_names=$number_atom;
        }

        $num_name=$num_names[$noun[2]];
        if (!is_array($num_name)) {
            return $num_name;
        }

        return $num_name[(int) $as_noun];
    }
    // }}}

    // {{{ _get_noun_declension_for_number
    /**
     * Returns the noun's declension according to the cardinal's number.
     *
     * @param string $plural_rule The plural rule to use, per {@link _get_plural_rule()}
     * @param array $noun        A noun, per {@link _toWords()}
     * @return string            The inflected form of the noun
     * @access private
     * @author Bogdan Stăncescu <bogdan@moongate.ro>
     */
    function _get_noun_declension_for_number($plural_rule, $noun)
    {
        if ($noun[2]==Numbers::GENDER_ABSTRACT) {
            // Nothing for abstract count
            return "";
        }

        if ($plural_rule=='o') {
            // One
            return $noun[0];
        }

        if ($plural_rule=='f') {
            // Few
            return $noun[1];
        }

        // Many
        return $this->_many_part.$this->_sep.$noun[1];
    }
    // }}}

    // {{{ _get_plural_rule()
    /**
     * Returns the plural rule to use for a specific number.
     *
     * Romanian uses three plural rules (see http://cldr.unicode.org/index/cldr-spec/plural-rules),
     * namely one ("un om"), few ("doi oameni") and many ("o sută de oameni").
     * We use the following notation consistently throughout this class for the three rules:
     * 'o' for one, 'f' for few, and 'm' for many. These three rules are applied depending
     * on the number of items; see
     * http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/language_plural_rules.html#ro
     *
     */
    function _get_plural_rule($number)
    {
        if ($number==$this->_thresh_few) {
            // One
            return 'o';
        }

        if ($number==0) {
            // Zero, which behaves like few
            return 'f';
        }

        $uz=$number%100;

        if ($uz==0) {
           // Hundreds behave like many
           return 'm';
        }

        if ($uz>$this->_thresh_many) {
            // Many
            return 'm';
        }

        // Below the many threshold, so few
        return 'f';
    }
    // }}}

    // {{{ _showDigitsGroup()
    /**
     * Converts a three-digit number to its word representation in Romanian.
     *
     * @param integer $num  An integer between 1 and 999 inclusive.
     * @param array $noun The noun representing the items being counted, per {@link _toWords()}
     * @param boolean $force_noun A flag indicating whether the numeral's inflection should force it behave like a noun
     * @param boolean $force_plural A flag indicating whether we want to override the plural form (we can't tell if we're processing 1 dollar or 1001 dollars from within this method)
     *
     * @return string   The words for the given number and the given noun.
     * @access private
     * @author Bogdan Stăncescu <bogdan@moongate.ro>
     */
    function _showDigitsGroup($num, $noun, $force_noun=false, $force_plural=false)
    {
        $ret = '';

        // extract the value of each digit from the three-digit number
        $u = $num%10;                  // ones
        $uz = $num%100;                // ones+tens
        $z = ($num-$u)%100/10;         // tens
        $s = ($num-$z*10-$u)%1000/100; // hundreds

        if ($s) {
            $ret.=$this->_showDigitsGroup($s, $this->_exponent[2]);
            if ($uz) {
                $ret.=$this->_sep;
            }
        }
        if ($uz) {
            if (isset($this->_numbers[$uz])) {
              $ret.=$this->_get_number_inflection_for_gender($this->_numbers[$uz], $noun, !$force_noun);
            } else {
                if ($z) {
                    $ret.=$this->_numbers[$z*10]; // no accord needed for tens
                    if ($u) {
                      $ret.=$this->_sep.$this->_and.$this->_sep;
                    }
                }
                if ($u) {
                    $ret.=$this->_get_number_inflection_for_gender($this->_numbers[$u], $noun, !$force_noun);
                }
            }
        }

        if ($noun[2]==Numbers::GENDER_ABSTRACT) {
            return $ret;
        }

        $plural_rule=$this->_get_plural_rule($num);
        if ($plural_rule=='o' && $force_plural) {
            $plural_rule='f';
        }

        return $ret.$this->_sep.$this->_get_noun_declension_for_number($plural_rule, $noun);
    }
    // }}}

    // {{{ _toWords()

    /**
     * Converts a number to its word representation in Romanian
     *
     * Romanian uses a complex set of rules for numerals, and a lot of inflections are
     * interdependent. As such, this class implements an easy means for authors to
     * count either abstract numbers (in which case the second parameter should be
     * omitted), or actual nouns. In the latter case, a noun must be provided as an
     * indexed array containing three values:
     * 0 => the singular form
     * 1 => the plural form
     * 2 => the noun's gender, as one of the following constants:
     *      - Numbers::GENDER_MASCULINE for masculine nouns
     *      - Numbers::GENDER_FEMININE for feminine nouns
     *      - Numbers::GENDER_NEUTER for neuter nouns
     *
     * @param integer $num An integer (or its string representation) between 9.99*-10^302
     *                        and 9.99*10^302 (999 centillions) that need to be converted to words
     * @param array $noun  Optionally you can also provide a noun to be formatted accordingly
     * @return string  The corresponding word representation
     * @access protected
     * @author Bogdan Stăncescu <bogdan@moongate.ro>
     */
    function _toWords($num = 0, $noun = [])
    {
        if (empty($noun)) {
          $noun= [NULL, NULL, Numbers::GENDER_ABSTRACT];
        }

        $ret = '';

        // check if $num is a valid non-zero number
        if (!$num || preg_match('/^-?0+$/', $num) || !preg_match('/^-?\d+$/', $num)) {
            $ret = $this->_numbers[0];
            if ($noun[2]!=Numbers::GENDER_ABSTRACT) {
                $ret .= $this->_sep.$this->_get_noun_declension_for_number('f',$noun);
            }
            return $ret;
        }

        // add a minus sign
        if (substr($num, 0, 1) == '-') {
            $ret = $this->_minus . $this->_sep;
            $num = substr($num, 1);
        }

        // One is a special case
        if (abs($num)==1) {
            $ret = $this->_get_number_inflection_for_gender($this->_numbers[1], $noun);
            if ($noun[2]!=Numbers::GENDER_ABSTRACT) {
                $ret .= $this->_sep.$this->_get_noun_declension_for_number('o',$noun);
            }
            return $ret;
        }

        // if the absolute value is greater than 9.99*10^302, return infinity
        if (strlen($num)>306) {
            return $ret . $this->_infinity;
        }

        // strip excessive zero signs
        $num = ltrim($num, '0');

        // split $num to groups of three-digit numbers
        $num_groups = $this->_splitNumber($num);

        $sizeof_numgroups = count($num_groups);
        $showed_noun = false;
        foreach ($num_groups as $i=>$number) {
            // what is the corresponding exponent for the current group
            $pow = $sizeof_numgroups-$i;

            $valid_groups= [];

            // skip processment for empty groups
            if ($number=='000') {
                continue;
            }

            if ($i) {
              $ret.=$this->_sep;
            }

            if ($pow-1) {
               $ret.=$this->_showDigitsGroup($number, $this->_exponent[($pow-1)*3]);
            } else {
               $showed_noun = true;
               $ret.=$this->_showDigitsGroup($number, $noun, false, $num!=1);
            }
        }
        if (!$showed_noun) {
            $ret.=$this->_sep.$this->_get_noun_declension_for_number('m',$noun); // ALWAYS many
        }

        return rtrim($ret, $this->_sep);
    }
    // }}}

    // {{{ toCurrencyWords()

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in Romanian
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
     * @author Bogdan Stăncescu <bogdan@moongate.ro>
     */
    function toCurrencyWords($int_curr, $decimal, $fraction = false, $convert_fraction = true)
    {
        $int_curr = strtoupper($int_curr);
        if (!isset($this->_currency_names[$int_curr])) {
            $int_curr = $this->def_currency;
        }

        $curr_nouns = $this->_currency_names[$int_curr];
        $ret = $this->_toWords($decimal, $curr_nouns[0]);

        if ($fraction !== false) {
            $ret .= $this->_sep . $this->_and;
            if ($convert_fraction) {
                $ret .= $this->_sep . $this->_toWords($fraction, $curr_nouns[1]);
            } else {
                $ret .= $fraction . $this->_sep;
                $plural_rule = $this->_get_plural_rule($fraction);
                $this->_get_noun_declension_for_number($curr_nouns[1]);
            }
        }

        return $ret;
    }

    // }}}

    /**
     * Converts a number to its word representation.
     *
     * @param integer $num       An integer between -infinity and infinity inclusive :)
     *                           that need to be converted to words
     * @param integer $power     The power of ten for the rest of the number to the right.
     *                           Optional, defaults to 0.
     * @param string  $powSuffix The power name to be added to the end of the return string.
     *                           Used internally. Optional, defaults to ''.
     *
     * @return string  The corresponding word representation
     *
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  Numbers_Words 0.16.3
     */
    public function fromNumber(float $num, int $power = 0, string $powSuffix = ''): string
    {
        return $this->_toWords($num);
    }
}
