<?php

namespace App\Filament\Resources;

use Datlechin\FilamentMenuBuilder\Resources\MenuResource as BaseMenuResource;
use Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin;
use Filament\Forms\Components;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class MenuResource extends BaseMenuResource
{
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';
    protected static ?string $modelLabel = null;
    public static function getModel(): string
    {
        return FilamentMenuBuilderPlugin::get()->getMenuModel();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Components\Grid::make(4)
                    ->schema([
                        Components\TextInput::make('name')
                            ->label(__('filament-menu-builder::menu-builder.resource.name.label'))
                            ->required()
                            ->columnSpan(3),

                        Components\ToggleButtons::make('is_visible')
                            ->grouped()
                            ->options([
                                true => __('filament-menu-builder::menu-builder.resource.is_visible.visible'),
                                false => __('filament-menu-builder::menu-builder.resource.is_visible.hidden'),
                            ])
                            ->colors([
                                true => 'primary',
                                false => 'danger',
                            ])
                            ->required()
                            ->label(__('filament-menu-builder::menu-builder.resource.is_visible.label'))
                            ->default(true),
                    ]),

                Components\Group::make()
                    ->visible(fn (Component $component) => $component->evaluate(FilamentMenuBuilderPlugin::get()->getMenuFields()) !== [])
                    ->schema(FilamentMenuBuilderPlugin::get()->getMenuFields()),
            ]);
    }

    public static function table(Table $table): Table
    {
        $locations = FilamentMenuBuilderPlugin::get()->getLocations();

        return $table
            ->modifyQueryUsing(fn ($query) => $query->withCount('menuItems'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->label(__('filament-menu-builder::menu-builder.resource.name.label')),
                Tables\Columns\TextColumn::make('locations.location')
                    ->label(__('filament-menu-builder::menu-builder.resource.locations.label'))
                    ->default(__('filament-menu-builder::menu-builder.resource.locations.empty'))
                    ->color(fn (string $state) => array_key_exists($state, $locations) ? 'primary' : 'gray')
                    ->formatStateUsing(fn (string $state) => $locations[$state] ?? $state)
                    ->limitList(2)
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('menu_items_count')
                    ->label(__('filament-menu-builder::menu-builder.resource.items.label'))
                    ->icon('heroicon-o-link')
                    ->numeric()
                    ->default(0)
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->label(__('filament-menu-builder::menu-builder.resource.is_visible.label'))
                    ->sortable()
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])->paginated([10, 25, 50, 100])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \Datlechin\FilamentMenuBuilder\Resources\MenuResource\Pages\ListMenus::route('/'),
            'edit' => \Datlechin\FilamentMenuBuilder\Resources\MenuResource\Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
