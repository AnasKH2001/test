<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



public static function form(Form $form): Form
{
    return $form
        ->schema([
            // حقل نصي للاسم
            Forms\Components\TextInput::make('name')
                ->label(' Customer name') // تسمية واضحة للحقل
                ->required() // جعله حقلاً مطلوباً
                ->maxLength(255),

            // حقل نصي للبريد الإلكتروني
            Forms\Components\TextInput::make('email')
                ->label('email')
                ->email() // التأكد من أن المدخل هو بريد إلكتروني صالح
                ->required()
                ->maxLength(255),

            // يمكنك إضافة أي حقول أخرى هنا بنفس الطريقة
            // مثال: حقل رقم الهاتف
            // Forms\Components\TextInput::make('phone')
            //     ->label('رقم الهاتف')
            //     ->tel(), // يحدد أنه حقل هاتف
        ]);
}

    // In app/Filament/Resources/CustomerResource.php

// In app/Filament/Resources/CustomerResource.php

public static function table(Table $table): Table
{
    return $table
        ->recordUrl(null)

        ->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label('Name')
                ->searchable(),
            Tables\Columns\TextColumn::make('user.email')
                ->label(' Email')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created at ')
                ->dateTime('d-M-Y')
                ->sortable(),
        ])
        ->actions([
            // Tables\Actions\EditAction::make(), // <<< هذا السطر يتم حذفه

            Tables\Actions\DeleteAction::make()->label('Delet'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}

    // In app/Filament/Resources/CustomerResource.php

public static function getPages(): array
{
    return [
        'index' => Pages\ListCustomers::route('/'),
        'create' => Pages\CreateCustomer::route('/create'),
        // 'edit' => Pages\EditCustomer::route('/{record}/edit'), // <<< هذا السطر يتم حذفه
    ];
}
}
