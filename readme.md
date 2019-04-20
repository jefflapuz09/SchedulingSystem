## Faculty Scheduling Systen
---

### Features
- Maintenance Management
-- Room Management
-- Section Management

- Curriculum Management
-- Curriculum (Create, Read, Update)
-- Course Offering
-- Course Scheduling for the Courses Offered

- Users Management
-- Instructor
-- Administrator

- Reports Generation
-- Room Utilization
-- Teaching load per Instructor
- Other Functionalities
-- Realtime Notification if the teaching load is approved/rejected by the instructor.
-- Detects Conflict in Schedule
-- Easy Teachling load by Draggable Schedule (Day, Time Schedule)
-- Ability to Override the no. of units loaded depending on the employees status.

# Installation
---
- Open Terminal and run ```composer install``` from the root folder of the project.
- Create a database.
- Copy **.env.example** to **.env** and setup your database.
- Run ```php artisan key:generate``` to generate application key.
- Run ```php artisan migrate```  without quote to import all the existing tables.
- Run ```php artisan db:seed``` to seed your database.
- Run ```php artisan serve``` to start application.

# Requirements
---
- PHP 5 or higher
- MySQL
- Composer (To install Laravel and Other Dependencies)
- Pusher Account (*Optional*) for realtime notifications.

### Note
---
The Default user for admin is:
User: admin
Password: password

Follow me on:
[Facebook](https://www.facebook.com/JheyV09)
[Youtube](https://www.youtube.com/channel/UCBNLcyko1Bl2-NNHxZ8Yplw)
