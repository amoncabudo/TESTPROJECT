select * from users;
insert into users values (1,'usuario1','password1','email1','0','img1','nom1','cognom1');
drop table users;

create table users(
    id int primary key AUTO_INCREMENT,
    username varchar(255) unique,
    password varchar (255),
    email varchar(255),
    role varchar(255) default "usuari",
    img varchar(255),
    name varchar(255),
    surname varchar(255)
);

insert into users values (1,'admin','admin','email@pruebaa.com','admin','img1','admin','admin');
insert into users values (2,'user','user','email@pruebab.com','user','img2','user','user');
select from users;

drop table canciones;

create table songs(
    id int primary key AUTO_INCREMENT,
    name varchar(255) ,
    artist varchar (255),
    path varchar(255) unique,
    duration int
);

insert into songs values (1,'cancion1','artista1','ruta1',100);