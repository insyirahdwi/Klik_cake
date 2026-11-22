<?php

namespace App\Filament\Resources\CustomPages;

use App\Filament\Resources\CustomPages\Pages\ManagePages;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $slug = 'pages';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;

    protected static \UnitEnum|string|null $navigationGroup = 'Konten & Halaman';

    protected static ?string $modelLabel = 'Halaman Statis';

    protected static ?string $pluralModelLabel = 'Halaman Statis & Informasi';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Halaman')
                    ->placeholder('Contoh: Tentang Kami')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Slug URL')
                    ->placeholder('tentang-kami')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('meta_description')
                    ->label('Deskripsi Singkat (SEO)')
                    ->rows(2)
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->label('Isi Konten Halaman')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_published')
                    ->label('Publikasikan')
                    ->default(true),

                Toggle::make('show_in_header')
                    ->label('Tampilkan di Menu Atas')
                    ->default(false),

                Toggle::make('show_in_footer')
                    ->label('Tampilkan di Menu Footer')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Halaman')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('URL Slug')
                    ->fontFamily('mono')
                    ->color('primary')
                    ->formatStateUsing(fn ($state) => '/' . $state),

                IconColumn::make('is_published')
                    ->label('Terbit')
                    ->boolean()
                    ->alignCenter(),

                IconColumn::make('show_in_footer')
                    ->label('Menu Footer')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
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
            'index' => ManagePages::route('/'),
        ];
    }
}
