<!DOCTYPE html>
<html lang="en">

<body style="font-family: sans-serif; line-height: 1.5; color: #171717;">
    <h1 style="font-size: 18px;">New website enquiry</h1>
    <p><strong>Name:</strong> {{ $enquiry->name }}</p>
    <p><strong>Email:</strong> {{ $enquiry->email }}</p>
    <p><strong>Message:</strong></p>
    <p>{!! nl2br(e($enquiry->message)) !!}</p>
    <p style="color: #737373; font-size: 12px;">Sent from the contact form on {{ config('app.url') }}. Reply to this email to answer {{ $enquiry->name }} directly.</p>
</body>

</html>
