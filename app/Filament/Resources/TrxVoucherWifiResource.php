<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrxVoucherWifiResource\Pages;
use App\Models\TrxVoucherWifi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TrxVoucherWifiResource extends Resource
{
    protected static ?string $model = TrxVoucherWifi::class;
    protected static ?string $navigationIcon = 'heroicon-o-wifi';
    protected static ?string $modelLabel = 'Voucher Wi-Fi';
    protected static ?string $pluralModelLabel = 'Data Voucher Wi-Fi';
    protected static ?string $navigationLabel = 'Voucher Wi-Fi';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_voucher')
                    ->label('Kode Voucher')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default(strtoupper(Str::random(8))),
                Forms\Components\Select::make('paket')
                    ->label('Pilihan Paket')
                    ->options([
                        'Harian' => 'Harian',
                        'Mingguan' => 'Mingguan',
                        'Bulanan' => 'Bulanan',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('harga')
                    ->label('Harga (Rp)')
                    ->numeric()
                    ->required(),
                Forms\Components\Toggle::make('is_used')
                    ->label('Sudah Terpakai?')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_voucher')
                    ->label('Kode Voucher')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('paket')
                    ->label('Paket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_used')
                    ->label('Terpakai')
                    ->boolean(),
                Tables\Columns\TextColumn::make('CreatedDate')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrxVoucherWifis::route('/'),
            'create' => Pages\CreateTrxVoucherWifi::route('/create'),
            'edit' => Pages\EditTrxVoucherWifi::route('/{record}/edit'),
        ];
    }
}