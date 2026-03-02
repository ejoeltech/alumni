<?php
class ExcoPosition
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllPositions()
    {
        $stmt = $this->db->query('SELECT * FROM exco_positions ORDER BY title ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPositionById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM exco_positions WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPosition($data)
    {
        $stmt = $this->db->prepare('INSERT INTO exco_positions (title, description) VALUES (:title, :description)');
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        return $stmt->execute();
    }

    public function updatePosition($data)
    {
        $stmt = $this->db->prepare('UPDATE exco_positions SET title = :title, description = :description WHERE id = :id');
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        return $stmt->execute();
    }

    public function deletePosition($id)
    {
        $stmt = $this->db->prepare('DELETE FROM exco_positions WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
