<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstSantriResource\Pages;
use App\Models\MstSantri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis')->searchable(),
                Tables\Columns\TextColumn::make('nama_santri')->searchable(),
                Tables\Columns\TextColumn::make('kelas')->searchable(),
                Tables\Columns\TextColumn::make('no_hp_wali')->label('WA Ortu'),
                Tables\Columns\TextColumn::make('status_santri')
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
                Tables\Actions\ImportAction::make()
                    ->importer(\App\Filament\Imports\MstSantriImporter::class),
                Tables\Actions\ExportAction::make()
                    ->exporter(\App\Filament\Exports\MstSantriExporter::class),
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
            'index' => Pages\ListMstSantris::route('/'),
            'create' => Pages\CreateMstSantri::route('/create'),
            'edit' => Pages\EditMstSantri::route('/{record}/edit'),
        ];
    }
}