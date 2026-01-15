<?php
require_once __DIR__ . '/../config/db.php';


class Task {
    private $conn;
    private $table = 'tasks';
    public $id;
    public $title;
    public $description;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct() {
    $this->conn = Database::getConnection();
    }
    public function getAll() {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            error_log("Database error in getAll(): " . $e->getMessage());
            return [];
        }
    }
    public function getById($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $task = $stmt->fetch();
            
            if ($task) {
                $this->id = $task['id'];
                $this->title = $task['title'];
                $this->description = $task['description'];
                $this->status = $task['status'];
                $this->created_at = $task['created_at'];
                $this->updated_at = $task['updated_at'];
            }
            
            return $task;
        } catch(PDOException $e) {
            error_log("Database error in getById(): " . $e->getMessage());
            return false;
        }
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table . " 
                      SET title = :title, description = :description, status = :status";
            
            $stmt = $this->conn->prepare($query);
            
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->status = htmlspecialchars(strip_tags($this->status));
            
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':status', $this->status);
            
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
            
            return false;
        } catch(PDOException $e) {
            error_log("db err(): " . $e->getMessage());
            return false;
        }
    }
    public function update() {
        try {
            $query = "UPDATE " . $this->table . " 
                      SET title = :title, description = :description, status = :status 
                      WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->status = htmlspecialchars(strip_tags($this->status));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':id', $this->id);
            
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Database error in update(): " . $e->getMessage());
            return false;
        }
    }
    public function delete($id) {
        try {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Database error in delete(): " . $e->getMessage());
            return false;
        }
    }
    public function validate() {
        $errors = [];

        if (empty($this->title)) {
            $errors[] = "Заголовок задачи не может быть пустым";
        }

        if (strlen($this->title) > 255) {
            $errors[] = "Заголовок не может быть длиннее 255 символов";
        }

        if (!in_array($this->status, ['pending', 'in_progress', 'completed'])) {
            $errors[] = "Недопустимый статус задачи";
        }

        return $errors;
    }
}
?>