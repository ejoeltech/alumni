<?php
/**
 * Setting Model
 * 
 * Handles global database settings and logo urls.
 */
class Setting
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Get all settings from database
     */
    public function getAllSettings()
    {
        $stmt = $this->db->query('SELECT setting_key, setting_value FROM settings');
        $settings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    /**
     * Get a single setting by key
     */
    public function getSetting($key)
    {
        $stmt = $this->db->prepare('SELECT setting_value FROM settings WHERE setting_key = :key');
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['setting_value'] : null;
    }

    /**
     * Insert or update a setting using DUPLICATE KEY UPDATE logic
     */
    public function updateOrInsertSetting($key, $value)
    {
        $stmt = $this->db->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value) ON DUPLICATE KEY UPDATE setting_value = :update_value');
        $stmt->bindParam(':key', $key);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':update_value', $value);
        return $stmt->execute();
    }
}
