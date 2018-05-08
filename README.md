# A Simple VEvent Generator

---

### Installation

    composer require linktoahref/vevent

### Usage

```php
use LTAH\Generator\VEvent;

$event = VEvent::create('test', new DateTime('2018-05-10'), new DateTime('2018-05-11'));

$event->addOrganizer('test', 'test@mail.com');

$event->addAttendees('foo', 'foo@bar.com');

echo $event->render();
```

### Send the Event in Mail

If using Laravel you could modify the Mailable class's `withSwiftMessage` method
within the `build` method

```php
$this->markdown('emails.mailable')
        ->with([ params ]);

$this->withSwiftMessage(function ($message) use ($ical, $subject) {
    $message->setBody($event->render(), 'text/calendar; charset="utf-8"; method=REQUEST');
    $message->addPart($this->buildView()['html']->toHtml(), 'text/html');
});

return 
    $this->subject($subject)
        ->attachData($event->render(), 'meeting.ics', [
            'mime' => 'text/calendar; charset="utf-8"; method=REQUEST',
        ]);
```

*This would render the event with styling in gmail and outlook*
