<?php

namespace App\Helpers;

class MarkdownHelper
{
    static function markdownEscape($str) {
        $specialCharacters = [
            '\\' => '\\\\',
            '`' => '\\`',
            '*' => '\\*',
            '_' => '\\_',
            '#' => '\\#',
            '+' => '\\+',
            '-' => '\\-',
            '!' => '\\!',
            '|' => '\\|',
            '{' => '\\{',
            '}' => '\\}',
            '[' => '&#91;',
            ']' => '&#93;',
            '(' => '\\(',
            ')' => '\\)',
        ];

        return str_replace(array_keys($specialCharacters), array_values($specialCharacters), $str);
    }
}
