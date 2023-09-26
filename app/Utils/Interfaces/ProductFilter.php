<?php

namespace App\Utils\Interfaces;

interface ProductFilter
{
    public function hasSearch(): bool;

    public function getSearch(): string | null;

    public function hasCategoryId(): bool;

    public function getCategoryId(): int | null;
}
