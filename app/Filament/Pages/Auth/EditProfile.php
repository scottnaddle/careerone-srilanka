<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditProfile extends BaseEditProfile
{
    public $record;

    public function mount(): void
    {
        $this->record = Auth::guard('admin')->user();
        $this->form->fill($this->record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nic')
                    ->label('NIC')
                    ->maxLength(12)
                    ->required(),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(150)
                    ->disabled(),

                // Handle password and confirmation properly
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->maxLength(255)
                    ->live()
                    ->requiredWith('password_confirmation')->revealable()
                    ->dehydrateStateUsing(function ($state, $get) {
                        if (filled($state)) {
                            // Ensure password matches confirmation before hashing
                            if ($state !== $get('password_confirmation')) {
                                throw new \Exception(__('The password and confirmation must match.'));
                            }
                            return Hash::make($state); // Hash only if valid
                        }
                        return $this->record->password; // Keep old password if empty
                    }),

                TextInput::make('password_confirmation')
                    ->label('Confirm Password')
                    ->password()
                    ->maxLength(255)
                    ->live()->revealable()
                    ->afterStateHydrated(function ($set, $state) {
                        // Make sure the field is reset after hydration
                        $set('password_confirmation', '');
                    }),

                TextInput::make('first_name')
                    ->label('First Name')
                    ->required()
                    ->maxLength(60),

                TextInput::make('last_name')
                    ->label('Last Name')
                    ->required()
                    ->maxLength(60),

                TextInput::make('phone')
                    ->label('Phone')
                    ->required()
                    ->maxLength(20),

                Select::make('tvet_type')
                    ->label(__('admin/dashboard.cgo.tvet_type'))
                    ->options($this->getTvetTypeOptions())
                    ->columnSpan('full')
                    ->required(),
            ]);
    }

    protected function getTvetTypeOptions(): array
    {
        return \App\Models\TvetType::pluck('head_office_name', 'head_office_code')->toArray();
    }
}







