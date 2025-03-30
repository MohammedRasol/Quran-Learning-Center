<?php
use Carbon\Carbon;

if (!function_exists('getArabicDate')) {
    function getArabicDate($dateString = '2025-03-29')
    {

        $date = Carbon::parse($dateString);
        $day = $date->format('l');
        $dayNumber = $date->format('j');
        $month = $date->format('F');
        $year = $date->format('Y');

        $daysInArabic = [
            'Saturday' => 'السبت',
            'Sunday' => 'الأحد',
            'Monday' => 'الإثنين',
            'Tuesday' => 'الثلاثاء',
            'Wednesday' => 'الأربعاء',
            'Thursday' => 'الخميس',
            'Friday' => 'الجمعة',
        ];

        $monthsInArabic = [
            'January' => 'يناير',
            'February' => 'فبراير',
            'March' => 'مارس',
            'April' => 'أبريل',
            'May' => 'مايو',
            'June' => 'يونيو',
            'July' => 'يوليو',
            'August' => 'أغسطس',
            'September' => 'سبتمبر',
            'October' => 'أكتوبر',
            'November' => 'نوفمبر',
            'December' => 'ديسمبر',
        ];

        $smartDate = "{$daysInArabic[$day]}، $dayNumber {$monthsInArabic[$month]} $year";
        return $smartDate; // Outputs: السبت، 29 مارس 2025

    }
}
