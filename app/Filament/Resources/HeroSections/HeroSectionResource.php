<?php

namespace App\Filament\Resources\HeroSections;

use App\Filament\Resources\HeroSections\Pages\ManageHeroSections;
use App\Models\HeroSection;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static \UnitEnum|string|null $navigationGroup = 'Konten & Halaman';

    protected static ?string $modelLabel = 'Hero Section';

    protected static ?string $pluralModelLabel = 'Hero Section Beranda';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('badge_text')
                    ->label('Teks Badge Atas')
                    ->placeholder('Contoh: Fresh Bake hari ini')
                    ->default('Fresh Bake hari ini')
                    ->required(),

                TextInput::make('title')
                    ->label('Judul Utama Hero (Headline)')
                    ->placeholder('Klik, dipanggang, sampai.')
                    ->required()
                    ->maxLength(255),

                Textarea::make('subtitle')
                    ->label('Sub-judul / Penjelasan')
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Pesan roti & kue segar dari Makassar...'),

                TextInput::make('button_text')
                    ->label('Teks Tombol Utama')
                    ->default('Pesan Sekarang')
                    ->required(),

                TextInput::make('button_link')
                    ->label('Link Tombol Utama')
                    ->default('/katalog')
                    ->required(),

                TextInput::make('secondary_button_text')
                    ->label('Teks Tombol Kedua (Opsional)')
                    ->default('Lihat Menu'),

                TextInput::make('secondary_button_link')
                    ->label('Link Tombol Kedua')
                    ->default('#kategori'),

                TextInput::make('image_url')
                    ->label('Path Gambar Hero (Relatif di public/ atau URL)')
                    ->placeholder('products/hero-makassar.jpg')
                    ->default('products/hero-makassar.jpg'),

                Select::make('featured_product_id')
                    ->label('Produk Unggulan pada Kartu Hero (Opsional)')
                    ->relationship('featuredProduct', 'name')
                    ->searchable()
                    ->preload(),

                TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->label('Aktifkan di Beranda')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Utama')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('badge_text')
                    ->label('Badge')
                    ->badge()
                    ->color('warning'),

                TextColumn::make('button_text')
                    ->label('Tombol CTA')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('featuredProduct.name')
                    ->label('Produk Ditampilkan')
                    ->placeholder('Otomatis'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
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
            'index' => ManageHeroSections::route('/'),
        ];
    }
}
