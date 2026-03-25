<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CmsJadwalPengajianResource\Pages;
use App\Models\CmsJadwalPengajian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Barryvdh\DomPDF\Facade\Pdf;

class CmsJadwalPengajianResource extends Resource
{
    protected static ?string $model = CmsJadwalPengajian::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $modelLabel = 'Jadwal Pengajian';
    protected static ?string $pluralModelLabel = 'Jadwal Pengajian';
    protected static ?string $navigationGroup = 'Konten Web';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Jadwal')->schema([
                    Forms\Components\Select::make('kategori')
                        ->label('Kategori Jadwal')
                        ->options([
                            'Harian' => 'Jadwal Harian',
                            'Tingkatan Ibtida' => 'Tingkatan Ibtida',
                            'Tingkatan Tsanawi' => 'Tingkatan Tsanawi',
                            'Umum' => 'Pengajian Umum',
                        ])
                        ->required(),
                    Forms\Components\TextInput::make('hari_atau_waktu')
                        ->label('Hari / Waktu')
                        ->placeholder("Contoh: Senin Ba'da Maghrib / 04.00 - 05.30")
                        ->required()
                        ->maxLength(100),
                    Forms\Components\TextInput::make('materi_atau_kitab')
                        ->label('Materi / Nama Kitab')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('pengajar_id')
                        ->label('Pengajar (Opsional)')
                        ->relationship('pengajar', 'nama_lengkap')
                        ->searchable()
                        ->preload(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Harian' => 'gray',
                        'Tingkatan Ibtida' => 'success',
                        'Tingkatan Tsanawi' => 'warning',
                        'Umum' => 'info',
                        default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('hari_atau_waktu')
                    ->label('Waktu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('materi_atau_kitab')
                    ->label('Materi / Kitab')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('pengajar.nama_lengkap')
                    ->label('Pengajar')
                    ->searchable()
                    ->default('-'),
            ])
            ->defaultSort('kategori', 'asc')
            ->headerActions([
                // 1. EKSPOR EXCEL
                ExportAction::make('export')
                    ->label('Ekspor Excel')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exports([
                        ExcelExport::make()
                            ->withFilename('Jadwal-Pengajian-' . date('Y-m-d'))
                            ->withColumns([
                                Column::make('kategori')->heading('Kategori'),
                                Column::make('hari_atau_waktu')->heading('Hari/Waktu'),
                                Column::make('materi_atau_kitab')->heading('Materi/Kitab'),
                                Column::make('pengajar.nama_lengkap')->heading('Pengajar'),
                            ]),
                    ]),

                // 2. CETAK PDF CUSTOM
                Tables\Actions\Action::make('cetak_pdf')
                    ->label('Cetak PDF')
                    ->color('danger')
                    ->icon('heroicon-o-printer')
                    ->action(function (Table $table) {
                        $data = $table->getRecords(); 
                        $pdf = Pdf::loadView('pdf.laporan-jadwal', ['data' => $data]);
                        $pdf->setPaper('a4', 'portrait');
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'Jadwal-Pengajian-' . date('Y-m-d') . '.pdf');
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Filter Kategori')
                    ->options([
                        'Harian' => 'Harian',
                        'Tingkatan Ibtida' => 'Ibtida',
                        'Tingkatan Tsanawi' => 'Tsanawi',
                        'Umum' => 'Umum',
                    ]),
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
            'index' => Pages\ListCmsJadwalPengajians::route('/'),
            'create' => Pages\CreateCmsJadwalPengajian::route('/create'),
            'edit' => Pages\EditCmsJadwalPengajian::route('/{record}/edit'),
        ];
    }
}