<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrxTagihanSppResource\Pages;
use App\Models\TrxTagihanSpp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrxTagihanSppResource extends Resource
{
    protected static ?string $model = TrxTagihanSpp::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $modelLabel = 'Tagihan SPP';
    protected static ?string $pluralModelLabel = 'Data Tagihan SPP';
    protected static ?string $navigationLabel = 'Tagihan SPP';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('nis')
                    ->label('Pilih Santri')
                    ->relationship('santri', 'nama_santri') 
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('bulan')
                    ->label('Bulan')
                    ->options([
                        'Januari' => 'Januari', 'Februari' => 'Februari', 'Maret' => 'Maret',
                        'April' => 'April', 'Mei' => 'Mei', 'Juni' => 'Juni',
                        'Juli' => 'Juli', 'Agustus' => 'Agustus', 'September' => 'September',
                        'Oktober' => 'Oktober', 'November' => 'November', 'Desember' => 'Desember',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('tahun')
                    ->label('Tahun')
                    ->numeric()
                    ->default(date('Y'))
                    ->required(),
                Forms\Components\TextInput::make('nominal')
                    ->label('Nominal (Rp)')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('status_bayar')
                    ->label('Status Pembayaran')
                    ->options([
                        'BELUM LUNAS' => 'Belum Lunas',
                        'PENDING' => 'Pending / Verifikasi',
                        'LUNAS' => 'Lunas',
                    ])
                    ->default('BELUM LUNAS')
                    ->required(),
                Forms\Components\DateTimePicker::make('tanggal_lunas')
                    ->label('Tanggal Lunas'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('santri.nama_santri')
                    ->label('Nama Santri')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bulan')
                    ->label('Bulan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PENDING' => 'warning',
                        'LUNAS' => 'success',
                        'BELUM LUNAS' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('tanggal_lunas')
                    ->label('Tgl Lunas')
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
            'index' => Pages\ListTrxTagihanSpps::route('/'),
            'create' => Pages\CreateTrxTagihanSpp::route('/create'),
            'edit' => Pages\EditTrxTagihanSpp::route('/{record}/edit'),
        ];
    }
}