<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrxBukuKasResource\Pages;
use App\Models\TrxBukuKas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrxBukuKasResource extends Resource
{
    protected static ?string $model = TrxBukuKas::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?string $modelLabel = 'Buku Kas';
    protected static ?string $pluralModelLabel = 'Buku Kas';
    protected static ?string $navigationLabel = 'Buku Kas';
    protected static ?string $navigationGroup = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Input Transaksi Kas')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->default(now())
                            ->required(),

                        Forms\Components\Select::make('jenis')
                            ->label('Jenis Transaksi')
                            ->options([
                                'Pemasukan' => 'Pemasukan (+)',
                                'Pengeluaran' => 'Pengeluaran (-)',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\TextInput::make('nominal')
                            ->label('Nominal (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pemasukan' => 'success',
                        'Pengeluaran' => 'danger',
                        default => 'warning',
                    }),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Uraian')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->defaultSort('tanggal', 'desc')
            // Bagian headerActions dihapus untuk menghindari error karena package belum terinstall.
            // Jika ingin menambahkan export Excel, install package: composer require pxlrbt/filament-excel
            // Lalu tambahkan headerActions berikut:
            // ->headerActions([
            //     \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
            //         ->exports([
            //             \pxlrbt\FilamentExcel\Exports\ExcelExport::make()
            //                 ->fromTable()
            //                 ->withFilename('Laporan-Kas-' . date('Y-m-d')),
            //         ])
            //         ->label('Ekspor Excel'),
            // ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'Pemasukan' => 'Pemasukan',
                        'Pengeluaran' => 'Pengeluaran',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrxBukuKas::route('/'),
            'create' => Pages\CreateTrxBukuKas::route('/create'),
            'edit' => Pages\EditTrxBukuKas::route('/{record}/edit'),
        ];
    }
}