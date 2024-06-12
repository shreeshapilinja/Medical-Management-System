/* drop database test027_COMPANY; */
create database test027_COMPANY;
use test027_COMPANY;
create table DEPARTMENT
(
	Dno int,
	Dname varchar(25),
	Mgrssn int,
	Mgrstartdate date,
	primary key(Dno)
);
create table EMPLOYEE
(
	Ssn int,
	Name varchar(25),
	Address varchar(25),
	Sex varchar(6),
	Salary int,
	Superssn int,
	Dno int,
	primary key(Ssn)
);
create table DLOCATION
(
	Dno int,
	Dloc varchar(25),
	primary key (Dno,Dloc),
	foreign key(Dno) references DEPARTMENT(Dno) on delete cascade
);
create table PROJECT
(
	Pno int,
	Pname varchar(25),
	Plocation varchar(25),
	Dno int,
	primary key(Pno),
	foreign key(Dno) references DEPARTMENT(Dno) on delete cascade
);
create table WORKS_ON
(
	Ssn int,
	Pno int,
	Hours int,
	primary key(Ssn,Pno),
	foreign key(Ssn) references EMPLOYEE(Ssn) on delete cascade,
	foreign key(Pno) references PROJECT(Pno) on delete cascade
);

desc DEPARTMENT;
desc EMPLOYEE;
desc DLOCATION;
desc PROJECT;
desc WORKS_ON;

insert into DEPARTMENT values
(1,'a',1,'2017-01-01'),
(2,'b',2,'2017-01-02');
insert into EMPLOYEE values
(1,'a scott','a','m',500000,1,1),
(2,'b','b','m',560000,2,2),
(3,'c','c','m',600000,1,1),
(4,'d','d','m',620000,2,2),
(5,'e','e','m',640000,2,2),
(6,'f','f','m',670000,2,2),
(7,'g','g','m',700000,2,2);
insert into DLOCATION values
(1,'a'),
(1,'b'),
(2,'b'),
(2,'c');
insert into PROJECT values
(1,'iot','a',1),
(2,'b','b',2),
(3,'c','c',1),
(4,'d','d',2);
insert into WORKS_ON values
(1,1,9),
(2,1,12),
(3,1,15),
(4,1,18),
(5,1,15),
(6,2,18),
(1,2,12),
(1,4,12);

alter table DEPARTMENT add foreign key(MgrSSN) references EMPLOYEE(SSN) on delete cascade;
alter table EMPLOYEE add foreign key(SuperSSN) references EMPLOYEE(SSN) on delete cascade;
alter table EMPLOYEE add foreign key(DNo) references DEPARTMENT(DNo) on delete cascade;

/*alter table WORKS_ON add foreign key(SSN) references EMPLOYEE(SSN) on delete cascade;
alter table WORKS_ON add foreign key(PNo) references PROJECT(PNo) on delete cascade;
alter table PROJECT add foreign key(DNo) references DEPARTMENT(DNo) on delete cascade;
alter table DLOCATION add foreign key(DNo) references DEPARTMENT(DNo) on delete cascade;*/

select * from DEPARTMENT;
select * from EMPLOYEE;
select * from DLOCATION;
select * from PROJECT;
select * from WORKS_ON;

/*  1  */
select Pno
from PROJECT p,DEPARTMENT d,EMPLOYEE e
where p.Dno = d.Dno and e.Ssn = d.Mgrssn and e.Name LIKE '%scott'
UNION
select Pno
from WORKS_ON w,EMPLOYEE e
where w.Ssn = e.Ssn and e.Name LIKE '%scott';
/*  OR  */
select distinct Pno 
from PROJECT 
where Pno in (select Pno from PROJECT p,DEPARTMENT d,EMPLOYEE e where p.Dno = d.Dno and d.Mgrssn = e.Ssn and Name like '%scott') 
or Pno in (select Pno from WORKS_ON w, EMPLOYEE e where w.Ssn = e.Ssn and Name like '%scott');

/*  2  */
select e.Name, e.Salary * 1.1 AS Newsalary
FROM EMPLOYEE e,WORKS_ON w,PROJECT p
where e.Ssn = w.Ssn and w.Pno = p.Pno and p.Pname = 'ioT';
/*  OR  */
select e.Name, e.Salary*1.1 as new_salary 
from EMPLOYEE e, WORKS_ON w
where e.Ssn = w.Ssn and w.Pno in (select Pno from PROJECT where Pname ='ioT');

/*  3  a = accountant */
select sum(Salary), max(Salary), min(Salary), avg(Salary) 
from EMPLOYEE e,DEPARTMENT d
where d.Dno = e.Dno and d.Dname = 'a';
/*  OR  */
SELECT SUM(e.Salary) AS TotalSalary, MAX(e.Salary) AS MaxSalary, MIN(e.Salary) AS MinSalary, AVG(e.Salary) AS AverageSalary
FROM EMPLOYEE e
JOIN DEPARTMENT d ON e.DNo = d.DNo
WHERE d.DName = 'a';

/*  4  */
select e.Name 
from EMPLOYEE e
where not exists(select Pno from PROJECT where Dno='5' and Pno not in (select Pno from WORKS_ON where e.Ssn=Ssn));
/*  OR  */
SELECT e.Name 
FROM EMPLOYEE e
WHERE NOT EXISTS (SELECT 1 FROM PROJECT p WHERE p.DNo = 5 
AND NOT EXISTS (SELECT 1 FROM WORKS_ON w WHERE w.SSN = e.SSN AND w.PNo = p.PNo));
/*  This is often used as a convenient way to include a subquery in the WHERE clause of a SELECT statement, 
when the subquery itself does not need to return any specific values. */

/*  5  ( > is made as >= )*/
select d.Dno,count(*) as count 
from DEPARTMENT d,EMPLOYEE e
where d.DNo= e.DNo and Salary >600000 and d.DNo in (select DNo from EMPLOYEE group by DNo having count(*)>= 5)
group by d.DNo;

