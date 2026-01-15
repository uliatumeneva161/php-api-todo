# Todo API (PHP)
D:\Apps\OSPanel\home\php-test\public\screen-requests\CRUD.png
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
