<?php

namespace App\Filament\Resources\Enquiries\Pages;

use App\Filament\Resources\Enquiries\EnquiryResource;
use App\Models\Enquiry;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewEnquiry extends ViewRecord
{
    protected static string $resource = EnquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reply')
                ->icon(Heroicon::OutlinedEnvelope)
                ->url(fn (Enquiry $record): string => 'mailto:'.$record->email.'?subject='.rawurlencode('Re: Your enquiry')),
            Action::make('resend')
                ->label('Resend email')
                ->icon(Heroicon::OutlinedArrowPath)
                ->color('gray')
                ->visible(fn (Enquiry $record): bool => $record->sent_at === null)
                ->action(function (Enquiry $record): void {
                    if ($record->deliver()) {
                        Notification::make()->title('Enquiry emailed')->success()->send();

                        return;
                    }

                    Notification::make()
                        ->title('Email failed again')
                        ->body('Check CONTACT_EMAIL, the mail settings and the error log.')
                        ->danger()
                        ->send();
                }),
            DeleteAction::make(),
        ];
    }
}
