<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Number;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->minValue(0),
                TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                TextInput::make('total')
                    ->numeric()
                    ->required()
                    ->minValue(0),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('product.title')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->formatStateUsing(fn (int $state): string => Number::currency($state / 100))
                    ->sortable(),
                TextColumn::make('quantity')
                    ->sortable(),
                TextColumn::make('total')
                    ->formatStateUsing(fn (int $state): string => Number::currency($state / 100))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
