<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryResource\Pages;
use App\Models\Salary;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;

class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Employee Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('employee_id')
                    ->relationship('employee', 'name')
                    ->required()
                    ->searchable(),
                TextInput::make('basic_salary')
                    ->required()
                    ->numeric()
                    ->mask('999999999.99')
                    ->prefix('Rp')
                    ->minValue(0)
                    ->rules(['required', 'numeric', 'min:0'])
                    ->helperText('Minimal Rp 0'),
                TextInput::make('allowance')
                    ->required()
                    ->numeric()
                    ->mask('999999999.99')
                    ->prefix('Rp')
                    ->minValue(0)
                    ->rules(['required', 'numeric', 'min:0'])
                    ->helperText('Minimal Rp 0'),
                TextInput::make('tax_deduction')
                    ->required()
                    ->numeric()
                    ->mask('999999999.99')
                    ->prefix('Rp')
                    ->minValue(0)
                    ->rules(['required', 'numeric', 'min:0'])
                    ->helperText('Minimal Rp 0'),
                DatePicker::make('month')
                    ->required()
                    ->format('Y-m')
                    ->displayFormat('F Y')
                    ->maxDate(now())
                    ->rules(['required', 'date', 'before_or_equal:today'])
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('basic_salary')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('allowance')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('tax_deduction')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('month')
                    ->date('F Y')
                    ->sortable(),
                TextColumn::make('total_salary')
                    ->money('IDR')
                    ->state(function ($record) {
                        return $record->total_salary;
                    })
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make()
                    ->before(function (Salary $record) {
                        // Validasi sebelum edit
                        if ($record->basic_salary < 0 || $record->allowance < 0 || $record->tax_deduction < 0) {
                            throw new \Exception('Nilai tidak boleh negatif');
                        }
                    }),
                Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->after(function (Salary $record) {
                        // Log aktivitas penghapusan
                        activity()
                            ->performedOn($record)
                            ->log('Deleted salary record');
                    }),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->after(function (Collection $records) {
                            foreach ($records as $record) {
                                activity()
                                    ->performedOn($record)
                                    ->log('Deleted salary record in bulk');
                            }
                        }),
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
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
        ];
    }
}