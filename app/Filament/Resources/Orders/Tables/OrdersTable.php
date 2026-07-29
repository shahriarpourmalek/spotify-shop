<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderPaymentStatusEnum;
use App\Enums\OrderStatusEnum;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->label() ?? 'Unknown')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state?->label() ?? 'Unknown')
                    ->sortable(),
                TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Items')
                    ->sortable(),
                TextColumn::make('total')
                    ->formatStateUsing(fn (int $state): string => Number::currency($state / 100))
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->dateTime()
                    ->placeholder('Not paid')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(OrderStatusEnum::options()),
                SelectFilter::make('payment_status')
                    ->options(OrderPaymentStatusEnum::options()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
