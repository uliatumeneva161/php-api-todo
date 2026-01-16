# Todo API (PHP)


<img width="1407" height="1003" alt="CRUD" src="https://github.com/user-attachments/assets/f743b4f4-3658-4e07-a39d-e7918a6cf59f" />

<img width="1156" height="846" alt="GET-all" src="https://github.com/user-attachments/assets/bfc4bb85-425d-40f3-8d6e-576f39c1ec76" />

<img width="1043" height="565" alt="GET-id" src="https://github.com/user-attachments/assets/f6237daf-ca43-4907-9ad3-8f93cdeefc34" />

<img width="1077" height="850" alt="POST-withErr" src="https://github.com/user-attachments/assets/ee4f08ef-3fc9-4fd2-9ba4-647f2a1a1f46" />


Простое REST API для управления задачами (To-Do List), реализованное на чистом PHP

## Возможности
- CRUD операции для задач
- REST API
- MVC архитектура
- MySQL
- Валидация данных

## Эндпоинты

GET /tasks  
GET /tasks/{id}  
POST /tasks  
PUT /tasks/{id}  
DELETE /tasks/{id}  

## Пример запроса

POST /tasks
```json
{
  "title": "Новая задача",
  "description": "Описание",
  "status": "pending"
}
