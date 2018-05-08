<?php

namespace LTAH\Generator;

use DateTime;
use LTAH\Generator\Builder;
use LTAH\Generator\Exception\InvalidOrganizer;
use LTAH\Generator\Exception\InvalidDatesException;

class VEvent
{

    /**
     * Event Organizer.
     *
     * @var StdClass
     */
    protected $organizer;

    /**
     * Event Attendees.
     *
     * @var array
     */
    protected $attendees = [];

    /**
     * Event Start Time.
     *
     * @var DateTime
     */
    protected $start;

    /**
     * Event End Time.
     *
     * @var DateTime
     */
    protected $end;

    /**
     * Event Summary.
     *
     * @var string
     */
    protected $summary;

    /**
     * Product Identifier.
     *
     * @var string
     */
    protected $product_identifier = '-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN';

    /**
     * Event Location.
     *
     * @var string
     */
    protected $location;

    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Constructor.
     *
     * @param string   $summary
     * @param DateTime $start
     * @param DateTime $end
     */
    public function __construct(string $summary, DateTime $start, DateTime $end)
    {
        $this->summary = $summary;

        if ($start > $end) {
            throw new InvalidDatesException($start, $end);
        }

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * Create the VEvent.
     *
     * @param  string   $summary
     * @param  DateTime $start
     * @param  DateTime $end
     *
     * @return self
     */
    public static function create(string $summary, DateTime $start, DateTime $end)
    {
        return new static($summary, $start, $end);
    }

    /**
     * Set the Product Identifier.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setProdId($prodid = '')
    {
        $this->prodid = $prodid;

        return $this;
    }

    /**
     * Set the Event Organizer.
     *
     * @param string $name
     * @param string $email
     *
     * @return $this
     */
    public function addOrganizer($name = '', $email = '')
    {
        if (strlen(trim($name)) < 1) {
            throw new InvalidOrganizer("Invalid Organizer Name");
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidOrganizer("Invalid Organizer Email");
        }

        $this->organizer = new \StdClass;

        $this->organizer->name = $name;
        $this->organizer->email = $email;

        return $this;
    }

    /**
     * Add the Attendees participating in the Event.
     *
     * @param array|string $attendees
     * @param string $value
     *
     * @return $this
     */
    public function addAttendees($column, $value = '')
    {
        if (is_array($column)) {
            foreach ($column as $attendee) {
                $this->attendee[] = [
                    'name' => $attendee['name'],
                    'email' => $attendee['email'],
                ];
            }

            return $this;
        }

        $this->attendees[] = [
            'name' => $column,
            'email' => $value
        ];

        return $this;
    }

    /**
     * Render the VEvent.
     *
     * @return string
     */
    public function render()
    {
        return (new Builder())->build($this);
    }

}
