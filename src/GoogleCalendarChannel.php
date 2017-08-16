<?php

namespace NotificationChannels\GoogleCalendar;

use NotificationChannels\GoogleCalendar\Exceptions\CouldNotSendNotification;
use NotificationChannels\GoogleCalendar\Events\MessageWasSent;
use NotificationChannels\GoogleCalendar\Events\SendingMessage;
use Illuminate\Notifications\Notification;
use Spatie\GoogleCalendar\Event;

class GoogleCalendarChannel
{
    /**
     * @var Event
     */
    protected $event;

    /**
     * GoogleCalendarChannel Constructor
     * 
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\GoogleCalendar\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $url = $notifiable->routeNotificationFor('GoogleCalendar')) {
            return;
        }

        $data = $notification->toGoogleCalendar($notifiable)->toArray();

        try {
            $this->event->name = $data['name'];
            $this->event->startDateTime = $data['start_date'];
            $this->event->endDateTime = $data['end_date'];
            $this->event->addAttendee(['email' => $data['attendee']]);
            $this->event->save();
        } catch (\Exception $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->getMessage());
        }
    }
}
