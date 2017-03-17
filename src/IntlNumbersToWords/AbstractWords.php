<?php

namespace IntlNumbersToWords;

/**
 * Class Words
 * @package IntlNumbersToWords
 */
abstract class AbstractWords
{
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
    abstract public function fromNumber($num, $power = 0, $powSuffix = '');
}