<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CmsMateriPustakaResource\Pages;
use App\Models\CmsMateriPustaka;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Barryvdh\DomPDF\Facade\Pdf;

class CmsMateriPustakaResource extends Resource
{
    protected static ?string $model = CmsMateriPustaka::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $modelLabel = 'Materi Pustaka';
    protected static ?string $pluralModelLabel = 'Materi Pustaka';
    protected static ?string $navigationLabel = 'Materi Pustaka';
    protected static ?string $navigationGroup = 'Konten Web';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Utama')
                    ->schema([
                        Forms\Components\Hidden::make('id_user')
                            ->default(fn () => auth()->id()),
                            
                        Forms\Components\TextInput::make('judul_materi')
                            ->label('Judul Materi')
                            ->required()
                            ->maxLength(200)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                $operation === 'create' ? $set('slug_url', Str::slug($state)) : null
                            ),
                        Forms\Components\TextInput::make('slug_url')
                            ->label('Slug URL (Otomatis)')
                            ->required()
                            ->maxLength(255)
                            ->readOnly(),
                        Forms\Components\Select::make('kategori')
                            ->label('Kategori Konten')
                            ->options([
                                'Modul' => 'Modul Belajar',
                                'Artikel' => 'Artikel Umum',
                                'Pengumuman' => 'Pengumuman Penting',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publikasikan Ke Web?')
                            ->default(true)
                            ->onColor('success'),
                    ])->columns(2),

                Forms\Components\Section::make('Konten & Media')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar_cover')
                            ->label('Gambar Cover / Thumbnail')
                            ->image()
                            ->directory('materi-covers')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('link_google_drive')
                            ->label('Link Download (GDrive/PDF External)')
                            ->url()
                            ->placeholder('https://drive.google.com/...')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('isi_konten')
                            ->label('Isi Konten Materi')
                            ->required()
                            ->fileAttachmentsDirectory('materi-attachments')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar_cover')
                    ->label('Cover')
                    ->square(),
                Tables\Columns\TextColumn::make('judul_materi')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pengumuman' => 'danger',
                        'Artikel' => 'info',
                        'Modul' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('CreatedDate')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->label('Ekspor Excel')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'Modul' => 'Modul',
                        'Artikel' => 'Artikel',
                        'Pengumuman' => 'Pengumuman',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publikasi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Fitur Tambahan: Cetak Materi untuk dibagikan ke santri secara fisik
                Tables\Actions\Action::make('cetak_materi')
                    ->label('Cetak Materi')
                    ->color('warning')
                    ->icon('heroicon-o-printer')
                    ->action(function (CmsMateriPustaka $record) {
                        $pdf = Pdf::loadView('pdf.cetak-materi', ['record' => $record]);
                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->output();
                        }, 'Materi-' . $record->slug_url . '.pdf');
                    }),
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
            'index' => Pages\ListCmsMateriPustakas::route('/'),
            'create' => Pages\CreateCmsMateriPustaka::route('/create'),
            'edit' => Pages\EditCmsMateriPustaka::route('/{record}/edit'),
        ];
    }
}