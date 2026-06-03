<?php
Namespace App\Filament\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Filament\Support\Enums\VerticalAlignment;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Actions\Action;
class Register extends BaseRegister
{

    /**
     * @var view-string
     */
    protected static string $view = 'admin.auth.signup';




}
