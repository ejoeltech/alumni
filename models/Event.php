<?php
/**
 * Event Model
 * 
 * Interacts with the `events` table.
 */
class Event
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Get all events
     * 
     * @return array Array of event rows
     */
    public function getEvents()
    {
        $stmt = $this->db->query('SELECT * FROM events ORDER BY event_date DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get single event by ID
     */
    public function getEventById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM events WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new Event
     */
    public function addEvent($data)
    {
        $stmt = $this->db->prepare('INSERT INTO events (title, description, event_date, location, status, image, created_by) VALUES (:title, :description, :event_date, :location, :status, :image, :created_by)');
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':event_date', $data['event_date']);
        $stmt->bindParam(':location', $data['location']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':created_by', $data['created_by']);

        return $stmt->execute();
    }

    /**
     * Update an existing Event
     */
    public function updateEvent($data)
    {
        // Only update image if strictly provided
        if (!empty($data['image'])) {
            $stmt = $this->db->prepare('UPDATE events SET title = :title, description = :description, event_date = :event_date, location = :location, status = :status, image = :image WHERE id = :id');
            $stmt->bindParam(':image', $data['image']);
        } else {
            $stmt = $this->db->prepare('UPDATE events SET title = :title, description = :description, event_date = :event_date, location = :location, status = :status WHERE id = :id');
        }

        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':event_date', $data['event_date']);
        $stmt->bindParam(':location', $data['location']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    /**
     * Delete an Event
     */
    public function deleteEvent($id)
    {
        $stmt = $this->db->prepare('DELETE FROM events WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
