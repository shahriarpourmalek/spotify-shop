<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderPaymentStatusEnum;
use App\Enums\OrderStatusEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order details')
                    ->schema([
                        TextInput::make('order_number')
                            ->required()
                            ->maxLength(255),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->options(OrderStatusEnum::options())
                            ->required()
                            ->native(false),
                        Select::make('payment_status')
                            ->options(OrderPaymentStatusEnum::options())
                            ->required()
                            ->native(false),
                        TextInput::make('subtotal')
                            ->numeric()
                            ->required()
                            ->minValue(0),
                        TextInput::make('discount')
                            ->numeric()
                            ->required()
                            ->minValue(0),
                        TextInput::make('total')
                            ->numeric()
                            ->required()
                            ->minValue(0),
                        DateTimePicker::make('paid_at'),
                    ])
                    ->columns(2),
            ]);
    }
}
