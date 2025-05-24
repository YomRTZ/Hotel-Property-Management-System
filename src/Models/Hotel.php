<?php
class Hotel {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Hotel");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Hotel WHERE Id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function save($data) {
        $id = $data['id'] ?? null;
        $name = $data['name'];
        $grade = $data['grade'];
        $isDefault = isset($data['isDefault']) ? 1 : 0;
        $remark = $data['remark'] ?? null;

        if ($id) {
            $stmt = $this->db->prepare("UPDATE Hotel SET Name = ?, Grade = ?, isDefault = ?, Remark = ? WHERE Id = ?");
            $stmt->bind_param("siisi", $name, $grade, $isDefault, $remark, $id);
        } else {
            $stmt = $this->db->prepare("INSERT INTO Hotel (Name, Grade, isDefault, Remark) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("siis", $name, $grade, $isDefault, $remark);
        }

        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Hotel WHERE Id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}