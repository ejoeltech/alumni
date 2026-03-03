<?php
class Election
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getAllElections()
    {
        $stmt = $this->db->query('SELECT * FROM elections ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveElections()
    {
        $stmt = $this->db->query('SELECT * FROM elections WHERE is_active = 1 AND now() BETWEEN start_date AND end_date ORDER BY end_date ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getElectionById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM elections WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createElection($data)
    {
        $stmt = $this->db->prepare('INSERT INTO elections (title, description, start_date, end_date, is_active) VALUES (:title, :description, :start_date, :end_date, :is_active)');
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $start_date = !empty($data['start_date']) ? $data['start_date'] : null;
        $end_date = !empty($data['end_date']) ? $data['end_date'] : null;

        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':is_active', $data['is_active']);
        return $stmt->execute();
    }

    public function updateElectionStatus($id, $is_active)
    {
        $stmt = $this->db->prepare('UPDATE elections SET is_active = :is_active WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':is_active', $is_active);
        return $stmt->execute();
    }

    public function deleteElection($id)
    {
        $stmt = $this->db->prepare('DELETE FROM elections WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // --- POSITIONS MAPPED TO ELECTIONS ---

    public function getPositionsForElection($election_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM election_positions WHERE election_id = :election_id');
        $stmt->bindParam(':election_id', $election_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mapPositionToElection($election_id, $title)
    {
        $stmt = $this->db->prepare('INSERT INTO election_positions (election_id, title) VALUES (:election_id, :title)');
        $stmt->bindParam(':election_id', $election_id);
        $stmt->bindParam(':title', $title);
        return $stmt->execute();
    }

    // --- CANDIDATES ---

    public function getCandidatesForPosition($position_id)
    {
        $stmt = $this->db->prepare('
            SELECT c.*, u.full_name, u.profile_picture, u.class_set 
            FROM election_candidates c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.position_id = :position_id
        ');
        $stmt->bindParam(':position_id', $position_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerCandidate($position_id, $user_id, $manifesto)
    {
        $stmt = $this->db->prepare('INSERT INTO election_candidates (position_id, user_id, manifesto) VALUES (:position_id, :user_id, :manifesto)');
        $stmt->bindParam(':position_id', $position_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':manifesto', $manifesto);
        return $stmt->execute();
    }

    // --- VOTING ---

    public function hasUserVotedForPosition($position_id, $voter_id)
    {
        $stmt = $this->db->prepare('SELECT id FROM election_votes WHERE position_id = :position_id AND voter_id = :voter_id');
        $stmt->bindParam(':position_id', $position_id);
        $stmt->bindParam(':voter_id', $voter_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function castVote($position_id, $voter_id, $candidate_id)
    {
        // Double check they haven't voted for this exact position title before in this election
        if ($this->hasUserVotedForPosition($position_id, $voter_id))
            return false;

        $stmt = $this->db->prepare('INSERT INTO election_votes (position_id, voter_id, candidate_id) VALUES (:position_id, :voter_id, :candidate_id)');
        $stmt->bindParam(':position_id', $position_id);
        $stmt->bindParam(':voter_id', $voter_id);
        $stmt->bindParam(':candidate_id', $candidate_id);
        return $stmt->execute();
    }

    public function getVoteCountForCandidate($candidate_id)
    {
        $stmt = $this->db->prepare('SELECT COUNT(id) as total_votes FROM election_votes WHERE candidate_id = :candidate_id');
        $stmt->bindParam(':candidate_id', $candidate_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['total_votes'] : 0;
    }
}
