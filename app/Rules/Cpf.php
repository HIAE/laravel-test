<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class Cpf implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $digits = preg_replace('/\D/', '', $value);

        $message = 'O CPF deve ser válido.';

        if (strlen($digits) != 11 || preg_match("/^{$digits[0]}{11}$/", $digits)) {
            $fail($message);
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $digits[$i++] * $s--);

        if ($digits[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $fail($message);
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $digits[$i++] * $s--);

        if ($digits[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $fail($message);
        }
    }
}
