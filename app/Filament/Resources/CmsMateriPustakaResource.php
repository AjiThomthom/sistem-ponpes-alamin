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
                Forms\Components\TextInput::make('link_google_drive')
                    ->label('Link Google Drive / Dokumen Tambahan')
                    ->url()
                    ->maxLength(500),
                Forms\Components\FileUpload::make('gambar_cover')
                    ->label('Gambar Cover / Thumbnail')
                    ->image()
                    ->directory('materi-covers'),
                Forms\Components\RichEditor::make('isi_konten')
                    ->label('Isi Konten')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar_cover')
                    ->label('Cover')
                    ->circular(),
                Tables\Columns\TextColumn::make('judul_materi')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pengumuman' => 'danger',
                        'Artikel' => 'info',
                        'Modul' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('CreatedDate')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
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
            'index' => Pages\ListCmsMateriPustakas::route('/'),
            'create' => Pages\CreateCmsMateriPustaka::route('/create'),
            'edit' => Pages\EditCmsMateriPustaka::route('/{record}/edit'),
        ];
    }
}