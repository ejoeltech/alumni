<?php
/**
 * User Model
 * 
 * Handles database operations for Users.
 */
class User
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Find a user by email
     * 
     * @param string $email
     * @return mixed Array of user data or false
     */
    public function findUserByEmail($email)
    {
        if (!$this->db)
            return false;

        // Prepared statement to prevent SQL injection
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');

        // Bind values
        $stmt->bindParam(':email', $email);

        // Execute the statement
        $stmt->execute();

        // Fetch result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a row was found
        if ($stmt->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function findUserByPhone($phone)
    {
        if (!$this->db)
            return false;
        $stmt = $this->db->prepare('SELECT * FROM users WHERE phone_number = :phone');
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0)
            return $row;
        else
            return false;
    }

    public function findUserByEmailOrPhone($login_id)
    {
        if (!$this->db)
            return false;
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :login_id OR phone_number = :login_id');
        $stmt->bindParam(':login_id', $login_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0)
            return $row;
        else
            return false;
    }

    /**
     * Register User
     * 
     * @param array $data User details
     * @return bool
     */
    public function register($data)
    {
        $stmt = $this->db->prepare('INSERT INTO users (full_name, email, phone_number, date_of_birth, graduation_year, class_set, password, is_approved) VALUES (:full_name, :email, :phone_number, :dob, :graduation_year, :class_set, :password, 0)');

        // Bind values
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':email', $data['email']);
        // Phone
        $stmt->bindParam(':phone_number', $data['phone_number']);

        // Nullable Dob
        $dob = !empty($data['date_of_birth']) ? $data['date_of_birth'] : null;
        $stmt->bindParam(':dob', $dob);

        // Nullable graduation year and class set
        $grad_year = !empty($data['graduation_year']) ? $data['graduation_year'] : null;
        $class_set = !empty($data['class_set']) ? $data['class_set'] : null;

        $stmt->bindParam(':graduation_year', $grad_year);
        $stmt->bindParam(':class_set', $class_set);
        $stmt->bindParam(':password', $data['password']);

        // Execute
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Echo raw error onscreen instead of error_log since production server suppresses logs
            die("<div style='padding:20px; background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; border-radius:5px; margin:20px;'><strong>Database Crash:</strong> " . htmlspecialchars($e->getMessage()) . "</div>");
        }
    }

    /**
     * Login User
     * 
     * @param string $login_id
     * @param string $password
     * @return mixed User row on success, false on failure
     */
    public function login($login_id, $password)
    {
        $row = $this->findUserByEmailOrPhone($login_id);

        if ($row == false)
            return false;

        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * Get all users
     */
    public function getAllUsers()
    {
        // Fetch all users along with their role names through a simple INNER JOIN
        $stmt = $this->db->query('SELECT u.*, r.role_name FROM users u INNER JOIN roles r ON u.role_id = r.id ORDER BY u.created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all members with an assigned Executive Position status
     */
    public function getExcoMembers()
    {
        $stmt = $this->db->query('SELECT * FROM users WHERE membership_position IS NOT NULL AND membership_position != "" ORDER BY created_at ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Dynamically Search, Filter, and Sort the Member Directory (Public)
     */
    public function searchMembers($filters, $sortBy = 'full_name', $sortDir = 'ASC')
    {
        $query = 'SELECT * FROM users WHERE role_id > 0'; // Exclude blocked/deleted logically if implemented
        $params = [];

        // Dynamic Filtering
        if (!empty($filters['search'])) {
            $query .= ' AND (full_name LIKE :search OR email LIKE :search OR class_set LIKE :search OR phone_number LIKE :search)';
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['graduation_year'])) {
            $query .= ' AND graduation_year = :graduation_year';
            $params[':graduation_year'] = $filters['graduation_year'];
        }

        if (!empty($filters['class_set'])) {
            $query .= ' AND class_set = :class_set';
            $params[':class_set'] = $filters['class_set'];
        }

        // Direct sorting validation (safeguard)
        $allowedSortColumns = ['full_name', 'graduation_year', 'class_set', 'created_at'];
        $allowedSortDirs = ['ASC', 'DESC'];

        $safeSortBy = in_array($sortBy, $allowedSortColumns) ? $sortBy : 'full_name';
        $safeSortDir = in_array(strtoupper($sortDir), $allowedSortDirs) ? strtoupper($sortDir) : 'ASC';

        $query .= ' ORDER BY ' . $safeSortBy . ' ' . $safeSortDir;

        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch distinct values for specific columns to populate filter dropdowns dynamically.
     */
    public function getDistinctValues($columnName)
    {
        $allowedColumns = ['graduation_year', 'class_set'];
        if (!in_array($columnName, $allowedColumns)) {
            return [];
        }

        $query = 'SELECT DISTINCT ' . $columnName . ' FROM users WHERE ' . $columnName . ' IS NOT NULL AND ' . $columnName . ' != "" ORDER BY ' . $columnName . ' ASC';
        $stmt = $this->db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $values = [];
        foreach ($results as $row) {
            $values[] = $row[$columnName];
        }
        return $values;
    }

    /**
     * Get a single user by ID
     */
    public function getUserById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update a user's role, status, and Exco positions
     */
    public function updateUserAdmin($id, $role_id, $is_active, $membership_position)
    {
        $stmt = $this->db->prepare('UPDATE users SET role_id = :role_id, is_active = :is_active, membership_position = :membership_position WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->bindParam(':is_active', $is_active);

        $pos = !empty($membership_position) ? $membership_position : null;
        $stmt->bindParam(':membership_position', $pos);

        return $stmt->execute();
    }

    /**
     * Approve a newly registered user
     */
    public function approveUser($id, $admin_id)
    {
        $stmt = $this->db->prepare('UPDATE users SET is_approved = 1, approved_by = :admin_id WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':admin_id', $admin_id);
        return $stmt->execute();
    }

    /**
     * Delete a single user
     */
    public function deleteUser($id)
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updatePassword($id, $hashed_password)
    {
        $stmt = $this->db->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updateProfile($id, $data)
    {
        // Notice we include profile_picture in case we have to upload one based on the user request
        $sql = 'UPDATE users SET full_name = :full_name, phone_number = :phone_number, date_of_birth = :date_of_birth, graduation_year = :graduation_year, class_set = :class_set';
        if (isset($data['profile_picture'])) {
            $sql .= ', profile_picture = :profile_picture';
        }
        $sql .= ' WHERE id = :id';

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':phone_number', $data['phone_number']);
        $dob = !empty($data['date_of_birth']) ? $data['date_of_birth'] : null;
        $stmt->bindParam(':date_of_birth', $dob);
        $stmt->bindParam(':graduation_year', $data['graduation_year']);
        $stmt->bindParam(':class_set', $data['class_set']);
        if (isset($data['profile_picture'])) {
            $stmt->bindParam(':profile_picture', $data['profile_picture']);
        }
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
