<?php

namespace App\Data;

class ClientFilterData
{

    public function __construct(
        protected ?string $code,
        protected ?int    $minSold,
        protected ?int    $maxSold,
    )
    {
    }

    public function hasCode(): bool
    {
        return empty($this->code);
    }


    public function hasMinSold(): bool
    {
        return empty($this->minSold);
    }


    public function hasMaxSold(): bool
    {
        return empty($this->maxSold);
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getMinSold(): ?int
    {
        return $this->minSold;
    }

    public function setMinSold(?int $minSold): void
    {
        $this->minSold = $minSold;
    }

    public function getMaxSold(): ?int
    {
        return $this->maxSold;
    }

    public function setMaxSold(?int $maxSold): void
    {
        $this->maxSold = $maxSold;
    }

}
