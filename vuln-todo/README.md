## 🔧 Уязвимый todo-list

### Развертывание окружения
1. docker build -t todo-list .
2. docker run -d --name flask -p 80:5000 todo-list

Доступ к приложению:
http://127.0.0.1:5000/apidocs/

## 📝 Задание:
### XSS-атаки:
1. Stored XSS
2. DOM-based XSS
### Работа с БД:
1. Определить точную версию СУБД
2. Получить список таблиц
3. Извлечь пароли пользователей

### Файловая система:
Получить содержимое /etc/passwd
