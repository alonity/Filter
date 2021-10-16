<?php

/**
 * String class
 *
 *
 * @author Qexy admin@qexy.org
 *
 * @copyright © 2021 Alonity
 *
 * @package alonity\filter
 *
 * @license MIT
 *
 * @version 1.0.1
 *
 */

namespace alonity\filter;

class Str {

    public $string;

    private $symbols = [
        'russian' => ['а'=>'a','А'=>'A',
            'б'=>'b','Б'=>'B',
            'в'=>'v','В'=>'V',
            'г'=>'g','Г'=>'G',
            'д'=>'d','Д'=>'D',
            'е'=>'e','Е'=>'E',
            'ж'=>'zh','Ж'=>'ZH',
            'з'=>'z','З'=>'Z',
            'и'=>'i','И'=>'I',
            'й'=>'y','Й'=>'Y',
            'к'=>'k','К'=>'K',
            'л'=>'l','Л'=>'L',
            'м'=>'m','М'=>'M',
            'н'=>'n','Н'=>'N',
            'о'=>'o','О'=>'O',
            'п'=>'p','П'=>'P',
            'р'=>'r','Р'=>'R',
            'с'=>'s','С'=>'S',
            'т'=>'t','Т'=>'T',
            'у'=>'u','У'=>'U',
            'ф'=>'f','Ф'=>'F',
            'х'=>'h','Х'=>'H',
            'ц'=>'c','Ц'=>'TS',
            'ч'=>'ch','Ч'=>'CH',
            'ш'=>'sh','Ш'=>'SH',
            'щ'=>'sch','Щ'=>'SHC',
            'ъ'=>'','Ъ'=>'',
            'ы'=>'i','Ы'=>'I',
            'ь'=>'','Ь'=>'',
            'э'=>'e','Э'=>'E',
            'ю'=>'yu','Ю'=>'YU',
            'я'=>'ya','Я'=>'YA'],

        'ukrainian' => [
            'і'=>'i','І'=>'I',
            'ї'=>'yi','Ї'=>'YI',
            'є'=>'e','Є'=>'E'

        ]
    ];

    public function __construct(string $string){
        $this->setString($string);
    }



    public function getString() : string {
        return $this->string;
    }

    public function setString(string $string) : self {
        $this->string = $string;

        return $this;
    }



    public function getSymbols() : array {
        return $this->symbols;
    }

    public function setSymbols(array $symbols) : self {
        $this->symbols = $symbols;

        return $this;
    }



    public function toLatin(string $except_to = '_') : string {

        $string = $this->getString();

        foreach($this->getSymbols() as $symbol){
            $string = strtr($string, $symbol);
        }

        $string = transliterator_transliterate('Any-Latin;Latin-ASCII;', $string);

        return preg_replace('/[^a-zA-Z0-9\\'.$except_to.']+/iu', $except_to, $string);
    }
}