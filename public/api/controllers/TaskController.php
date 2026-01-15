<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ .'/../utils/Response.php';

class TaskController {
    private $task;

    public function __construct() {
        $this->task = new Task();
    }
    public function index() {
        $tasks = $this->task->getAll();
        Response::success($tasks);
    }
    public function show($id) {
        $task = $this->task->getById($id);
        
        if ($task) {
            Response::success($task);
        } else {
            Response::error("Задача не найдена", 404);
        }
    }

    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$data) {
            Response::error("Некорректные данные");
        }
        $this->task->title = $data['title'] ?? '';
        $this->task->description = $data['description'] ?? '';
        $this->task->status = $data['status'] ?? 'pending';
        $errors = $this->task->validate();
        if (!empty($errors)) {
            Response::error(implode(", ", $errors));
        }
        if ($this->task->create()) {
            Response::success(['id' => $this->task->id], "Задача создана", 201);
        } else {
            Response::error("Не удалось создать задачу");
        }
    }
    public function update($id) {
        $existingTask = $this->task->getById($id);
        if (!$existingTask) {
            Response::error("Задача не найдена", 404);
        }
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$data) {
            Response::error("Некорректные данные");
        }
        $this->task->id = $id;
        $this->task->title = $data['title'] ?? $existingTask['title'];
        $this->task->description = $data['description'] ?? $existingTask['description'];
        $this->task->status = $data['status'] ?? $existingTask['status'];
        $errors = $this->task->validate();
        if (!empty($errors)) {
            Response::error(implode(", ", $errors));
        }
        if ($this->task->update()) {
            Response::success(null, "Задача обновлена");
        } else {
            Response::error("Не удалось обновить задачу");
        }
    }
    public function destroy($id) {
        // Проверяем, существует ли задача
        $existingTask = $this->task->getById($id);
        if (!$existingTask) {
            Response::error("Задача не найдена", 404);
        }
        if ($this->task->delete($id)) {
            Response::success(null, "Задача удалена");
        } else {
            Response::error("Не удалось удалить задачу");
        }
    }
}
?>