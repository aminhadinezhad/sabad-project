<?php

namespace App\Support;

use DateTimeInterface;
use Illuminate\Support\Carbon;
use Morilog\Jalali\Jalalian;

/**
 * Dates for display, in Tehran time and the Jalali calendar.
 *
 * The database keeps every time in UTC (the app's timezone), which is the right way to store them.
 * Tehran is three and a half hours ahead, so a time shown as stored was 3:30 behind, and an order
 * placed between midnight and 03:30 showed the day before. Everything the panel and the invoice show
 * goes through here instead, converted to Tehran first. Nothing stored changes.
 */
final class PersianDate
{
    public const TIMEZONE = 'Asia/Tehran';

    /** The moment in Tehran time, or null. */
    public static function inTehran(DateTimeInterface|string|null $value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        return Carbon::parse($value)->setTimezone(self::TIMEZONE);
    }

    /** 1405/07/02 */
    public static function date(DateTimeInterface|string|null $value): string
    {
        return self::format($value, '%Y/%m/%d');
    }

    /** پنجشنبه، 1405/07/02 14:05 */
    public static function dateTime(DateTimeInterface|string|null $value): string
    {
        return self::format($value, 'l، Y/m/d H:i');
    }

    public static function format(DateTimeInterface|string|null $value, string $format): string
    {
        $moment = self::inTehran($value);

        if ($moment === null) {
            return '';
        }

        // the Jalali library spells Tuesday and Thursday with a half-space; the panel writes a space
        return str_replace("\u{200C}", ' ', Jalalian::fromCarbon($moment)->format($format));
    }

    /** Minutes Tehran is ahead of UTC right now (210), for grouping stored UTC times by Tehran date. */
    public static function offsetMinutes(): int
    {
        return (int) Carbon::now(self::TIMEZONE)->utcOffset();
    }
}
