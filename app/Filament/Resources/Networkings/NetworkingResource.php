<?php

namespace App\Filament\Resources\Networkings;

use App\Filament\Resources\Networkings\Pages\ManageNetworkings;
use App\Models\Networking;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NetworkingResource extends Resource
{
    protected static ?string $model = Networking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShare;

    protected static \UnitEnum|string|null $navigationGroup = 'Jejaring & Mitra';

    protected static ?string $modelLabel = 'Jejaring / Mitra';

    protected static ?string $pluralModelLabel = 'Jejaring, Cabang & Mitra';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Titik / Channel / Mitra')
                    ->placeholder('Contoh: Dapur Pusat Panakkukang / Instagram @pinkycakemks')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->label('Tipe Jejaring')
                    ->options([
                        'social_media' => 'Media Sosial & Channel',
                        'outlet' => 'Cabang Outlet Pick-up',
                        'kitchen' => 'Dapur Produksi',
                        'reseller' => 'Mitra Reseller Resmi',
                        'partner' => 'Mitra Kerjasama / Kolaborasi',
                    ])
                    ->default('social_media')
                    ->required(),

                Select::make('platform')
                    ->label('Platform / Ikon')
                    ->options([
                        'instagram' => 'Instagram',
                        'tiktok' => 'TikTok',
                        'whatsapp' => 'WhatsApp',
                        'facebook' => 'Facebook',
                        'youtube' => 'YouTube',
                        'gmaps' => 'Google Maps',
                        'web' => 'Website / Link Eksternal',
                    ])
                    ->placeholder('-- Pilih Platform (Opsional) --'),

                TextInput::make('url')
                    ->label('Tautan / URL Web / Peta Maps')
                    ->placeholder('https://...')
                    ->maxLength(500),

                TextInput::make('phone')
                    ->label('Nomor Telepon / WhatsApp Kontak')
                    ->placeholder('0812-3456-7890'),

                Textarea::make('address')
                    ->label('Alamat Lengkap (Untuk Outlet / Dapur / Titik Reseller)')
                    ->rows(2)
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Urutan Tampilan')
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->label('Aktif Ditampilkan')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'social_media' => 'primary',
                        'outlet', 'kitchen' => 'success',
                        'reseller' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'social_media' => 'Medsos',
                        'outlet' => 'Outlet',
                        'kitchen' => 'Dapur',
                        'reseller' => 'Reseller',
                        'partner' => 'Mitra',
                        default => $state,
                    }),

                TextColumn::make('platform')
                    ->label('Platform')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('phone')
                    ->label('Kontak')
                    ->placeholder('-'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Filter Tipe')
                    ->options([
                        'social_media' => 'Media Sosial',
                        'outlet' => 'Outlet Pick-up',
                        'kitchen' => 'Dapur Produksi',
                        'reseller' => 'Reseller',
                        'partner' => 'Mitra',
                    ]),
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
            'index' => ManageNetworkings::route('/'),
        ];
    }
}
