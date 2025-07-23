<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EncryptedDataResource\Pages;
use App\Models\EncryptedData;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions;

class EncryptedDataResource extends Resource
{
    protected static ?string $model = EncryptedData::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static ?string $navigationGroup = 'System Management';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('model_type')
                    ->required()
                    ->maxLength(255),
                TextInput::make('model_id')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TextInput::make('field_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('encrypted_value')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('model_type')
                    ->searchable(),
                TextColumn::make('model_id')
                    ->searchable(),
                TextColumn::make('field_name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEncryptedData::route('/'),
            'create' => Pages\CreateEncryptedData::route('/create'),
            'edit' => Pages\EditEncryptedData::route('/{record}/edit'),
        ];
    }
}