#працює тільки з початковою таблицею catalog_city!
alter table catalog_city
    add constraint catalog_city_id
        primary key (id);

drop table if exists regions_ua;
drop table if exists regions_ru;
drop table if exists cities_ua;
drop table if exists cities_ru;
drop table if exists new_post_code;
drop table if exists justin_post_code;
drop table if exists ukr_post_code;



#=======області
create table regions_ru
(
    id          int          not null
        primary key auto_increment,
    region_name varchar(255) not null,
    area_name   varchar(255) not null
);

create table regions_ua
(
    id          int          not null
        primary key auto_increment,
    region_name varchar(255) not null,
    area_name   varchar(255) not null
);
#========міста
create table cities_ua
(
    id        int          not null,
    city_name varchar(255) not null,
    region_id int          not null,
    constraint regions_ua___id_city
        foreign key (id) references catalog_city (id),
    constraint regions_ua___id_region
        foreign key (region_id) references regions_ua (id)
);

create table cities_ru
(
    id        int          not null,
    city_name varchar(255) not null,
    region_id int          not null,
    constraint regions_ru___id_city
        foreign key (id) references catalog_city (id),
    constraint regions_ru___id_region
        foreign key (region_id) references regions_ru (id)
);
#=======пошта
create table ukr_post_code
(
    id_city   int not null
        primary key,
    post_code int not null,
    constraint post_code___slug
        foreign key (id_city) references catalog_city (id)
);

create table new_post_code
(
    id_city   int          not null
        primary key,
    post_code varchar(255) not null,
    constraint new_post_code___slug
        foreign key (id_city) references catalog_city (id)
);

create table justin_post_code
(
    id_city   int not null
        primary key,
    post_code int not null,
    constraint justin_post_code___slug
        foreign key (id_city) references catalog_city (id)
);



insert into regions_ua(region_name, area_name)
select distinct region_name_uk, area_name_uk
from catalog_city;

insert into regions_ru(region_name, area_name)
select distinct region_name_ru, area_name_ru
from catalog_city;

INSERT INTO cities_ua (id, city_name, region_id)
SELECT cc.id, cc.name_uk, ru.id
FROM catalog_city cc
         INNER JOIN regions_ua ru ON cc.region_name_uk = ru.region_name;

INSERT INTO cities_ru (id, city_name, region_id)
SELECT cc.id, cc.name_ru, rr.id
FROM catalog_city cc
         INNER JOIN regions_ru rr ON cc.region_name_ru = rr.region_name;

insert into ukr_post_code(id_city, post_code)
select id, ukr_poshta_city_id
from catalog_city
where ukr_poshta_city_id is not null;

insert into new_post_code(id_city, post_code)
select id, new_post_city_id
from catalog_city
where new_post_city_id is not null;

insert into justin_post_code(id_city, post_code)
select id, justin_city_id
from catalog_city
where justin_city_id is not null;

alter table catalog_city
    drop column new_post_city_id;

alter table catalog_city
    drop column justin_city_id;

alter table catalog_city
    drop column ukr_poshta_city_id;

alter table catalog_city
    drop column name_uk;

alter table catalog_city
    drop column region_name_uk;

alter table catalog_city
    drop column area_name_uk;

alter table catalog_city
    drop column name_ru;

alter table catalog_city
    drop column area_name_ru;

alter table catalog_city
    drop column region_name_ru;