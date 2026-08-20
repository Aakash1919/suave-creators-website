<?php

namespace App\View\Components\Frontend;

use App\Support\Frontend\CaseStudySupport;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CaseStudyMetricValue extends Component
{
    /**
     * @var array{raw: string, numeric: bool, prefix: string, end: float, decimals: int, suffix: string, pad: int}
     */
    public array $parsed;

    public string $initial;

    public function __construct(
        public string $value = '',
        public string $tag = 'span',
    ) {
        $this->tag = in_array($this->tag, ['span', 'p', 'strong'], true) ? $this->tag : 'span';
        $this->parsed = CaseStudySupport::parseMetricValue($this->value);
        $this->initial = self::initialNumber($this->parsed);
    }

    /**
     * @param  array{decimals: int, pad: int}  $parsed
     */
    protected static function initialNumber(array $parsed): string
    {
        if (! empty($parsed['decimals'])) {
            return number_format(0, (int) $parsed['decimals'], '.', '');
        }

        $pad = (int) ($parsed['pad'] ?? 0);

        return $pad > 1 ? str_pad('0', $pad, '0', STR_PAD_LEFT) : '0';
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.case-study-metric-value');
    }
}
