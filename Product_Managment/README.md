## Атака на приложение для менеджера продуктов
docker compose build
docker compose up -d
Ваше приложение - http://127.0.0.1:8000/apidocs/ (добавил для вашего удобства схему)

Задание 1
В этом задании вы войдете в приложение как user1@ussc.ru (с паролем User1Password) и повысите свои привилегии, чтобы изменить координаты GPS пользователя с именем admin1@ussc.ru (в аккаунт можно попасть через простую sqli, но ваша задача сделать это через подмену JWT):
Определите конечные точки API, которые отвечают за сохранение и извлечение координат GPS. Укажите полный URL конечной точки с необходимыми HTTP-глаголами.
Получите токен JWT для user1@ussc.ru и сохраните значение JWT.
Измените токен JWT пользователя user1@ussc.ru, чтобы он указывал на другого пользователя с адресом электронной почты admin1@ussc.ru, идентификатор которого равен 22 (тут вам поможет git clone http://github.com/ticarpi/jwt_tool && cd jwt_tool, p.s. secret=secret). После изменения токена JWT выведите новый токен JWT, чтобы показать, что адрес электронной почты admin1@ussc.ru с идентификатором 22.
Получите местоположение GPS для пользователя admin1@ussc.ru, а затем используя полученный токен, чтобы изменить значение на {1,1}


Задача 2: Используйте небезопасную десериализацией для выполнения произвольного кода на удаленном сервере

В этой задаче вам предстоит найти и проэксплуатировать уязвимость небезопасной десериализации в приложении для выполнения произвольного кода на сервере API. Вы можете войти как user1@ussc.ru (с паролем User1Password).

Проведите разведку в приложении и определите конечные точки, которые используют сериализацию данных. Укажите URL конечной точки входа с необходимыми глаголами HTTP.
Я написал вам простой скриптик, который поможет выполнить код или команд на сервере API (вам нужно прописать полезную нагрузку, которая будет выполнена и сериализацию, чтобы получить нужное вам значение).

cat > hacker.py<<EOF
import pickle
import base64
import os
import platform

os_version = platform.platform()

class Pwn(object):
    def __reduce__(self):
        *payload*
*ваша сериализация с помощью pickle*
EOF

Подтвердите, что вы можете выполнять команды с помощью небезопасной десериализации. В приложении есть страница /accesslogs, которую вы можете использовать для получения выходных данных команд с помощью значений строки запроса.

Получите версию операционной системы, на которой размещено приложение.

Задача 3: Атака на базу данных сервера API для извлечения информации

В этой задаче вы проэксплуатируете API приложения, чтобы получить код купона с сервера API:
Вы можете войти как user1@ussc.ru.
Определите конечные точки API, которые отвечают за обслуживание и проверку купонов. Укажите полный URL-адрес точки входа с необходимыми HTTP-глаголами.
Определите и подтвердите наличие уязвимости инъекции на конечных точках купонов.
Получите не менее пяти уникальных купонов из системы.
