DROP TABLE IF EXISTS exercise;
DROP TABLE IF EXISTS bid;
DROP TABLE IF EXISTS exercise_user;
DROP TABLE IF EXISTS period;
DROP TABLE IF EXISTS exercise_type;
DROP TYPE IF EXISTS period_status_enum;

CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

CREATE TYPE period_status_enum AS ENUM ('PAST', 'CURRENT', 'FUTURE');

CREATE TABLE period (
 id serial PRIMARY KEY,
 name VARCHAR (50) UNIQUE NOT NULL,
 status period_status_enum NOT NULL
);
 
CREATE TABLE exercise_type (
 id serial PRIMARY KEY,
 value VARCHAR (50) UNIQUE NOT NULL,
 description text
); 

CREATE TABLE exercise_user (
 id serial PRIMARY KEY,
 uuid UUID UNIQUE NOT NULL DEFAULT uuid_generate_v4(),
 not_secure_pw text,
 login VARCHAR (50) UNIQUE NOT NULL,
 name VARCHAR (255) NOT NULL
);

CREATE TABLE bid (
 id serial UNIQUE NOT NULL,
 exercise_user_id integer NOT NULL,
 period_id integer NOT NULL,
 uuid UUID UNIQUE NOT NULL DEFAULT uuid_generate_v4(),
 number smallint NOT NULL,
 PRIMARY KEY (exercise_user_id, period_id),
 CONSTRAINT bid_user_fkey FOREIGN KEY (exercise_user_id)
	REFERENCES exercise_user (id) MATCH SIMPLE
	ON UPDATE NO ACTION ON DELETE NO ACTION,
 CONSTRAINT bid_period_fkey FOREIGN KEY (period_id)
	REFERENCES period (id) MATCH SIMPLE
	ON UPDATE NO ACTION ON DELETE NO ACTION
); 

CREATE TABLE exercise (
 id serial PRIMARY KEY,
 uuid UUID UNIQUE NOT NULL DEFAULT uuid_generate_v4(),
 bid_id integer NOT NULL,
 exercise_type_id integer,
 exercise_duration_minutes smallint,
 exercise_date DATE NOT NULL DEFAULT now(),
 created_on TIMESTAMPTZ NOT NULL DEFAULT now(),
 CONSTRAINT exercise_bid_fkey FOREIGN KEY (bid_id)
	REFERENCES bid (id) MATCH SIMPLE
	ON UPDATE NO ACTION ON DELETE NO ACTION,
 CONSTRAINT exercise_exercise_type_fkey FOREIGN KEY (exercise_type_id)
	REFERENCES exercise_type (id) MATCH SIMPLE
	ON UPDATE NO ACTION ON DELETE NO ACTION
 );

INSERT INTO period (id, name, status) VALUES (1, 'Oct-18', 'PAST');
INSERT INTO period (id, name, status) VALUES (2, 'Nov-18', 'CURRENT');
INSERT INTO period (id, name, status) VALUES (3, 'Dec-18', 'FUTURE');

INSERT INTO exercise_user (id, login, name) VALUES (1, 'test', 'test');
INSERT INTO exercise_user (id, login, not_secure_pw, name) VALUES (2, 'admin', 'admin', 'admin');

INSERT INTO bid (exercise_user_id, period_id, number) VALUES (1, 1, 3);
INSERT INTO bid (exercise_user_id, period_id, number) VALUES (1, 2, 5);
INSERT INTO bid (exercise_user_id, period_id, number) VALUES (2, 1, 4);

INSERT INTO exercise (bid_id, exercise_duration_minutes) VALUES (1, 30);
INSERT INTO exercise (bid_id, exercise_duration_minutes) VALUES (1, 35);
INSERT INTO exercise (bid_id, exercise_duration_minutes) VALUES (3, 20);