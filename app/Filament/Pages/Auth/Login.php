<?php
Namespace App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\ValidationException;
use App\Http\Responses\CustomLoginResponse;
use Illuminate\Support\Facades\Auth;
class Login extends BaseLogin
{

    /**
     * @var view-string
     */
    protected static string $view = 'admin.auth.signin';
    public function mount(): void
    {
        parent::mount();

        // Check if the user is already authenticated
        if (Auth::guard('admin')->check()) {
            // Redirect to the custom path if authenticated
            redirect()->to('/admin/overview'); // No return here
        }
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): string => Blade::render("@vite(['resources/css/app.css', 'resources/js/app.js'])"), // Thay thế bằng đường dẫn file Vite của bạn
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
            ])
            ->statePath('data');
    }


    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(trans('system.form.password'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->autocomplete('current-password')
            ->required()->placeholder('**************')
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getEmailFormComponent(): Component
    {
        return parent::getEmailFormComponent()->label(trans('system.form.email'))
            ->placeholder('email@email.com');
    }


    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label(trans('auth.sign_in'))
            ->submit('authenticate')
            ->extraAttributes(['class' => 'w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-8']);
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        if (! Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();

        if (
            ($user instanceof FilamentUser) &&
            (! $user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(CustomLoginResponse::class);
    }
//    protected function throwFailureValidationException(): never
//    {
//        throw ValidationException::withMessages([
//            'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
//        ]);
//    }


}
