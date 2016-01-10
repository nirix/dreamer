<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

namespace Dreamer;

use DateTime;
use IntlCalendar;
use IntlDateFormatter;

abstract class Translation
{
    public static function getName()
    {
        return static::$name;
    }

    public static function getLocale()
    {
        return static::$locale;
    }

    public static function getStrings()
    {
        return static::$strings;
    }

    public function translate($string, $args = [])
    {
        $string = $this->getString($string) ?: $string;
        $string = msgfmt_format_message(static::$locale, $string, $args);
        return $string;
    }

    public function date($format = 'YYYY-MM-dd HH:mm VVVV', $date = null, $fromFormat = null)
    {
        if (!$date) {
            $date = new DateTime;
        } elseif (!($date instanceof DateTime)) {
            if (!$fromFormat) {
                $fromFormat = 'Y-m-d H:i:s';
            }

            $date = DateTime::createFromFormat($fromFormat, $date);
        }

        $from = IntlCalendar::fromDateTime($date);
        return IntlDateFormatter::formatObject($from, $format, static::$locale);
    }

    public static function getString($string)
    {
        return isset(static::$strings[$string]) ? static::$strings[$string] : false;
    }
}
