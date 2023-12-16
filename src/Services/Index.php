<?php

namespace App\Service;

class NumberConverter
{   
        private $chiffre;
        private $dizaine;
    function numberToWord($num = '')
    {
        $num    = (string) ((int) $num);

        if ((int) ($num) && ctype_digit($num)) {
            $words  = array();

            $num    = str_replace(array(',', ' '), '', trim($num));

            $list1  = array(
                '', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept',
                'huit', 'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze',
                'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'
            );

            $list2  = array(
                '','dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante',
                'soixante-dix ', 'quatre-vingts', 'quatre-vingt-dix' , 'cent '
            );

            $list3  = array(
                '','mille',' millions',' milliards','milliard','quadrillion','quintillion', 'sextillion','septillion',
                'octillion', 'nonillion', 'décillion', 'undécillion',
                'duodécillion', 'tredécillion', 'quattuordécillion',
                'quindécillion', 'sexdécillion', 'septendécillion',
                'octodécillion', 'novemdécillion', 'vigintillion'
            );

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num    = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds   = (int) ($num_part / 100);
                $hundreds   = ($hundreds ? ' ' . $list1[$hundreds] . ' Cent' . ($hundreds == 1 ? '' : '') . ' ' : '');
                $tens       = (int) ($num_part % 100);
                $singles    = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words  = implode(', ', $words);

            $words  = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words  = str_replace(',', ' ', $words);
            }

            return $words;
        } else if (!((int) $num)) {
            return 'Zero';
        }
        return '';
    }
}