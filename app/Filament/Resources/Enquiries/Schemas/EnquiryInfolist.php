<?php

namespace App\Filament\Resources\Enquiries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EnquiryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('From')->columns(2)->schema([
                    TextEntry::make('name'),
                    TextEntry::make('email')->copyable(),
                    TextEntry::make('created_at')->label('Received')->dateTime(),
                    TextEntry::make('sent_at')->label('Emailed')->dateTime()->placeholder('Not emailed'),
                    TextEntry::make('ip_address')->label('IP address')->placeholder('Removed after 30 days'),
                ]),
                Section::make('Message')->schema([
                    TextEntry::make('message')
                        ->hiddenLabel()
                        // Escaped first, then line breaks kept so the message reads as written.
                        ->formatStateUsing(fn (string $state): string => nl2br(e($state)))
                        ->html(),
                ]),
            ]);
    }
}
