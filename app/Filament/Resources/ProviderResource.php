<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Filament\Resources\ProviderResource\RelationManagers;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }



public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('user.name')->label('Name')->searchable(),
            Tables\Columns\TextColumn::make('user.email')->label('Email ')->searchable(),

            // سنعرض الحالة بشكل جذاب باستخدام Badge
            Tables\Columns\TextColumn::make('status')
                ->label('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                }),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),

            // هذا هو زر "القبول" المخصص
            Action::make('approve')
                ->label('accept')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->action(function (Provider $record) {
                    $record->status = 'approved';
                    $record->save();
                })
                ->visible(fn (Provider $record): bool => $record->status === 'pending'),

        Action::make('reject')
                    ->label('reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function (Provider $record) {
                        $record->status = 'rejected';
                        $record->save();
                    })
                    ->visible(fn (Provider $record): bool => $record->status === 'pending'),
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
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }
}
