## 🛡️Эксплуатация USSC Stand
### Развертывание
bash
Copy
docker build -t USSC_stand .
docker run -d --name USSC_stand -p 80:80 USSC_stand
Настройка:
Откройте в браузере http://<ваш-ip>/install.php

## 🔍 Задание:
### Client-side уязвимости (2 на выбор, например):
1. Межсайтовый скриптинг (XSS)
2. Подделка межсайтовых запросов (CSRF)
3. Clickjacking
4. DOM-based уязвимости

## Server-side уязвимости (4 на выбор, например):
1. SQL-инъекции
2. Небезопасная десериализация
3. XXE-инъекции
4. SSRF
5. RCE
6. LFI/RFI