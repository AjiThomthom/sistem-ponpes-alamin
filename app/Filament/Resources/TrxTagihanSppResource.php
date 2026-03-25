<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrxTagihanSppResource\Pages;
use App\Models\TrxTagihanSpp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Barryvdh\DomPDF\Facade\Pdf;

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
                Forms\Components\Section::make('Detail Transaksi SPP')->schema([
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
                        ->prefix('Rp')
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
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('santri.nama_santri')
                    ->label('Nama Santri')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bulan')
                    ->label('Bulan'),
                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_bayar')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PENDING' => 'warning',
                        'LUNAS' => 'success',
                        'BELUM LUNAS' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('tanggal_lunas')
                    ->label('Tanggal Lunas')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Belum Lunas'),
            ])
            ->headerActions([
                // 1. EKSPOR EXCEL
                ExportAction::make('export')
                    ->label('Ekspor Excel')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exports([
                        ExcelExport::make()
                            ->withFilename('Laporan-SPP-' . date('Y-m-d'))
                            ->withColumns([
                                Column::make('santri.nama_santri')->heading('Nama Santri'),
                                Column::make('bulan')->heading('Bulan'),
                                Column::make('tahun')->heading('Tahun'),
                                Column::make('nominal')->heading('Nominal'),
                                Column::make('status_bayar')->heading('Status'),
                                Column::make('tanggal_lunas')->heading('Tgl Lunas'),
                            ]),
                    ]),

                // 2. CETAK PDF CUSTOM
                Tables\Actions\Action::make('cetak_pdf')
                    ->label('Cetak PDF')
                    ->color('danger')
                    ->icon('heroicon-o-printer')
                    ->action(function (Table $table) {
                        $data = $table->getRecords(); 
                        $pdf = Pdf::loadView('pdf.laporan-spp', ['data' => $data]);
                        $pdf->setPaper('a4', 'portrait');
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'Laporan-SPP-' . date('Y-m-d') . '.pdf');
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_bayar')
                    ->label('Filter Status')
                    ->options([
                        'LUNAS' => 'Lunas',
                        'BELUM LUNAS' => 'Belum Lunas',
                        'PENDING' => 'Pending',
                    ]),
                Tables\Filters\SelectFilter::make('bulan')
                    ->label('Filter Bulan')
                    ->options([
                        'Januari' => 'Januari', 'Februari' => 'Februari', 'Maret' => 'Maret',
                        'April' => 'April', 'Mei' => 'Mei', 'Juni' => 'Juni',
                        'Juli' => 'Juli', 'Agustus' => 'Agustus', 'September' => 'September',
                        'Oktober' => 'Oktober', 'November' => 'November', 'Desember' => 'Desember',
                    ]),
                Tables\Filters\Filter::make('tahun')
                    ->form([
                        Forms\Components\TextInput::make('tahun')->numeric()->placeholder('2026'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when($data['tahun'], fn ($q) => $q->where('tahun', $data['tahun']));
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrxTagihanSpps::route('/'),
            'create' => Pages\CreateTrxTagihanSpp::route('/create'),
            'edit' => Pages\EditTrxTagihanSpp::route('/{record}/edit'),
        ];
    }
}