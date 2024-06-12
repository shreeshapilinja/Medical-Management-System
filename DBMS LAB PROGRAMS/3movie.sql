/* drop database test027_MOVIE; */
create database test027_MOVIE;
use test027_MOVIE;
create table ACTOR
(
	Act_id int,
	Act_name varchar(25),
	Act_gender varchar(6),
	primary key(Act_id)
);
create table DIRECTOR
(
	Dir_id int,
	Dir_name varchar(25),
	Dir_phone bigint,
	primary key(Dir_id)
);
create table MOVIES
(
	Mov_id int,
	Mov_title varchar(25),
	Mov_year int,
	Mov_lang varchar(25),
	dir_id int,
	primary key(Mov_id),
	foreign key(Dir_id) references DIRECTOR(Dir_id) on delete cascade
);
create table MOVIE_CAST
(
	Act_id int,
	Mov_id int,
	Role varchar(25),
	primary key(Act_id,Mov_id),
	foreign key(Act_id) references ACTOR(Act_id) on delete cascade,
	foreign key(Mov_id) references MOVIES(Mov_id) on delete cascade
);
create table RATING
(
	Rat_id int,
	Mov_id int,
	Rev_stars int,
	primary key(Rat_id),
	foreign key(Mov_id) references MOVIES(Mov_id) on delete cascade
);

desc ACTOR;
desc DIRECTOR;
desc MOVIES;
desc MOVIE_CAST;
desc RATING;

insert into ACTOR values
(1,'a','m'),
(2,'b','f');
insert into DIRECTOR values
(1,'h',12345),
(2,'ss',23456);
insert into MOVIES values
(1,'a',1990,'eng',1),
(2,'b',2001,'eng',1),
(3,'c',2017,'eng',2);
insert into MOVIE_CAST values
(1,1,'a'),
(1,2,'b'),
(1,3,'b'),
(2,1,'b'),
(2,2,'d');
insert into RATING values
(1,1,2),
(2,2,4),
(3,1,5),
(4,3,2);

select * from ACTOR;
select * from DIRECTOR;
select * from MOVIES;
select * from MOVIE_CAST;
select * from RATING;

/* 1  h= Hitchcock */
select m.Mov_title from MOVIES m,DIRECTOR d where m.Dir_id=d.Dir_id and d.Dir_name='h';

/* 2  */
select distinct m.Mov_title from MOVIES m,MOVIE_CAST mc
where m.Mov_id = mc.Mov_id and (select count(Mov_id) from MOVIE_CAST where Act_id=mc.Act_id)>=2;

/* 3  only a acted before and after  (copy of same in ()) */
select a.Act_name from ACTOR a,MOVIE_CAST mc,MOVIES m
where a.Act_id = mc.Act_id and mc.Mov_id = m.Mov_id and m.Mov_year<2000 
and a.Act_name in (select a.Act_name from ACTOR a,MOVIE_CAST mc,MOVIES m
where a.Act_id = mc.Act_id and mc.Mov_id = m.Mov_id and m.Mov_year>2015);

/* 4  (having is optional same result)*/
select m.Mov_title, max(r.Rev_stars) 
from MOVIES m,RATING r
where m.Mov_id = r.Mov_id 
group by m.Mov_title 
having count(*) >= 1
order by m.Mov_title;

/* 5. ss=Steven Spielberg */ 
update RATING set rev_stars=5
where mov_id in (select m.mov_id from MOVIES m, DIRECTOR d where m.dir_id = d.dir_id and d.dir_name='ss');
/* OR */
update RATING r,MOVIES m,DIRECTOR d SET r.Rev_stars = 5
where r.Mov_id = m.Mov_id and m.Dir_id = d.Dir_id and d.Dir_Name = 'ss';

select * from RATING;

