<?php
/**
 * Project Model
 * 
 * Interacts with the `projects` table.
 */
class Project
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Get all projects
     * 
     * @return array Array of project rows
     */
    public function getProjects()
    {
        $stmt = $this->db->query('SELECT * FROM projects ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get single project by ID
     */
    public function getProjectById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM projects WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new Project
     */
    public function addProject($data)
    {
        $stmt = $this->db->prepare('INSERT INTO projects (name, description, budget, start_date, completion_date, status, project_lead, created_by) VALUES (:name, :description, :budget, :start_date, :completion_date, :status, :project_lead, :created_by)');
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $budget = !empty($data['budget']) ? $data['budget'] : null;
        $start_date = !empty($data['start_date']) ? $data['start_date'] : null;
        $completion_date = !empty($data['completion_date']) ? $data['completion_date'] : null;

        $stmt->bindParam(':budget', $budget);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':completion_date', $completion_date);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':project_lead', $data['project_lead']);
        $stmt->bindParam(':created_by', $data['created_by']);

        return $stmt->execute();
    }

    /**
     * Update an existing Project
     */
    public function updateProject($data)
    {
        $stmt = $this->db->prepare('UPDATE projects SET name = :name, description = :description, budget = :budget, start_date = :start_date, completion_date = :completion_date, status = :status, project_lead = :project_lead WHERE id = :id');

        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $budget = !empty($data['budget']) ? $data['budget'] : null;
        $start_date = !empty($data['start_date']) ? $data['start_date'] : null;
        $completion_date = !empty($data['completion_date']) ? $data['completion_date'] : null;

        $stmt->bindParam(':budget', $budget);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':completion_date', $completion_date);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':project_lead', $data['project_lead']);

        return $stmt->execute();
    }

    /**
     * Delete a Project
     */
    public function deleteProject($id)
    {
        $stmt = $this->db->prepare('DELETE FROM projects WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
