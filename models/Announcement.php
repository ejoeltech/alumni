<?php
/**
 * Announcement Model
 * 
 * Handles CRUD for Platform Announcements layout and broadcasting variables
 */
class Announcement
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllAnnouncements()
    {
        // Join with users table to get the author's name
        $stmt = $this->db->query('SELECT a.*, u.full_name as author_name FROM announcements a LEFT JOIN users u ON a.created_by = u.id ORDER BY a.created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnnouncementById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM announcements WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addAnnouncement($data)
    {
        $stmt = $this->db->prepare('INSERT INTO announcements (title, content, status, created_by) VALUES (:title, :content, :status, :created_by)');
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':created_by', $data['created_by']);
        return $stmt->execute();
    }

    public function updateAnnouncement($data)
    {
        $stmt = $this->db->prepare('UPDATE announcements SET title = :title, content = :content, status = :status WHERE id = :id');
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':id', $data['id']);
        return $stmt->execute();
    }

    public function deleteAnnouncement($id)
    {
        $stmt = $this->db->prepare('DELETE FROM announcements WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
