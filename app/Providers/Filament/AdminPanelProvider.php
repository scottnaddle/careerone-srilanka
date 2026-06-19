<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\PasswordReset\RequestPasswordReset;
use App\Filament\Pages\Auth\Register;
use App\Filament\Pages\EmergencyUserReset;
use App\Filament\Resources\JobResource;
use App\Http\Middleware\AccountMustVerifyByAdmin;
use App\Http\Middleware\LocalizationMiddleware;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Pages\Auth\EditProfile;
use Filament\Facades\Filament;
use Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin;
use Datlechin\FilamentMenuBuilder\Models\Menu;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\AdminUser;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Kenepa\TranslationManager\Http\Middleware\SetLanguage;
use Kenepa\TranslationManager\TranslationManagerPlugin;
use Illuminate\Support\Facades\Blade;
use Filament\View\PanelsRenderHook;
use Filament\Navigation\MenuItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::hex('#4984F6'),
            ])
            ->profile(EditProfile::class, isSimple: false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->pages([
                EmergencyUserReset::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetLanguage::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('admin')
            ->login(Login::class)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->brandLogo(asset('images/careerone-logo.png'))
            ->homeUrl(url('/admin/overview'))
            ->brandLogoHeight('2rem')
            ->passwordReset(RequestPasswordReset::class)
            ->authPasswordBroker('admin_users')
            ->middleware(['account_must_verified_by_admin'])
            ->loginRouteSlug('auth/login')
            ->passwordResetRoutePrefix('auth/password-reset')
            ->passwordResetRequestRouteSlug('auth/request')
            ->passwordResetRouteSlug('auth/reset')
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->plugins(array_filter([
                \TomatoPHP\FilamentMediaManager\FilamentMediaManagerPlugin::make()
                    ->allowSubFolders(),
                TranslationManagerPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                \BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin::make(),
                FilamentMenuBuilderPlugin::make()
                    ->addMenuItemFields([
                        ...(
                        Schema::hasTable('roles')
                            ? [
                            Select::make('capability')
                                ->options(Role::all()->pluck('name', 'name'))
                                ->preload()->multiple()
                                ->formatStateUsing(function ($state) {
                                    if (is_string($state)) {
                                        return array_map('trim', explode(',', $state));
                                    }
                                    return $state;
                                })->dehydrateStateUsing(fn ($state) => is_array($state) ? implode(',', $state) : $state)
                                ->searchable(),
                            TextInput::make('icon'),
                        ]
                            : []
                        ),
                    ])
                    ->addLocation('header', 'Header')
                    ->addLocation('footer', 'Footer'),
            ]))
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                $menuHeader = Menu::location('header');

                // Helper function to check if user has any of the required capabilities
                $userHasCapability = function($capabilities) {
                    if (empty($capabilities)) {
                        return true; // No capability required
                    }

                    // Split capabilities by comma and trim whitespace
                    $capabilityArray = array_map('trim', explode(',', $capabilities));

                    // Check if user has super_admin role or any of the required capabilities
                    return auth('admin')->user()->hasRole('super_admin') ||
                        collect($capabilityArray)->contains(function($capability) {
                            return auth('admin')->user()->hasRole($capability);
                        });
                };

                if (!empty($menuHeader)) {
                    $builder->items(
                        $menuHeader->menuItems->map(function ($item) use ($userHasCapability) {
                            $icon = DB::table(config('filament-menu-builder.tables.menu_icon'))
                                ->where('menu_item_id', $item->id)
                                ->value('icon');

                            $isVisible = $userHasCapability($item->capability);
                            $title = is_array($item->title) ? $item->title['default'] : $item->title;

                            return NavigationSubItem::make(__($title))
                                ->visible(fn() => $isVisible)
                                ->url($item->url)
                                ->icon($icon)
                                ->isActiveWhen(fn(): bool => str_starts_with(request()->getPathInfo(), $item->url))
                                ->subItems(
                                    $item->children->map(function ($child) use ($userHasCapability) {
                                        $isChildVisible = $userHasCapability($child->capability);

                                        return $isChildVisible ? NavigationSubItem::make(__($child->title))
                                            ->url($child->url)
                                            ->isActiveWhen(fn(): bool => str_starts_with(request()->getPathInfo(), $child->url))
                                            ->subItems(
                                                $child->children->map(function ($grandChild) use ($userHasCapability) {
                                                    $isGrandChildVisible = $userHasCapability($grandChild->capability);

                                                    return $isGrandChildVisible ? NavigationItem::make(__($grandChild->title))
                                                        ->url($grandChild->url)
                                                        ->isActiveWhen(fn(): bool => str_starts_with(request()->getPathInfo(), $grandChild->url))
                                                        : null;
                                                })->filter()->toArray()
                                            ) : null;
                                    })->filter()->toArray()
                                );
                        })->filter()->toArray()
                    );
                }
                return $builder;
            })
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn (): string => Blade::render('@livewire(\'Accessibility\')'),
            )
            ->sidebarCollapsibleOnDesktop()
            ->userMenuItems([
                'profile' => MenuItem::make()->label('My page'),
                MenuItem::make()
                    ->label(__('admin/dashboard.download_user_manual'))
                    ->icon('heroicon-o-arrow-down')
                    ->url('/admin/download-user-manual')
                    ->openUrlInNewTab(),
            ])
            ->darkMode(false)
            ->globalSearch(false);
    }
}
