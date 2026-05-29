<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Textarea;

class CKEditor extends Textarea
{
    public function getView(): string
    {
        return 'filament.form.components.ckeditor';
    }
   
}
