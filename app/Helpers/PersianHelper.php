<?php

namespace App\Helpers;

class PersianHelper
{
    public static function toPersianDigits($string)
    {
        $latin = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return str_replace($latin, $persian, $string);
    }

    public static function numberToPersianWords($number)
    {
        $number = (int) $number;
        if ($number == 0) return 'صفر تومان';

        $words = ['', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه'];
        $tens = ['', 'ده', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود'];
        $teens = ['ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده'];
        $hundreds = ['', 'صد', 'دویست', 'سیصد', 'چهارصد', 'پانصد', 'ششصد', 'هفتصد', 'هشتصد', 'نهصد'];
        $scales = ['', 'هزار', 'میلیون', 'میلیارد'];

        $convertGroup = function ($num) use ($words, $tens, $teens, $hundreds) {
            $result = [];
            if ($num >= 100) {
                $result[] = $hundreds[intdiv($num, 100)];
                $num %= 100;
            }
            if ($num >= 10 && $num < 20) {
                $result[] = $teens[$num - 10];
            } else {
                if ($num >= 20) {
                    $result[] = $tens[intdiv($num, 10)];
                    $num %= 10;
                }
                if ($num > 0) {
                    $result[] = $words[$num];
                }
            }
            return implode(' و ', $result);
        };

        $groups = [];
        $temp = $number;
        while ($temp > 0) {
            $groups[] = $temp % 1000;
            $temp = intdiv($temp, 1000);
        }

        $parts = [];
        foreach (array_reverse($groups, true) as $index => $group) {
            if ($group > 0) {
                $groupText = $convertGroup($group);
                $parts[] = $groupText . ($scales[$index] ? ' ' . $scales[$index] : '');
            }
        }

        return implode(' و ', $parts) . ' تومان';
    }
}
