<?php

namespace App\Filament\Resources\Articles;

use App\Filament\Resources\Articles\Pages\ManageArticles;
use App\Models\Article;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static \UnitEnum|string|null $navigationGroup = 'Konten & Halaman';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?string $pluralModelLabel = 'Artikel & Berita';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Artikel')
                    ->placeholder('Contoh: Rahasia Kelembutan Bolu Chiffon')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->label('Slug URL')
                    ->placeholder('rahasia-kelembutan-bolu-chiffon')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Select::make('category_id')
                    ->label('Kategori Artikel')
                    ->relationship('category', 'name')
                    ->placeholder('-- Pilih Kategori --')
                    ->searchable()
                    ->preload(),

                TextInput::make('author_name')
                    ->label('Nama Penulis / Redaksi')
                    ->default('Dapur Pinky Cake')
                    ->required(),

                DateTimePicker::make('published_at')
                    ->label('Jadwal Terbit')
                    ->default(now()),

                Textarea::make('excerpt')
                    ->label('Ringkasan / Cuplikan Singkat (Excerpt)')
                    ->rows(2)
                    ->columnSpanFull()
                    ->placeholder('Ringkasan singkat yang tampil pada kartu artikel...'),

                RichEditor::make('content')
                    ->label('Isi Konten Artikel')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_published')
                    ->label('Publikasikan Sekarang')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->weight('bold')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                TextColumn::make('author_name')
                    ->label('Penulis')
                    ->color('gray'),

                TextColumn::make('published_at')
                    ->label('Tanggal Terbit')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('view_count')
                    ->label('Dibaca')
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),

                IconColumn::make('is_published')
                    ->label('Terbit')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->defaultSort('published_at', 'desc')
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
            'index' => ManageArticles::route('/'),
        ];
    }
}
