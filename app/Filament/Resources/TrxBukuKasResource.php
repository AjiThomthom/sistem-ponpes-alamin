<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrxBukuKasResource\Pages;
use App\Models\TrxBukuKas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;

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
            ->headerActions([
                // 1. EKSPOR EXCEL (Direct Download)
                ExportAction::make('export_excel')
                    ->label('Ekspor Excel')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exports([
                        ExcelExport::make()
                            ->withFilename('Laporan-Kas-Excel-' . date('Y-m-d'))
                            ->withColumns([
                                Column::make('tanggal')->heading('Tanggal'),
                                Column::make('keterangan')->heading('Keterangan'),
                                Column::make('jenis')->heading('Jenis'),
                                Column::make('nominal')
                                    ->heading('Nominal (Rp)')
                                    ->formatStateUsing(function ($state, $record) {
                                        $prefix = ($record->jenis === 'Pemasukan') ? '(+) ' : '(-) ';
                                        return $prefix . number_format($state, 0, ',', '.');
                                    }),
                            ]),
                    ]),

                // 2. CETAK PDF RESMI (Custom View)
                Tables\Actions\Action::make('cetak_pdf')
                    ->label('Cetak PDF Resmi')
                    ->color('danger')
                    ->icon('heroicon-o-printer')
                    ->action(function (Table $table) {
                        // Mengambil data yang tampil di tabel (termasuk hasil filter)
                        $data = $table->getRecords(); 
                        
                        // Load View dari resources/views/pdf/laporan-kas.blade.php
                        $pdf = Pdf::loadView('pdf.laporan-kas', ['data' => $data]);
                        $pdf->setPaper('a4', 'portrait');
                        
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'Laporan-Kas-AlAmin-' . date('Y-m-d') . '.pdf');
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->label('Filter Jenis')
                    ->options([
                        'Pemasukan' => 'Pemasukan saja',
                        'Pengeluaran' => 'Pengeluaran saja',
                    ]),
                
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q) => $q->whereDate('tanggal', '>=', $data['dari_tanggal']))
                            ->when($data['sampai_tanggal'], fn ($q) => $q->whereDate('tanggal', '<=', $data['sampai_tanggal']));
                    })
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

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrxBukuKas::route('/'),
            'create' => Pages\CreateTrxBukuKas::route('/create'),
            'edit' => Pages\EditTrxBukuKas::route('/{record}/edit'),
        ];
    }
}