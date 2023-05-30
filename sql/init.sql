-- This file is run to set up the database the first time, or delete and recreate it if it needs to be wiped.

-- Use database (creation is done from hosting site's web portal)
USE zrimage;

-- Drop all tables
DROP TABLE IF EXISTS images;
DROP TABLE IF EXISTS users;

-- Create Tables
CREATE TABLE users(
	id int auto_increment primary key unique, 
	username varchar(30) unique, 
    password varchar(255), 
	email varchar(255), 
	time_joined timestamp default now(), 
	active boolean default true, 
	user_rank int default 0, 
	notes text
);

CREATE TABLE images(
	id int auto_increment primary key unique,
    uuid varchar(16) unique,
    mime varchar(128),
    extension varchar(10),
	author int,
    thumbnail bit not null default 0,
    animated bit not null default 0,
    time_uploaded timestamp default now(), 
    foreign key (author) references users(id)
);