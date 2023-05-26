# php-lessons-pro
Bisix21 | Serhii

# code for table

create table urls_shorts
(
id         int auto_increment
primary key,
code       varchar(255) not null,
url        text         not null,
created_at timestamp    null,
updated_at timestamp    null
);

# templates
http://localhost:8080/?command=encode&url=https://laravel.com