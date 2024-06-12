/* drop database test027_ORDER; */
create database test027_ORDER;
use test027_ORDER;
create table SALESMAN
(
	Salesman_id int,
	Name  varchar(25),
	City  varchar(25),
	Commission int,
	primary key(Salesman_id)
);
create table CUSTOMER
(
	Customer_id int,
	Cust_name varchar(25),
	City  varchar(25),
	Grade int,
	Salesman_id int,
	primary key(Customer_id),
	foreign key(Salesman_id) references SALESMAN(Salesman_id) on delete cascade
);
create table ORDERS
(
	Ord_no int, 
	Purchase_amt int,
	Ord_date date, 
	Customer_id int, 
	Salesman_id int, 
	primary key(Ord_no),
	foreign key(Customer_id) references CUSTOMER(Customer_id) on delete cascade, 
	foreign key(Salesman_id) references SALESMAN(Salesman_id) on delete cascade
);

desc SALESMAN;
desc CUSTOMER;
desc ORDERS;

insert into SALESMAN values
(1,'a','a',1),
(2,'b','b',2),
(3,'c','c',3);
insert into CUSTOMER values
(1,'a','d',1,1),
(2,'b','b',2,2),
(3,'c','c',3,1),
(4,'d','d',4,2),
(5,'d','d',3,3);
insert into ORDERS values
(1,100,'2020-01-01',1,1),
(2,200,'2020-01-01',1,2),
(3,300,'2020-01-02',2,1),
(4,400,'2020-01-02',2,2),
(5,500,'2020-01-03',3,1),
(6,600,'2020-01-03',3,2),
(7,700,'2020-01-04',4,1),
(8,600,'2020-01-04',4,2);

select * from SALESMAN;
select * from CUSTOMER;
select * from ORDERS;

/*  1  b = Bangalore  count = 2(c,d has more)*/
select count(*)
from CUSTOMER
where Grade > (select avg(Grade) from CUSTOMER where City = 'b');

/* 2 */
select Salesman_id,Name
from SALESMAN
where Salesman_id in (select Salesman_id from CUSTOMER group by Salesman_id having count(*) > 1);

/* 3 */
select s.Name,'exists' as Same_city 
from SALESMAN s
where City in (select City from CUSTOMER where s.Salesman_id= Salesman_id) 
union 
select Name,'not exists' as Same_city 
from SALESMAN s 
where City not in (select City from CUSTOMER where s.Salesman_id = Salesman_id);

/* 4  (aa dina yarige heccu amount got)*/
create view Highest_order as 
select s.Salesman_id,s.Name,o.Purchase_amt,o.Ord_date
from SALESMAN s,ORDERS o
where s.Salesman_id = o.Salesman_id;

select Name,Ord_date
from Highest_order h
where Purchase_amt = (select max(Purchase_amt) from Highest_order where h.Ord_date = Ord_date);

/* 5 */
delete from SALESMAN where Salesman_id=3;

select * from SALESMAN;
select * from CUSTOMER;
select * from ORDERS;