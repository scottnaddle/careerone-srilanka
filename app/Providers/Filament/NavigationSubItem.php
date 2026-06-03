<?php

namespace App\Providers\Filament;
use Filament\Navigation\NavigationItem;

class NavigationSubItem extends NavigationItem
{
    protected array $subItems = [];

    public function subItems(array $items): static
    {
        $this->subItems = $items;
        return $this;
    }

    public function getSubItems(): array
    {
        return $this->subItems;
    }
}
