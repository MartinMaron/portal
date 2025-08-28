<?php

namespace App\Http\Traits\Helper;

/**
 * Reusable number formatting helper for Livewire components.
 * Components define a $numericFormatMap = ['property' => decimals].
 * Call $this->handleNumericFormatting($property) inside updated($property).
 */
trait FormatsNumbers
{
    // Erwartet, dass die verwendende Komponente eine protected array $numericFormatMap Property bereitstellt
    // z.B.: protected array $numericFormatMap = ['current.brutto' => 2];

    protected function handleNumericFormatting(string $property): void
    {
        if (! isset($this->numericFormatMap[$property])) {
            return;
        }
        $decimals = $this->numericFormatMap[$property];
        $raw = data_get($this, $property);
        $normalized = $this->normalizeNumber($raw);
        if ($normalized === null) {
            return; // keep empty or invalid input unchanged
        }
        $formatted = $this->formatNumber($normalized, $decimals);
        if ($formatted !== $raw) {
            data_set($this, $property, $formatted);
        }
    }

    protected function normalizeNumber($value): ?float
    {
        if ($value === null) return null;
        $value = trim((string) $value);
        if ($value === '') return null;
        $value = str_replace([' '], '', $value);
        $value = str_replace('.', '', $value); // remove thousands separator
        $value = str_replace(',', '.', $value); // decimal comma to point
        if (! is_numeric($value)) return null;
        return (float) $value;
    }

    protected function formatNumber(float $value, int $decimals): string
    {
        return number_format($value, $decimals, ',', '.');
    }
}
