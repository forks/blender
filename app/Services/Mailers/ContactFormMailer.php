<?php

namespace App\Services\Mailers;

use App\Events\ContactFormWasSubmitted;
use Illuminate\Contracts\Events\Dispatcher;
use Request;
use Log;

class ContactFormMailer
{
    use SendsMails;

    public function contactFormWasSubmitted(ContactFormWasSubmitted $event)
    {
        collect(config('mail.questionFormRecipients'))->each(function (string $email) use ($event) {
            $this->sendMail(
                $email,
                'Een nieuwe reactie op ' . config('app.url'),
                'emails.admin.contactFormSubmitted',
                $event->formResponse->toArray()
            );
        });
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(ContactFormWasSubmitted::class, [$this, 'contactFormWasSubmitted']);
    }
}
