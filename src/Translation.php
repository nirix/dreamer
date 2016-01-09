<?php
/*!
 * Dreamer
 * Copyright (c) 2010-2016 Nirix
 *
 * Licensed under the BSD 3-Clause license.
 */

namespace Dreamer;

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

    public static function getString($string)
    {
        return isset(static::$strings[$string]) ? static::$strings[$string] : false;
    }
}
