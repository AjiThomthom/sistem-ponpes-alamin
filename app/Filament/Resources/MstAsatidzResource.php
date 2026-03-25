<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstAsatidzResource\Pages;
use App\Models\MstAsatidz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Barryvdh\DomPDF\Facade\Pdf;

class MstAsatidzResource extends Resource
{
    protected static ?string $model = MstAsatidz::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $modelLabel = 'Dewan Asatidz';
    protected static ?string $pluralModelLabel = 'Dewan Asatidz';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profil Asatidz')->schema([
                    Forms\Components\TextInput::make('nama_lengkap')
                        ->label('Nama Lengkap (Beserta Gelar)')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('jabatan')
                        ->label('Jabatan / Peran')
                        ->placeholder('Contoh: Pimpinan Umum / Mudarris')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\FileUpload::make('foto_profile')
                        ->label('Foto Profil')
                        ->image()
                        ->directory('asatidz') 
                        ->columnSpanFull(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_profile')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://ui-avatars.com/api/?name=Ustaz&background=065f46&color=fff'),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('CreatedDate')
                    ->label('Ditambahkan Pada')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->headerActions([
                // 1. EKSPOR EXCEL
                ExportAction::make('export')
                    ->label('Ekspor Excel')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exports([
                        ExcelExport::make()
                            ->withFilename('Data-Asatidz-' . date('Y-m-d'))
                            ->withColumns([
                                Column::make('nama_lengkap')->heading('Nama Lengkap'),
                                Column::make('jabatan')->heading('Jabatan'),
                                Column::make('CreatedDate')->heading('Tanggal Input'),
                            ]),
                    ]),

                // 2. CETAK PDF CUSTOM
                Tables\Actions\Action::make('cetak_pdf')
                    ->label('Cetak PDF')
                    ->color('danger')
                    ->icon('heroicon-o-printer')
                    ->action(function (Table $table) {
                        $data = $table->getRecords(); 
                        $pdf = Pdf::loadView('pdf.laporan-asatidz', ['data' => $data]);
                        $pdf->setPaper('a4', 'portrait'); // Bisa pakai landscape jika kolom bertambah banyak
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'Data-Asatidz-' . date('Y-m-d') . '.pdf');
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jabatan')
                    ->label('Filter Jabatan')
                    ->options(fn() => MstAsatidz::distinct()->pluck('jabatan', 'jabatan')->toArray()),
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
            'index' => Pages\ListMstAsatidzs::route('/'),
            'create' => Pages\CreateMstAsatidz::route('/create'),
            'edit' => Pages\EditMstAsatidz::route('/{record}/edit'),
        ];
    }
}