<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Number;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order details')
                    ->schema([
                        TextEntry::make('order_number'),
                        TextEntry::make('user.name')
                            ->label('Customer'),
                        TextEntry::make('status')
                            ->badge()
                            ->formatStateUsing(fn ($state): string => $state?->label() ?? 'Unknown'),
                        TextEntry::make('payment_status')
                            ->badge()
                            ->formatStateUsing(fn ($state): string => $state?->label() ?? 'Unknown'),
                        TextEntry::make('subtotal')
                            ->formatStateUsing(fn (int $state): string => Number::currency($state / 100)),
                        TextEntry::make('discount')
                            ->formatStateUsing(fn (int $state): string => Number::currency($state / 100)),
                        TextEntry::make('total')
                            ->formatStateUsing(fn (int $state): string => Number::currency($state / 100)),
                        TextEntry::make('paid_at')
                            ->dateTime()
                            ->placeholder('Not paid'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
