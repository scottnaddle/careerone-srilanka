<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\CKEditor;
use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use TomatoPHP\FilamentMediaManager\Form\MediaManagerInput;
use App\Filament\Forms\Components\WebpMediaManagerInput;
class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;
    protected static int $globalSearchResultsLimit = 10;

    protected static ?int $navigationSort = -1;
    protected static ?string $navigationIcon = 'fluentui-image-shadow-24';

    protected static function getLastSortValue(): int
    {
        return Banner::max('sort') ?? 0;
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Tabs::make(__('admin/dashboard.banner.details'))
                ->tabs([
                    Forms\Components\Tabs\Tab::make(__('admin/dashboard.banner.general'))
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            Forms\Components\Section::make(__('admin/dashboard.banner.main_details'))
                                ->description(__('admin/dashboard.banner.main_details_description'))
                                ->icon('heroicon-o-clipboard')
                                ->schema([
                                    Forms\Components\TextInput::make('banner_title')
                                        ->label(__('admin/dashboard.banner.banner_title'))
                                        ->maxLength(255)
                                        ->columnSpan(2),
                                    Forms\Components\Select::make('is_visible')
                                        ->label(__('admin/dashboard.banner.visibility'))
                                        ->default(1)
                                        ->options([
                                            0 => __('admin/dashboard.banner.visibility_no'),
                                            1 => __('admin/dashboard.banner.visibility_yes'),
                                        ])
                                        ->native(false)
                                        ->required(),
                                    Forms\Components\TextInput::make('title')
                                        ->label(__('admin/dashboard.banner.title'))
                                        ->maxLength(255)
                                        ->columnSpan(2),
                                    CKEditor::make('description')
                                        ->label(__('admin/dashboard.banner.description'))
                                        ->helperText(__('admin/dashboard.banner.description_helper'))
                                        ->maxLength(500)
                                        ->columnSpanFull(),
                                ])
                                ->compact()
                                ->columns(2),
                        ]),
                    Forms\Components\Tabs\Tab::make(__('admin/dashboard.banner.images'))
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\Section::make(__('admin/dashboard.banner.image_section'))
                                ->description(__('admin/dashboard.banner.image_section_description'))
                                ->schema([
                                    WebpMediaManagerInput::make('_url')
                                        ->hiddenLabel()
                                        ->schema([])
                                        ->defaultItems(1)
                                        ->minItems(1)
                                        ->maxItems(1),
                                ])
                                ->compact(),
                        ]),
                    Forms\Components\Tabs\Tab::make(__('admin/dashboard.banner.scheduling'))
                        ->icon('heroicon-o-calendar')
                        ->schema([
                            Forms\Components\Section::make(__('admin/dashboard.banner.schedule_section'))
                                ->description(__('admin/dashboard.banner.schedule_section_description'))
                                ->schema([
                                    Forms\Components\DateTimePicker::make('start_date')
                                        ->label(__('admin/dashboard.banner.start_date'))
                                        ->helperText(__('admin/dashboard.banner.start_date_helper')),
                                    Forms\Components\DateTimePicker::make('end_date')
                                        ->label(__('admin/dashboard.banner.end_date'))
                                        ->helperText(__('admin/dashboard.banner.end_date_helper')),
                                ])
                                ->compact()
                                ->columns(2),
                        ]),
                    Forms\Components\Tabs\Tab::make(__('admin/dashboard.banner.additional_settings'))
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Forms\Components\Section::make(__('admin/dashboard.banner.settings_section'))
                                ->description(__('admin/dashboard.banner.settings_section_description'))
                                ->schema([
                                    Forms\Components\TextInput::make('sort')
                                        ->label(__('admin/dashboard.banner.sort_order'))
                                        ->helperText(__('admin/dashboard.banner.sort_order_helper'))
                                        ->required()
                                        ->numeric()
                                        ->default(static::getLastSortValue() + 1),
                                    Forms\Components\TextInput::make('click_url')
                                        ->label(__('admin/dashboard.banner.click_url'))
                                        ->helperText(__('admin/dashboard.banner.click_url_helper'))
                                        ->default('#')
                                        ->maxLength(255),
                                    Forms\Components\Select::make('click_url_target')
                                        ->label(__('admin/dashboard.banner.click_url_target'))
                                        ->helperText(__('admin/dashboard.banner.click_url_target_helper'))
                                        ->options([
                                            '_blank' => __('admin/dashboard.banner.new_tab'),
                                            '_self' => __('admin/dashboard.banner.current_tab'),
                                            '_parent' => __('admin/dashboard.banner.parent_frame'),
                                            '_top' => __('admin/dashboard.banner.full_window'),
                                        ])
                                        ->native(false),
                                ])
                                ->compact(),
                        ]),
                ])
                ->columnSpanFull(),
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
//            SpatieMediaLibraryImageColumn::make('media')
//                ->label(__('admin/dashboard.banner.images'))
//                ->collection('images')
//                ->wrap(),
//
//            Tables\Columns\TextColumn::make('title')
//                ->label(__('admin/dashboard.banner.title'))
//                ->limit(50)
//                ->description(function (Model $record): string {
//                    $description = $record->description ?? '';
//                    return strip_tags((new CommonMarkConverter())->convert($description)->getContent());
//                })
//                ->lineClamp(2)
//                ->wrap()
//                ->searchable()
//                ->extraAttributes(['class' => '!w-96']),
            Tables\Columns\TextColumn::make('banner_title')
                ->label(__('admin/dashboard.banner.banner_title'))
                ->limit(50)
//                ->description(function (Model $record): string {
//                    $description = $record->description ?? '';
//                    return strip_tags((new CommonMarkConverter())->convert($description)->getContent());
//                })
//                ->lineClamp(2)
//                ->wrap()
                ->searchable()
                ->extraAttributes(['class' => '!w-96']),

            Tables\Columns\IconColumn::make('is_visible')
                ->label(__('admin/dashboard.banner.visibility'))
                ->boolean()
                ->alignCenter(),

            Tables\Columns\TextColumn::make('start_date')
                ->label(__('admin/dashboard.banner.start_date'))
                ->dateTime()
                ->sortable(),

            Tables\Columns\TextColumn::make('end_date')
                ->label(__('admin/dashboard.banner.end_date'))
                ->dateTime()
                ->sortable(),

            Tables\Columns\TextColumn::make('click_url')
                ->label(__('admin/dashboard.banner.click_url'))
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('created_at')
                ->label(__('admin/dashboard.banner.created_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
                ->label(__('admin/dashboard.banner.updated_at'))
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->searchPlaceholder('Title')
            ->filters([
                // Tables\Filters\SelectFilter::make('category')
                //     ->relationship('category', 'name')
                //     ->searchable(),
                Tables\Filters\TernaryFilter::make('is_visible')
                    ->label('Visibility')
                    ->trueLabel('Visible')
                    ->falseLabel('Hidden')
                    ->nullable(),
                Tables\Filters\Filter::make('start_date')
                    ->form([
                        Forms\Components\DatePicker::make('start_date'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['start_date'] ?? null, fn($query, $date) => $query->whereDate('start_date', '>=', $date));
                    }),
                Tables\Filters\Filter::make('end_date')
                    ->form([
                        Forms\Components\DatePicker::make('end_date'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['end_date'] ?? null, fn($query, $date) => $query->whereDate('end_date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->hiddenLabel()->tooltip('Detail'),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip('Edit'),
                Tables\Actions\DeleteAction::make()->hiddenLabel()->tooltip('Delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->paginated([10, 25, 50, 100])
            ->defaultSort('updated_at', 'desc')
            ->reorderable('updated_at');
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category']);
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->title;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'category.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Category' => $record->category->name,
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __("menu.nav_group.banner");
    }
}
