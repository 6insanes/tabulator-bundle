<?php

declare(strict_types=1);

namespace DeviantLab\TabulatorBundle\Formatter;

use DeviantLab\TabulatorBundle\FormatterInterface;

final class TickCrossFormatter implements FormatterInterface
{
    public function __construct(
        private readonly ?bool $allowEmpty = null,
        private readonly ?bool $allowTruthy = null,
        private readonly ?string $tickElement = null,
        private readonly ?string $crossElement = null,
    )
    {

    }

    public function getName(): string
    {
        return 'tickCross';
    }

    public function getParams(): array
    {
        $result = [];
        if ($this->allowEmpty !== null) {
            $result['allowEmpty'] = $this->allowEmpty;
        }
        if ($this->allowTruthy !== null) {
            $result['allowTruthy'] = $this->allowTruthy;
        }
        if ($this->tickElement !== null) {
            $result['tickElement'] = $this->tickElement;
        }
        if ($this->crossElement !== null) {
            $result['crossElement'] = $this->crossElement;
        }

        return $result;
    }
}
