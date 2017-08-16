<?php

namespace NotificationChannels\GoogleCalendar;

use Illuminate\Bus\Queueable;

class GoogleCalendarMessage
{
    use Queueable;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Set the message data.
     *
     * @param  array $data
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return (array) $this->data;
    }
}
