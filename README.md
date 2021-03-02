
# Checklist_service
### author: Nikita Kuznetsov 
## Тестовое задание

PHP с использованием фреймворка (Yii2 или Laravel)
#### Для реализации проекта был выбран Laravel 8

Основные функции сервиса:

1. Админка:

- Управление админами с разграничением прав;

- Управление пользователями с возможностью блокировки;

- Управление кол-вом возможных чек-листов у пользователя (в зависимости от роли админа, необходимо ограничивать данный функционал);

- Просмотр чек листов.

2. RestAPI (перечень методов которые необходимо реализовать):

- Регистрация / Авторизация;

- Создать/Удалить чек лист (учитывать настройки возможного кол-ва);

- Добавить/Удалить пункт в чек лист;

- Отметить выполнен/не выполнен пункт;

- Получить список чек листов;

- Получить список пунктов чеклиста с указанием выполнен/не выполнен.



## Установка
linux:

    ctrl+alt+tab

win:

    win+r 

    cmd

дальше одинаково:

    cd нужный каталог

    git clone https://github.com/alchemistOfWeb/checklist_service.git

    cd checklist_service

    composer update
    
далее копируем файл .env.example и переименовываем в просто .env 
заполняем нужные поля: 

DB_DATABASE=

DB_USERNAME=

DB_PASSWORD=


дальше, если хотите получить тестовые данные, используйте следующие команды(информация о доступах указана именно для тестовых пользователей):

    php artisan migrate 
    
    php artisan db:seed

также по умолчанию в корне проекта настроен файл .htaccess, который автоматичеки перенаправляет все запросы с корня в public, что исключает необходимость в использовании команды `php artisan serve`

## Информация о доступах: 
- admin panel:
    - email:          super@supermail.com
    - password:       root

- api:
    - email:          user@supermail.com
    - password:       root

Абсолютно для всех пользователей пароль по умолчанию: root

## admin panel

были реализованы все пункты из тз (
- Управление пользователями с возможностью блокировки;
    - get: http://checklist_service/admin/users   
        -Обзор всех юзеров с возможностью забанить/разбанить, удалить, перейти на страницу редактирования
    
    - get: http://checklist_service/admin/users/create

- Управление админами с разграничением прав; // По умолчанию доступно только при наличии роли 'Super admin'
    - get: http://checklist_service/admin/admins              -Обзор всех админов с их ролями
    - get: http://checklist_service/admin/admins/create       -Создание нового админа
    - get: http://checklist_service/admin/admins/{aid}/edit   
        -Здесь можно изменять роли тем самым предоставляя или ограничивая доступ к определённым ресурсам (посмотреть права ролей можно в разделе "roles")
    
- Управление кол-вом возможных чек-листов у пользователя (в зависимости от роли админа, необходимо ограничивать данный функционал); 
    - get: http://checklist_service/admin/users/{uid}/edit  
         -Редактирование юзера с возможностью ограничить макс кол-во чеклистов, если у вас есть роль с соответствующими правами. (по умолчанию доступно только для ролей "super-admin" и "admin")

- Просмотр чек листов.
    - get: http://checklist_service/admin/users/{uid}/checklists 
         -Все чеклисты конкретного пользователя
    
)

вот все возможные запросы для admin-panel:
- USERS:
    - get: http://checklist_service/admin/users
    - get: http://checklist_service/admin/users/{uid}/edit
    - get: http://checklist_service/admin/users/create
    - put/patch: http://checklist_service/admin/users/{uid}
    - patch: http://checklist_service/admin/users/{uid}/toggle-status
    - post: http://checklist_service/admin/users
    - delete: http://checklist_service/admin/users/{uid}

- CHECKLISTS:
    - get: http://checklist_service/admin/users/{uid}/checklists
    - get: http://checklist_service/admin/users/{uid}/checklists/{cid}/tasks

- ROLES:
    - get: http://checklist_service/admin/roles
    - get: http://checklist_service/admin/roles/{rid}/edit
    - get: http://checklist_service/admin/roles/create
    - delete: http://checklist_service/admin/roles/{rid}

- PERMISSIONS:
    - get: http://checklist_service/admin/users/{uid}/checklists
    - get: http://checklist_service/admin/users/{uid}/checklists/{cid}

- ADMINS:
    - get: http://checklist_service/admin/admins
    - get: http://checklist_service/admin/admins/create
    - get: http://checklist_service/admin/admins/{aid}/edit
    - put/patch: http://checklist_service/admin/admins/{aid}/edit
    - post: http://checklist_service/admin/admins
    - delete: http://checklist_service/admin/admins/{aid}

- LOGIN/REG:
    - get: http://checklist_service/admin/login
    - get: http://checklist_service/admin/logout
    - post: http://checklist_service/admin/login


## rest api
При успешной авторизации или регистрации в ответе клиенту будет отправлен специальный токен сгенерированный sanctum. Отправляя его в заголовке (authoriation: bearer {token}) можно получать доступ к ресурсам за исключением тех случаев, когда вас забанили или токен был удалён из базы данных

были реализованы и протестированы все методы из тз (
- Регистрация / Авторизация;
    можно получить досуп след запросами:
    - post: http://checklist_service/login

    json: 
    `
    {
        "email":"useremail",
        "password":"userpassword"
    }
    `

    - post: http://checklist_service/register

    json: 
    `
    {
        "email":"useremail",
        "name":"username",
        "password":"userpassword"
    }
    `

- Создать/Удалить чек лист (учитывать настройки возможного кол-ва);
    - post: http://checklist_service/api/checklists

    json: 
    `
    {
        "title":"sometitle",
        "description":"some description"
    }
    `

    - delete: http://checklist_service/api/checklists/{cid}

- Добавить/Удалить пункт в чек лист;
    - post: http://checklist_service/api/checklists/{cid}/tasks

    json: 
    `
    {
        "text":"What we need to do"
    }
    `

    - delete: http://checklist_service/api/checklists/{cid}/tasks/{tid}

- Отметить выполнен/не выполнен пункт;
    - put/patch: http://checklist_service/api/checklists/{cid}/tasks/{tid}/toggle

- Получить список чек листов;
    - get: http://checklist_service/api/checklists

- Получить список пунктов чеклиста с указанием выполнен/не выполнен.
    - get: http://checklist_service/api/checklists/{cid}/tasks

)


вот все возможные url для api:

- post: http://checklist_service/login
- post: http://checklist_service/register

- get: http://checklist_service/api/checklists
- get: http://checklist_service/api/checklists/{cid}/tasks

- put/patch: http://checklist_service/api/checklists/{cid}/tasks/{tid}/toggle
- post: http://checklist_service/api/checklists/{cid}/tasks
- delete: http://checklist_service/api/checklists/{cid}/tasks/{tid}

- post: http://checklist_service/api/checklists
- delete: http://checklist_service/api/checklists/{cid}




#
#
#






<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# checklist_service
