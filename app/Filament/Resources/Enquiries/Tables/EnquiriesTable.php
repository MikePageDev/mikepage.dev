<?php

namespace App\Filament\Resources\Enquiries\Tables;

use App\Models\Enquiry;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EnquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('message')->limit(60),
                TextColumn::make('created_at')->label('Received')->since()->sortable(),
                IconColumn::make('emailed')
                    ->state(fn (Enquiry $record): bool => $record->sent_at !== null)
                    ->boolean(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('not_emailed')
                    ->label('Not emailed')
                    ->query(fn (Builder $query): Builder => $query->whereNull('sent_at'))
                    ->toggle(),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
