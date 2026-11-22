<?php

namespace App\Filament\Resources\WebSettings;

use App\Filament\Resources\WebSettings\Pages\ManageWebSettings;
use App\Models\WebSetting;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WebSettingResource extends Resource
{
    protected static ?string $model = WebSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static \UnitEnum|string|null $navigationGroup = 'Pengaturan';

    protected static ?string $modelLabel = 'Pengaturan Website';

    protected static ?string $pluralModelLabel = 'Pengaturan Website';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Kunci Pengaturan (Key)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100),

                TextInput::make('label')
                    ->label('Label / Nama Pengaturan')
                    ->required()
                    ->maxLength(255),

                Select::make('group')
                    ->label('Grup Pengaturan')
                    ->options([
                        'general' => 'Umum (General)',
                        'contact' => 'Kontak & Alamat Dapur',
                        'announcement' => 'Pengumuman (Announcement Bar)',
                        'social' => 'Sosial Media & Integrasi',
                    ])
                    ->default('general')
                    ->required(),

                Select::make('type')
                    ->label('Tipe Input')
                    ->options([
                        'text' => 'Teks Singkat',
                        'textarea' => 'Teks Panjang / Multiline',
                        'boolean' => 'Boolean (0 atau 1)',
                    ])
                    ->default('text')
                    ->required(),

                Textarea::make('value')
                    ->label('Nilai Pengaturan (Value)')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Nama Pengaturan')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('key')
                    ->label('Key')
                    ->fontFamily('mono')
                    ->color('gray')
                    ->searchable(),

                TextColumn::make('value')
                    ->label('Nilai Pengaturan')
                    ->limit(50),

                TextColumn::make('group')
                    ->label('Grup')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'general' => 'primary',
                        'contact' => 'success',
                        'announcement' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label('Grup')
                    ->options([
                        'general' => 'Umum',
                        'contact' => 'Kontak & Dapur',
                        'announcement' => 'Pengumuman',
                        'social' => 'Sosial Media',
                    ]),
            ])
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
            'index' => ManageWebSettings::route('/'),
        ];
    }
}
