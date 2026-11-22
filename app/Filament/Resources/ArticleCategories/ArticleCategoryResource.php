<?php

namespace App\Filament\Resources\ArticleCategories;

use App\Filament\Resources\ArticleCategories\Pages\ManageArticleCategories;
use App\Models\ArticleCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArticleCategoryResource extends Resource
{
    protected static ?string $model = ArticleCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static \UnitEnum|string|null $navigationGroup = 'Konten & Halaman';

    protected static ?string $modelLabel = 'Kategori Artikel';

    protected static ?string $pluralModelLabel = 'Kategori Artikel';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->placeholder('Contoh: Tips & Resep Kue')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Slug URL')
                    ->placeholder('tips-dan-resep')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->fontFamily('mono')
                    ->color('gray'),

                TextColumn::make('articles_count')
                    ->label('Total Artikel')
                    ->counts('articles')
                    ->badge()
                    ->color('primary')
                    ->alignCenter(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageArticleCategories::route('/'),
        ];
    }
}
