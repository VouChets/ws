CREATE DATABASE IF NOT EXISTS nutricion;
USE nutricion;

CREATE TABLE IF NOT EXISTS users(
    id int(255) auto_increment not null,
    email varchar(255),
    role varchar(20),
    name varchar(255),
    surname varchar(255),
    password varchar(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    remember_token varchar(255),
    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS sections(
	id int(255) auto_increment not null,
	description varchar(255),
	CONSTRAINT pk_sections PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS posts(
    id int(255) auto_increment not null,
    user_id int(255) not null,
    section_id int(255) not null,
	num int(255),
    title varchar(255),
    description text,
	descriptionLargo text,
    image varchar(255),
    video varchar(255),
    link varchar(255),
    link_text varchar(30),
	status varchar(30),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    CONSTRAINT pk_posts PRIMARY KEY(id),
    CONSTRAINT fk_posts_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_posts_sections FOREIGN KEY(section_id) REFERENCES sections(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS profesionals(
    id int(255) auto_increment not null,
	user_id int(255) not null,
	num int(255),
	nombre varchar(30),
    apellido varchar(30),
	especialidad varchar(100),
	description text,
	descriptionLargo text,
	matricula_prov varchar(255),
	matricula_nac varchar(255),
	facebook varchar(255),
	linkedin varchar(255),
	email varchar(255),
	instagram varchar(255),
	tel varchar(50),
	status varchar(30),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    CONSTRAINT pk_profesionals PRIMARY KEY(id),
	CONSTRAINT fk_profesionals_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS contactos(
    id int(255) auto_increment not null,
	user_id int(255) not null,
	num int(255),
    title varchar(255),
    description text,
	descriptionLargo text,
	tel varchar(50),
	email varchar(255),
	status varchar(30),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    CONSTRAINT pk_contactos PRIMARY KEY(id),
	CONSTRAINT fk_contactos_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;