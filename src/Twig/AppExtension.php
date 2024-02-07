<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('readnb', [$this, 'readableNumber']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_numeric', [$this, 'isNumeric']),
        ];
    }

    public function readableNumber(string $value, string $mode = ''): string
    {
        return match ($mode) {
            '€' => number_format($value / 100, 2, ',', ' ') . ' €',
            '%', 'g', 'kg', 'm', 'cm' => number_format($value, 2, ',', ' ')  . $mode,
            default => number_format($value, 0, ',', ' '),
        };
    }

    public function isNumeric(string $input): bool
    {
        $replacments = [
            ' ' => '',
            ',' => '.',
            '€' => '',
            '%' => '',
            'g' => '',
            'kg' => '',
            'm' => '',
            'cm' => '',
        ];
        return is_numeric(strtr($input, $replacments));
    }
}
