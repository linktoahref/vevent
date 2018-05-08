<?php

namespace LTAH\Generator;

use LTAH\Generator\VEvent;

class Builder
{

    /**
     * Build up the VEvent string.
     *
     * @param  VEvent $event
     * @return string
     */
    public function build(VEvent $event)
    {
        $event_string = [
            'BEGIN:VCALENDAR',
            'PRODID:' . $event->product_identifier,
            'VERSION:2.0',
            'METHOD:REQUEST',
            'BEGIN:VEVENT'
        ];

        if (isset($event->organizer->name)) {
            $event_string[] = 'ORGANIZER;CN="' . $event->organizer->name . 
                                '":MAILTO:'. $event->organizer->email;
        }

        if (! empty($event->attendees)) {
            foreach ($event->attendees as $attendee) {
                $event_string[] = 'ATTENDEE;CN="' . $attendee['name'] . 
                                '";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.
                                $attendee['email'];
            }
        }

        $event_string[] = 'LAST-MODIFIED:' . date("Ymd\TGis");
        $event_string[] = 'UID:'. md5(uniqid(rand(), true));
        $event_string[] = 'DTSTAMP:' . date("Ymd\TGis");
        $event_string[] = 'DTSTART;TZID="' . $event->start->getTimezone()->getName() . '":' . $event->start->format("Ymd\THis");
        $event_string[] = 'DTEND;TZID="' . $event->end->getTimezone()->getName() . '":' . $event->end->format("Ymd\THis");
        $event_string[] = 'TRANSP:OPAQUE';
        $event_string[] = 'SEQUENCE:1';

        if ($event->summary) {
            $event_string[] = 'SUMMARY:' . $event->summary;
        }

        if ($event->location) {
            $event_string[] = 'LOCATION:' . $event->location;
        }

        $event_string[] = 'CLASS:PUBLIC';
        $event_string[] = 'PRIORITY:5';
        $event_string[] = 'END:VEVENT';
        $event_string[] = 'END:VCALENDAR' . "\r\n";

        return implode("\r\n", $event_string);

    }

}
