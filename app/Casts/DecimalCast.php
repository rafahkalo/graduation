<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class DecimalCast implements CastsAttributes
{
    protected int $precision;
    protected string $decimalSeparator;
    protected string $thousandsSeparator;

    public function __construct(int $precision = 2, string $decimalSeparator = '.', string $thousandsSeparator = '')
    {
        $this->precision = $precision;
        $this->decimalSeparator = $decimalSeparator;
        $this->thousandsSeparator = $thousandsSeparator;
    }

    /**
     * Cast the given value from database to proper decimal format.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return string|null
     */
    public function get($model, string $key, $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        $floatValue = (float) $value;
        $formatted = number_format(
            $floatValue,
            $this->precision,
            $this->decimalSeparator,
            $this->thousandsSeparator
        );

        // Remove trailing zeros and possible decimal point if not needed
        if (strpos($formatted, $this->decimalSeparator) !== false) {
            $formatted = rtrim($formatted, '0');
            $formatted = rtrim($formatted, $this->decimalSeparator);
        }

        return $formatted !== '' ? $formatted : '0';
    }

    /**
     * Prepare the given value for storage in database.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return float|null
     * @throws InvalidArgumentException
     */
    public function set($model, string $key, $value, array $attributes): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!is_numeric($value)) {
            throw new InvalidArgumentException(
                "The value for field {$key} must be numeric, got " . gettype($value)
            );
        }

        // Remove thousands separators if present
        if (is_string($value) && $this->thousandsSeparator !== '') {
            $value = str_replace($this->thousandsSeparator, '', $value);
        }

        // Convert to float with proper decimal separator
        if (is_string($value)) {
            $value = str_replace($this->decimalSeparator, '.', $value);
        }

        return round((float) $value, $this->precision);
    }
}
