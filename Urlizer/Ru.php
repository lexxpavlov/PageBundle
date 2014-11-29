<?php

namespace Lexxpavlov\PageBundle\Urlizer;

class Ru
{
    public static function transliterate($text, $separator = '-')
    {
        // table of convert letters from Russian language to latin letters
        $convertTable = array(
            'а' => 'a',  'б' => 'b',   'в' => 'v',  'г' => 'g',  'д' => 'd',
            'е' => 'e',  'ё' => 'e',   'ж' => 'zh', 'з' => 'z',  'и' => 'i',
            'й' => 'j',  'к' => 'k',   'л' => 'l',  'м' => 'm',  'н' => 'n',
            'о' => 'o',  'п' => 'p',   'р' => 'r',  'с' => 's',  'т' => 't',
            'у' => 'u',  'ф' => 'f',   'х' => 'h',  'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ь' => '',   'ы' => 'y',  'ъ' => '',
            'э' => 'e',  'ю' => 'yu',  'я' => 'ya'
        );
        $text = strtr(trim(mb_strtolower($text, 'UTF-8')), $convertTable);
        return self::urlize($text, $separator);
    }
    
    public static function urlize($text, $separator = '-')
    {
        // Remove all none word characters
        $text = preg_replace('/\W/', ' ', $text);

        // More stripping. Replace spaces with dashes
        $text = preg_replace('/[^A-Za-z0-9\/]+/', $separator,
                preg_replace('/([a-z\d])([A-Z])/', '\1_\2',
                preg_replace('/([A-Z]+)([A-Z][a-z])/', '\1_\2',
                preg_replace('/::/', '/', $text))));

        return trim($text, $separator);

    }
}
