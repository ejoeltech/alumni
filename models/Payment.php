<?php
class Payment
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // --- DUES MANAGEMENT ---

    public function getAllDues()
    {
        $stmt = $this->db->query('SELECT * FROM dues ORDER BY due_date DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDueById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM dues WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createDue($data)
    {
        $stmt = $this->db->prepare('INSERT INTO dues (title, amount, description, due_date, is_monthly, is_donation) VALUES (:title, :amount, :description, :due_date, :is_monthly, :is_donation)');
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':description', $data['description']);
        $due_date = !empty($data['due_date']) ? $data['due_date'] : null;
        $stmt->bindParam(':due_date', $due_date);

        $is_monthly = isset($data['is_monthly']) ? (int) $data['is_monthly'] : 0;
        $is_donation = isset($data['is_donation']) ? (int) $data['is_donation'] : 0;

        $stmt->bindParam(':is_monthly', $is_monthly, PDO::PARAM_INT);
        $stmt->bindParam(':is_donation', $is_donation, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateDue($data)
    {
        $stmt = $this->db->prepare('UPDATE dues SET title = :title, amount = :amount, description = :description, due_date = :due_date WHERE id = :id');
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':description', $data['description']);
        $due_date = !empty($data['due_date']) ? $data['due_date'] : null;
        $stmt->bindParam(':due_date', $due_date);
        return $stmt->execute();
    }

    public function deleteDue($id)
    {
        $stmt = $this->db->prepare('DELETE FROM dues WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // --- PAYMENTS MANAGEMENT ---

    public function getAllPayments()
    {
        $stmt = $this->db->query('
            SELECT p.*, u.full_name, u.email, d.title as due_title 
            FROM payments p 
            JOIN users u ON p.user_id = u.id 
            LEFT JOIN dues d ON p.due_id = d.id 
            ORDER BY p.created_at DESC
        ');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaymentsByUser($user_id)
    {
        $stmt = $this->db->prepare('
            SELECT p.*, d.title as due_title 
            FROM payments p 
            LEFT JOIN dues d ON p.due_id = d.id 
            WHERE p.user_id = :user_id 
            ORDER BY p.created_at DESC
        ');
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaymentById($id)
    {
        $stmt = $this->db->prepare('
            SELECT p.*, u.full_name, u.email, d.title as due_title 
            FROM payments p 
            JOIN users u ON p.user_id = u.id 
            LEFT JOIN dues d ON p.due_id = d.id 
            WHERE p.id = :id
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPayment($data)
    {
        $stmt = $this->db->prepare('
            INSERT INTO payments (user_id, due_id, amount, payment_date, payment_method, reference_number, status) 
            VALUES (:user_id, :due_id, :amount, :payment_date, :payment_method, :reference_number, :status)
        ');

        $stmt->bindParam(':user_id', $data['user_id']);
        $due_id = !empty($data['due_id']) ? $data['due_id'] : null;
        $stmt->bindParam(':due_id', $due_id);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':payment_date', $data['payment_date']);
        $stmt->bindParam(':payment_method', $data['payment_method']);
        $stmt->bindParam(':reference_number', $data['reference_number']);
        $status = isset($data['status']) ? $data['status'] : 'Pending';
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    public function updatePaymentStatus($id, $status)
    {
        $stmt = $this->db->prepare('UPDATE payments SET status = :status WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function deletePayment($id)
    {
        $stmt = $this->db->prepare('DELETE FROM payments WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
