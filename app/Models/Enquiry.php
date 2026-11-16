<?php

namespace App\Models;

use App\Mail\EnquiryReceived;
use Database\Factories\EnquiryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

#[Fillable(['name', 'email', 'message', 'ip_address', 'sent_at'])]
class Enquiry extends Model
{
    /** @use HasFactory<EnquiryFactory> */
    use HasFactory;

    /**
     * Email the enquiry to the site owner and record when it went. Never throws:
     * a failure is reported and leaves sent_at null so it can be resent from the admin panel.
     */
    public function deliver(): bool
    {
        $to = config('site.contact_email');

        if (! is_string($to) || $to === '') {
            Log::warning('CONTACT_EMAIL is not set; enquiry saved but not emailed.', ['enquiry_id' => $this->id]);

            return false;
        }

        try {
            Mail::send(new EnquiryReceived($this));
            $this->update(['sent_at' => now()]);
        } catch (Throwable $exception) {
            report($exception);

            return false;
        }

        return true;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }
}
