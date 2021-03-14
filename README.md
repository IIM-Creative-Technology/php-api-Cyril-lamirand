# Symfony API Project - A3

## Env & Dependencies
🔸 <b>Doctrine/orm</b> : 2.8<br>
🔹 <b>Doctrine/Fixtures-Bundle</b> : 3.4<br>
🔸 <b>Firebase/jwt-php</b> : 5.2<br>
## Installation
```
git clone https://github.com/IIM-Creative-Technology/php-api-Cyril-lamirand.git
```
Open your shell / prompt :
```
cd Path/to/my/project/php-api-Cyril-lamirand
```
```
composer install
```
You have to configure the file <b>.env</b> with your environment (line 30) !
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/symfony_api_rendu?serverVersion=5.7"
```
Then :
```
php bin/console doctrine:database:create
```
```
php bin/console doctrine:migrations:migrate
```
```
php bin/console doctrine:fixtures:load
```
```
symfony server:start
```

## Access API
You can register a new user here :
```
http://127.0.0.1:8000/auth/register
```
That give you a bearer token. Now you can authenticate yourself on my API !
<br>
<i>Example :</i>
```
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoicGllcnJlLmdyaW1hdWRAZGV2aW5jaS5mciIsImV4cCI6MTYxNTY3MTU2Mn0.sbFJPc6gQBTb4b8fuuCTkihylM09ZJdJAjrg0SdmOG8
```
You can try your access with this route :
```
http://127.0.0.1:8000/api/test
```
<i>Of course, you have to do every test with <a href="https://www.postman.com/">Postman App</a> !</i>

## All the Routes
### Classroom
* 🟢 (GET) : <b>/api/classrooms</b>
* 🟠 (POST) : <b>/api/classroom/new</b>
* 🟢 (GET) : <b>/api/classroom/{id}</b>
* 🔵 (PUT) : <b>/api/classroom/{id}</b>
* 🔴 (DELETE) : <b>/api/classroom/{id}</b>

Parameters : <i><b>label</b> : String, <b>promotion</b> : Entity</i>

### Course
* 🟢 (GET) : <b>/api/courses</b>
* 🟠 (POST) : <b>/api/course/new</b>
* 🟢 (GET) : <b>/api/course/{id}</b>
* 🔵 (PUT) : <b>/api/course/{id}</b>
* 🔴 (DELETE) : <b>/api/course/{id}</b>

Parameters : <i><b>label</b> : String, <b>promotion</b> : Entity, <b>classroom</b>: Entity, <b>teacher</b> : Entity, <b>start</b> : DateTime, <b>end</b> : DateTime</i>

### Promotion
* 🟢 (GET) : <b>/api/promotions</b>
* 🟠 (POST) : <b>/api/promotion/new</b>
* 🟢 (GET) : <b>/api/promotion/{id}</b>
* 🔵 (PUT) : <b>/api/promotion/{id}</b>
* 🔴 (DELETE) : <b>/api/promotion/{id}</b>

Parameters : <i><b>start</b> : String, <b>end</b> : String</i>

### Student
* 🟢 (GET) : <b>/api/students</b>
* 🟠 (POST) : <b>/api/student/new</b>
* 🟢 (GET) : <b>/api/student/{id}</b>
* 🔵 (PUT) : <b>/api/student/{id}</b>
* 🔴 (DELETE) : <b>/api/student/{id}</b>

Parameters : <i><b>firstname</b> : String, <b>lastname</b> : String, <b>age</b> : Integer, <b>entry_date</b> : DateTime, <b>promotion</b> : Entity, <b>classroom</b> : Entity</i>

### Teacher
* 🟢 (GET) : <b>/api/teachers</b>
* 🟠 (POST) : <b>/api/teacher/new</b>
* 🟢 (GET) : <b>/api/teacher/{id}</b>
* 🔵 (PUT) : <b>/api/teacher/{id}</b>
* 🔴 (DELETE) : <b>/api/teacher/{id}</b>

Parameters : <i><b>firstname</b> : String, <b>lastname</b> : String, <b>entry_date</b> : DateTime</i>

### Result
* 🟢 (GET) : <b>/api/results</b>
* 🟠 (POST) : <b>/api/result/new</b>
* 🟢 (GET) : <b>/api/result/{id}</b>
* 🔵 (PUT) : <b>/api/result/{id}</b>
* 🔴 (DELETE) : <b>/api/result/{id}</b>

Parameters : <i><b>score</b> : Integer, <b>student</b> : Entity, <b>course</b> : Entity</i>
