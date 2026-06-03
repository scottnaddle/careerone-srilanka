<?php
Namespace App\Filament\Pages\Auth\PasswordReset;
use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\PasswordReset\RequestPasswordReset as BasePasswordReset;
use Illuminate\Support\Facades\Auth;

class RequestPasswordReset extends BasePasswordReset
{
    /**
     * @var view-string
     */
    protected static string $view = 'admin.auth.password-reset';
    public function mount(): void
    {
        parent::mount();

        // Check if the user is already authenticated
        if (Auth::guard('admin')->check()) {
            // Redirect to the custom path if authenticated
            redirect()->to('/admin/overview'); // No return here
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('system.form.email'))
            ->extraAttributes([
                'class' => 'text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300'
            ])
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getRequestFormAction(): Action
    {
        return parent::getRequestFormAction()
            ->label(__('system.form.send_reset_password_link'))
            ->extraAttributes([
                'class' => 'w-full text-white bg-[#4984F6] mt-2 hover:bg-blue-800 focus:ring-4
                        focus:ring-blue-300 font-medium rounded-full text-xl px-5 py-3 text-center
                        dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800',
            ]);
    }

}
