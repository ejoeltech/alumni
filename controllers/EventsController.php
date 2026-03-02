<?php
/**
 * Events Controller
 * 
 * Manages the display of past and upcoming events on the public-facing pages.
 */
class EventsController extends Controller
{

    public function index()
    {
        // Instantiate the model and fetch data
        $eventModel = $this->model('Event');
        $events = $eventModel->getEvents();

        // Categorize events into 'Past' or 'Upcoming' as per spec requirements.
        $past_events = [];
        $upcoming_events = [];

        foreach ($events as $event) {
            if ($event['status'] === 'Upcoming') {
                $upcoming_events[] = $event;
            } elseif ($event['status'] === 'Past') {
                $past_events[] = $event;
            }
        }

        $data = [
            'title' => 'Events Diary - Alumni Platform',
            'past_events' => $past_events,
            'upcoming_events' => $upcoming_events
        ];

        // Load the main events view page
        $this->view('events/index', $data);
    }
}
