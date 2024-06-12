/* ssid semester-section ID ,   SUBJECT = COURSE  */
/* drop database test027_COLLEGE; */
create database test027_COLLEGE;
use test027_COLLEGE;
create table STUDENT
(
	Usn varchar(25),
	Sname varchar(25),
	Address varchar(25),
	Phone bigint,
	Gender varchar(6),
	primary key(Usn)
);
create table SEMSEC
(
	Ssid int,  
	Sem int,
	Sec varchar(1),
	primary key(Ssid)
);
create table CLASS
(
	Usn varchar(25),
	Ssid int,
	primary key(Usn),
	foreign key(Usn) references STUDENT(Usn) on delete cascade,
	foreign  key(Ssid) references SEMSEC(Ssid) on delete cascade
);
create table SUBJECT
(
	Sub_code varchar(25),
	Title varchar(25),
	Sem int,
	Credits int,
	primary key(Sub_code)
);
create table IAMARKS
(
	Usn varchar(25),
	Sub_code varchar(25),
	Ssid int,
	Test1 int,
	Test2 int,
	Test3 int,
	Finalia int,
	primary key(Usn,Sub_code,Ssid),
	foreign key(Usn) references STUDENT(Usn) on delete cascade,
	foreign key(Sub_code) references SUBJECT(Sub_code) on delete cascade,
	foreign key(Ssid) references SEMSEC(Ssid) on delete cascade
);

desc STUDENT;
desc SEMSEC;
desc CLASS;
desc SUBJECT;

insert into STUDENT values
('ai001','a','a',12345,'m'),
('ai002','b','b',23456,'f'),
('ai003','c','c',34567,'m'),
('ai004','d','d',45678,'f');
insert into SEMSEC values
(1,4,'c'),
(2,8,'a'),
(3,8,'b'),
(4,8,'b');
insert into CLASS values
('ai001',1),
('ai002',2),
('ai003',3),
('ai004',4);
insert into SUBJECT values
('41','a',4,1),
('81','b',8,2),
('82','c',8,3);
insert into IAMARKS(Usn,Sub_code,Ssid,Test1,Test2,Test3) values
('ai001','41',1,13,15,19),
('ai002','81',2,16,20,17),
('ai002','82',2,19,17,20),
('ai003','81',3,14,15,18),
('ai003','82',3,17,19,15),
('ai004','81',4,20,16,10),
('ai004','82',4,15,13,10);

select * from STUDENT;
select * from SEMSEC;
select * from CLASS;
select * from SUBJECT;
select * from IAMARKS;

/*  1  (no need of Phone in select )*/
SELECT s.Usn,s.Sname,s.Address,s.Phone,s.Gender
FROM STUDENT s,CLASS c,SEMSEC ss
where s.Usn = c.Usn and c.Ssid = ss.Ssid and ss.Sem = 4 AND ss.Sec = 'c';

/*  2  */
select Sem,Sec,Gender,count(*) as count
from STUDENT s, SEMSEC sc, CLASS c
where s.Usn = c.Usn and sc.Ssid = c.Ssid
group by Sem,Sec,Gender;
/* OR */
SELECT ss.Sem, ss.Sec,
	SUM(CASE WHEN s.Gender = 'M' THEN 1 ELSE 0 END) AS MaleCount,
	SUM(CASE WHEN s.Gender = 'F' THEN 1 ELSE 0 END) AS FemaleCount
FROM STUDENT s,CLASS c,SEMSEC ss
where s.USN = c.USN and c.SSID = ss.SSID
GROUP BY ss.Sem,ss.Sec;

/*  3  */
create view TEST1_MARKS as 
(select Usn,Test1,Sub_code 
from IAMARKS 
where Usn='ai001');

select * from TEST1_MARKS;

/*  4  */
UPDATE IAMARKS
SET Finalia = (CASE
                 WHEN Test1<greatest(Test1,Test2,Test3) AND Test1>least(Test1,Test2,Test3) THEN (greatest(Test1,Test2,Test3)+Test1)/2
                 WHEN Test2<greatest(Test1,Test2,Test3) AND Test2>least(Test1,Test2,Test3) THEN (greatest(Test1,Test2,Test3)+Test2)/2
                 ELSE (greatest(Test1,Test2,Test3)+Test3)/2
               END);
/* OR */
create table AVERAGE_FINDER
(
	select usn,sub_code,greatest(test1,test2,test3) as highest, 
	case
		when test1<greatest(Test1,Test2,Test3) and test1>least(Test1,Test2,Test3) then Test1
		when test2<greatest(Test1,Test2,Test3) and test2>least(Test1,Test2,Test3) then Test2
		else Test3
	end as second_highest from IAMARKS
);
select * from AVERAGE_FINDER;
update IAMARKS i set Finalia = (select (highest+second_highest)/2 from AVERAGE_FINDER
where i.usn=usn and i.sub_code=sub_code);

/*  5  */
select Usn,Sub_code, 
	case
		when Finalia>=17 and Finalia<=20 then 'Outstanding'
		when Finalia>=12 and Finalia<=16 then 'Average'
		when Finalia<12 then 'Weak'
	end as Category 
from IAMARKS
where Usn in (select Usn from SEMSEC sc,CLASS c where sc.Ssid=c.Ssid and Sem=8 and Sec in ('A','B','C'));

