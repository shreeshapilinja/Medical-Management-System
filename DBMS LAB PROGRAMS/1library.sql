/* drop database test027_LIBRARY; */
create database test027_LIBRARY;
use test027_LIBRARY;
create table PUBLISHER
(
	Name varchar(25),
	Address varchar(25),
	Phone bigint,
	primary key(Name)
);
create table BOOK
(
	Book_id int,
	Title varchar(25),
	Publisher_name varchar(25),
	Pub_year int,
	primary key(Book_id),
	foreign key(Publisher_name) references PUBLISHER(Name) on delete cascade
);
create table BOOK_AUTHORS
(
	Book_id int,
	Author_name varchar(25),
	primary key(Book_id),
	foreign key(Book_id) references BOOK(Book_id) on delete cascade
);
create table LIBRARY_BRANCH
(
	Branch_id int,
	Branch_name varchar(25),
	Address varchar(25),
	primary key(Branch_id)
);
create table BOOK_COPIES
(
	Book_id int,
	Branch_id int,
	No_of_copies int,
	primary key(Book_id,Branch_id),
	foreign key(Book_id) references BOOK(Book_id) on delete cascade,
	foreign key(Branch_id) references LIBRARY_BRANCH(Branch_id) on delete cascade
);
create table BOOK_LENDING
(
	Book_id int,
	Branch_id int,
	Card_no int,
	Date_out date,
	Due_date date,
	primary key(Book_id,Branch_id,Card_no),
	foreign key(Book_id) references BOOK(Book_id) on delete cascade,
	foreign key(Branch_id) references LIBRARY_BRANCH(Branch_id) on delete cascade
);

desc PUBLISHER;
desc BOOK;
desc BOOK_AUTHORS;
desc LIBRARY_BRANCH;
desc BOOK_COPIES;
desc BOOK_LENDING;

insert into PUBLISHER values
('a','a',12345),
('b','b',23456),
('c','c',34567);
insert into BOOK values
(1,'a','a',2001),
(2,'b','b',2005),
(3,'c','c',2010);
insert into BOOK_AUTHORS values
(1,'a'),
(2,'b'),
(3,'c');
insert into LIBRARY_BRANCH values
(1,'a','a'),
(2,'b','b');
insert into BOOK_COPIES values
(1,1,10),
(1,2,11),
(2,1,12),
(2,2,15);
insert into BOOK_LENDING values
(1,1,1,'2017-01-10','2017-06-10'),
(1,2,2,'2017-01-11','2017-06-11'),
(2,1,1,'2017-01-12','2017-06-12'),
(2,2,2,'2017-01-13','2017-06-13'),
(3,1,1,'2017-01-14','2017-06-14'),
(3,2,2,'2017-01-15','2017-06-15'),
(1,2,3,'2017-01-16','2017-06-16');

select * from PUBLISHER;
select * from BOOK;
select * from BOOK_AUTHORS;
select * from LIBRARY_BRANCH;
select * from BOOK_COPIES;
select * from BOOK_LENDING;

/*  1  */
select b.Book_id, b.Title, p.Name, ba.Author_Name, bc.No_of_Copies, l.Branch_Name
from BOOK b,PUBLISHER p,BOOK_AUTHORS ba,BOOK_COPIES bc,LIBRARY_BRANCH l
where b.Publisher_Name = p.Name and b.Book_id = ba.Book_id and b.Book_id = bc.Book_id and bc.Branch_id = l.Branch_id;

/*  2  */
select bl.Card_No, count(*) as Number_of_books
from BOOK_LENDING bl
where bl.Date_Out between '2017-01-01' and '2017-07-01'
group by bl.Card_No
having count(*) >= 3;

/*  3  */
delete from BOOK where Book_id = 3;

/*  4  */
create table PBOOK
(
	Book_id int,
	Title varchar(25),
	Publisher_name varchar(25),
	Pub_year int,
	primary key(Book_id,Pub_year)
)
partition by range (Pub_Year)
(
  partition p1 values less than (2002),
  partition p2 values less than (2006),
  partition p3 values less than (maxvalue)
);
insert into PBOOK values
(1,'a','a',2001),
(2,'b','b',2005),
(3,'c','c',2010);
select * from PBOOK partition(p1);
select * from PBOOK partition(p2);
select * from PBOOK partition(p3);

/*  5  */
create view available as
(
	select Book_id, sum(No_of_copies) - (select count(Card_no) from BOOK_LENDING where b.Book_id = Book_id) as avail_copies
	from BOOK_COPIES b
	group by Book_id
);
select * from available;