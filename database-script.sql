DROP TABLE IF EXISTS ttg."exercise";
DROP TABLE IF EXISTS ttg."bid";
DROP TABLE IF EXISTS ttg."user";
DROP TABLE IF EXISTS ttg."period";
DROP TABLE IF EXISTS ttg."exercise_type";

CREATE TABLE ttg."period" (
 id serial PRIMARY KEY,
 name VARCHAR (50) UNIQUE NOT NULL
);
 
CREATE TABLE ttg."exercise_type" (
 id serial PRIMARY KEY,
 value VARCHAR (50) UNIQUE NOT NULL,
 description text
); 

CREATE TABLE ttg."user" (
 id serial PRIMARY KEY,
 not_secure_pw text,
 login VARCHAR (50) UNIQUE NOT NULL,
 name VARCHAR (255) NOT NULL
);

CREATE TABLE ttg."bid" (
 user_id integer NOT NULL,
 period_id integer NOT NULL,
 bid_uuid UUID UNIQUE NOT NULL,
 number smallint NOT NULL,
 PRIMARY KEY (user_id, period_id),
 CONSTRAINT bid_user_fkey FOREIGN KEY (user_id)
	REFERENCES ttg."user" (id) MATCH SIMPLE
	ON UPDATE NO ACTION ON DELETE NO ACTION,
 CONSTRAINT bid_period_fkey FOREIGN KEY (period_id)
	REFERENCES ttg."period" (id) MATCH SIMPLE
	ON UPDATE NO ACTION ON DELETE NO ACTION
); 

CREATE TABLE ttg."exercise" (
 id UUID PRIMARY KEY,
 bid_uuid UUID NOT NULL,
 exercise_type_id integer NOT NULL,
 exercise_duration_minutes smallint,
 exercise_date DATE,
 created_on TIMESTAMPTZ NOT NULL,
 CONSTRAINT exercise_bid_fkey FOREIGN KEY (bid_uuid)
	REFERENCES ttg."bid" (bid_uuid) MATCH SIMPLE
	ON UPDATE NO ACTION ON DELETE NO ACTION,
 CONSTRAINT exercise_exercise_type_fkey FOREIGN KEY (exercise_type_id)
	REFERENCES ttg."exercise_type" (id) MATCH SIMPLE
	ON UPDATE NO ACTION ON DELETE NO ACTION
 );

INSERT INTO ttg."period" (name) VALUES ('Oct-18');
INSERT INTO ttg."period" (name) VALUES ('Nov-18');
INSERT INTO ttg."period" (name) VALUES ('Dec-18');

INSERT INTO ttg."user" (login, not_secure_pw, name) VALUES ('admin', 'admin', 'admin');
INSERT INTO ttg."user" (login, name) VALUES ('johan', 'johan');