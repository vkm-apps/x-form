<?php

namespace VkmApps\XForm\Traits;

use NumberFormatter;

trait HasMoneyFormatting
{
    protected static array $moneyFormatCache = [];

    /**
     * Resolve currency formatting options for a given locale and currency.
     */
    public function resolveMoneyFormat(string $locale, string $currency): array
    {
        // Normalize locale format (replace hyphens with underscores)
        $locale = str_replace('-', '_', $locale);

        $cacheKey = "{$locale}_{$currency}";

        if (isset(self::$moneyFormatCache[$cacheKey])) {
            return self::$moneyFormatCache[$cacheKey];
        }

        $defaults = [
            'symbol' => $currency,
            'position' => 'prefix',
            'decimal_separator' => '.',
            'thousands_separator' => ',',
            'precision' => 2,
        ];

        if (!class_exists(NumberFormatter::class)) {
            return self::$moneyFormatCache[$cacheKey] = $defaults;
        }

        try {
            $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

            $decimalSeparator = $formatter->getSymbol(NumberFormatter::MONETARY_SEPARATOR_SYMBOL);
            $thousandsSeparator = $formatter->getSymbol(NumberFormatter::MONETARY_GROUPING_SEPARATOR_SYMBOL);
            $precision = $formatter->getAttribute(NumberFormatter::FRACTION_DIGITS);

            // Format a test value to check symbol position
            $formatted = $formatter->formatCurrency(1.00, $currency);

            // Clean formatting spacers
            $cleanFormatted = trim(str_replace(["\xc2\xa0", "\u{00A0}", "\u{202F}", ' '], '', $formatted));

            // Extract the symbol from the formatted currency string by removing numbers, decimal separator, thousands separator, and spaces
            $stripChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', $decimalSeparator, $thousandsSeparator, ' ', "\xc2\xa0", "\u{00A0}", "\u{202F}"];
            $symbol = trim(str_replace($stripChars, '', $formatted));

            $cleanSymbol = trim(str_replace(["\xc2\xa0", "\u{00A0}", "\u{202F}", ' '], '', $symbol));

            $position = 'prefix';
            if ($cleanSymbol !== '') {
                if (str_ends_with($cleanFormatted, $cleanSymbol)) {
                    $position = 'suffix';
                }
            }

            self::$moneyFormatCache[$cacheKey] = [
                'symbol' => $symbol ?: $currency,
                'position' => $position,
                'decimal_separator' => $decimalSeparator,
                'thousands_separator' => $thousandsSeparator,
                'precision' => $precision,
            ];
        } catch (\Throwable $e) {
            self::$moneyFormatCache[$cacheKey] = $defaults;
        }

        return self::$moneyFormatCache[$cacheKey];
    }
}
