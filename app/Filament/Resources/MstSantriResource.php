<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstSantriResource\Pages;
use App\Models\MstSantri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Barryvdh\DomPDF\Facade\Pdf;

class MstSantriResource extends Resource
{
    protected static ?string $model = MstSantri::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Santri';
    protected static ?string $pluralModelLabel = 'Data Santri';
    protected static ?string $navigationLabel = 'Data Santri';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $recordTitleAttribute = 'nama_santri';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Profil Santri')->schema([
                    Forms\Components\FileUpload::make('foto_profile')
                        ->label('Foto Profil Santri')
                        ->image()
                        ->directory('santri')
                        ->columnSpanFull(),
                        
                    Forms\Components\TextInput::make('nis')
                        ->label('Nomor Induk Santri (NIS)')
                        ->required()
                        ->maxLength(50),
                        
                    Forms\Components\TextInput::make('nama_santri')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),
                        
                    Forms\Components\TextInput::make('tempat_lahir')
                        ->label('Tempat Lahir')
                        ->maxLength(100),
                        
                    Forms\Components\DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir'),
                        
                    Forms\Components\TextInput::make('kelas')
                        ->label('Kelas / Asrama')
                        ->maxLength(50),
                        
                    Forms\Components\TextInput::make('no_hp_santri')
                        ->label('No. HP Santri')
                        ->tel()
                        ->maxLength(20),
                        
                    Forms\Components\TextInput::make('no_hp_wali')
                        ->label('No. HP Wali/Ortu')
                        ->tel()
                        ->maxLength(20),
                        
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),
                        
                    Forms\Components\Select::make('status_santri')
                        ->label('Status Santri')
                        ->options([
                            'aktif' => 'Aktif',
                            'lulus' => 'Lulus',
                            'takzir' => 'Takzir',
                            'keluar' => 'Keluar',
                        ])
                        ->default('aktif')
                        ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_profile')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl('https://ui-avatars.com/api/?name=Santri&background=0b1120&color=fff'),
                    
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('nama_santri')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tgl Lahir')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kelas')
                    ->label('Kelas')
                    ->searchable(),

                Tables\Columns\TextColumn::make('no_hp_santri')
                    ->label('HP Santri')
                    ->searchable(),

                Tables\Columns\TextColumn::make('no_hp_wali')
                    ->label('WA Wali')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status_santri')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'lulus' => 'info',
                        'takzir' => 'warning',
                        'keluar' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->headerActions([
                // EXPORT EXCEL
                ExportAction::make('export')
                    ->label('Ekspor Excel')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exports([
                        ExcelExport::make()
                            ->withFilename('Data-Santri-' . date('Y-m-d'))
                            ->withColumns([
                                Column::make('nis')->heading('NIS'),
                                Column::make('nama_santri')->heading('Nama Santri'),
                                Column::make('tempat_lahir')->heading('Tempat Lahir'),
                                Column::make('tanggal_lahir')->heading('Tanggal Lahir'),
                                Column::make('kelas')->heading('Kelas'),
                                Column::make('no_hp_santri')->heading('WA Santri'),
                                Column::make('no_hp_wali')->heading('WA Wali'),
                                Column::make('email')->heading('Email'),
                                Column::make('status_santri')->heading('Status'),
                            ]),
                    ]),

                // CETAK PDF CUSTOM (MENGGUNAKAN FORMAT LANDSCAPE)
                Tables\Actions\Action::make('cetak_pdf')
                    ->label('Cetak PDF')
                    ->color('danger')
                    ->icon('heroicon-o-printer')
                    ->action(function (Table $table) {
                        $data = $table->getRecords(); 
                        $pdf = Pdf::loadView('pdf.laporan-santri', ['data' => $data]);
                        
                        // Setel kertas A4 secara mendatar (Landscape) agar kolom muat semua
                        $pdf->setPaper('a4', 'landscape');
                        
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'Data-Santri-' . date('Y-m-d') . '.pdf');
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_santri')
                    ->label('Filter Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'lulus' => 'Lulus',
                        'takzir' => 'Takzir',
                        'keluar' => 'Keluar',
                    ]),
                Tables\Filters\SelectFilter::make('kelas')
                    ->label('Filter Kelas')
                    ->options(fn() => MstSantri::distinct()->pluck('kelas', 'kelas')->toArray()),
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

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMstSantris::route('/'),
            'create' => Pages\CreateMstSantri::route('/create'),
            'edit' => Pages\EditMstSantri::route('/{record}/edit'),
        ];
    }
}