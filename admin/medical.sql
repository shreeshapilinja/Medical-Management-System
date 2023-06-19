-- drop database MEDICAL;
-- create database MEDICAL;
-- use MEDICAL;

/**************   creating tables  ***********************/

create table EMPLOYEE
(
    E_ID varchar(6) not NULL,
    E_Name varchar(30) not NULL,
    E_Mail varchar(40) not NULL,
    E_Phone decimal(10,0) not NULL,
    E_Role varchar(15) not NULL,
    E_Bdate date not NULL,
    E_Type varchar(15) not NULL,
    E_Jdate date not NULL,
    E_Sex varchar(6) not NULL,
    E_Salary int not NULL,
    E_Add varchar(40) not NULL,
    primary key(E_ID)
);

create table CUSTOMER
(
    C_ID varchar(6),
    C_Fname varchar(30) not NULL,
    C_Lname varchar(30) not NULL,
    C_Address varchar(30) not NULL,
    C_Age int(11) not NULL,
    C_Sex varchar(6) not NULL,
    C_Phone decimal(10,0) not NULL unique,
    C_Mail varchar(40) not NULL unique,
    primary key(C_ID)
);

create table SALES
(
    S_ID varchar(6),
    S_Date date not NULL,
    S_Time time not NULL, 
    Total_Amt int not NULL,
    C_ID varchar(6) not NULL,
    E_ID varchar(6) not NULL,
    primary key(S_ID),
    foreign key(E_ID) references EMPLOYEE(E_ID) on delete cascade,
    foreign key(C_ID) references CUSTOMER(C_ID) on delete cascade
);

create table MEDICINES
(
    Med_ID varchar(6),
    Med_Name varchar(50) not NULL,
    Med_Qty int(11) not NULL,
    Category varchar(20) not NULL,
    Med_Price int not NULL,
    Location_Rack varchar(30) not NULL,
    primary key(Med_ID)
);

create table SUPPLIERS
(
    Sup_ID varchar(6),
    Sup_Name varchar(30) not NULL,
    Sup_Mail varchar(40) not NULL,
    Sup_Phone decimal(10,0) not NULL,
    Sup_Add varchar(30) not NULL,
    primary key(Sup_ID)
);

create table PURCHASE
(
    P_ID varchar(6),
    Med_ID varchar(6) not NULL,
    Sup_ID varchar(6) not NULL,
    Pur_Date date not NULL,
    Mfg_Date date not NULL,
    Exp_Date date not NULL,
    P_Qty int(11) not NULL,
    P_Cost int not NULL,
    primary key(P_ID,Med_ID),
    foreign key(Med_ID) references MEDICINES(Med_ID) on delete cascade,
    foreign key(Sup_ID) references SUPPLIERS(Sup_ID) on delete cascade
);

create table SALES_ITEMS
(
    S_ID varchar(6) not NULL,
    Med_ID varchar(6) not NULL,
    Sale_Qty int(11) not NULL,
    Tot_Price int not NULL,
    primary key(S_ID,Med_ID),
    foreign key(S_ID) references SALES(S_ID) on delete cascade,
    foreign key(Med_ID) references MEDICINES(Med_ID) on delete cascade
);


/***  ALTERING THE TABLE  *****/

ALTER TABLE EMPLOYEE ADD COLUMN age INTEGER;

/*
UPDATE EMPLOYEE
SET age = EXTRACT(YEAR FROM CURDATE()) - EXTRACT(YEAR FROM E_Bdate)
     - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(E_Bdate, '%m%d'));
*/

/**************   TRIGGERS  ***********/

DELIMITER //
CREATE TRIGGER neg_total_amt
BEFORE INSERT ON SALES
FOR EACH ROW
BEGIN
  IF NEW.Total_Amt < 0 THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Total amount cannot be negative';
  END IF;
END;//
DELIMITER ;

DELIMITER $$
CREATE TRIGGER check_negative_total_amount 
BEFORE UPDATE ON SALES
FOR EACH ROW
BEGIN
  IF NEW.Total_Amt < 0 THEN
    SIGNAL SQLSTATE '45000' 
	SET MESSAGE_TEXT = 'Cannot update with negative Total_Amt value';
  END IF;
END$$
DELIMITER ;


DELIMITER //
CREATE TRIGGER update_age_on_insert
BEFORE INSERT ON EMPLOYEE
FOR EACH ROW
BEGIN
    SET NEW.age = EXTRACT(YEAR FROM CURDATE()) - EXTRACT(YEAR FROM NEW.E_Bdate)
         - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(NEW.E_Bdate, '%m%d'));
END;//
DELIMITER ;


DELIMITER //
CREATE TRIGGER check_purchase_quantity_cost_insert 
BEFORE INSERT ON PURCHASE
FOR EACH ROW
BEGIN
    IF (NEW.P_Qty < 0 OR NEW.P_Cost < 0) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Purchase quantity and cost cannot be negative.';
    END IF;
END;//
DELIMITER ;

DELIMITER //
CREATE TRIGGER check_purchase_quantity_cost_update
BEFORE UPDATE ON PURCHASE
FOR EACH ROW
BEGIN
    IF (NEW.P_Qty < 0 OR NEW.P_Cost < 0) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Purchase quantity and cost cannot be negative.';
    END IF;
END;//
DELIMITER ;

DELIMITER $$
CREATE TRIGGER check_medicine_quantity_price_insert
BEFORE INSERT ON MEDICINES
FOR EACH ROW
BEGIN
    IF (NEW.Med_Qty < 0 OR NEW.Med_Price < 0) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Medicine quantity and price cannot be negative.';
    END IF;
END$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER check_medicine_quantity_price_update
BEFORE UPDATE ON MEDICINES
FOR EACH ROW
BEGIN
    IF (NEW.Med_Qty < 0 OR NEW.Med_Price < 0) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Medicine quantity and price cannot be negative.';
    END IF;
END$$
DELIMITER ;



/* 
DELIMITER //
CREATE TRIGGER tr_upd_sales_item 
AFTER INSERT ON SALES_ITEMS
FOR EACH ROW
BEGIN
  UPDATE MEDICINES
  SET Med_Qty = Med_Qty - NEW.Sale_Qty
  WHERE Med_ID = NEW.Med_ID;
END //
DELIMITER ;
*/

/********** creating view invoice   *****/

CREATE VIEW INVOICES AS
SELECT s.S_ID AS S_ID, c.C_Fname AS C_Fname, c.C_Lname AS C_Lname, s.S_Date AS S_Date, s.Total_Amt AS Total_Amt
FROM SALES s
JOIN CUSTOMER c ON s.C_ID = c.C_ID;


/*****  stored procedure  
CREATE PROCEDURE add_customer
(
   IN p_cid VARCHAR(6),
   IN p_cfname VARCHAR(30),
   IN p_clname VARCHAR(30),
   IN p_caddress VARCHAR(30),
   IN p_cage INT(11),
   IN p_csex VARCHAR(6),
   IN p_cphone DECIMAL(10,0),
   IN p_cmail VARCHAR(40)
)
BEGIN
   INSERT INTO CUSTOMER (C_ID, C_Fname, C_Lname, C_Address, C_Age, C_Sex, C_Phone, C_Mail)
   VALUES (p_cid, p_cfname, p_clname, p_caddress, p_cage, p_csex, p_cphone, p_cmail);
END;
******/


/*****  inserting values to the table  ******/

insert into EMPLOYEE (E_ID, E_Name, E_Mail, E_Phone, E_Role, E_Bdate, E_Type, E_Jdate, E_Sex, E_Salary, E_Add) values
('E1', 'John Smith', 'john.smith@gmail.com', '9876543210', 'Manager', '1995-01-01', 'Full-time', '2021-01-01', 'Male', '50000', '123 Main St'),
('E2', 'Alice Williams', 'alice.williams@gmail.com', '9876543211', 'Pharmacist', '1996-02-14', 'Part-time', '2021-02-01', 'Female', '40000', '456 Main St'),
('E3', 'Bob Johnson', 'bob.johnson@gmail.com', '9876543212', 'Receptionist', '1997-03-15', 'Full-time', '2021-03-01', 'Male', '30000', '789 Main St'),
('E4', 'Samantha Brown', 'samantha.brown@gmail.com', '9876543213', 'Pharmacist', '1998-04-16', 'Full-time', '2021-04-01', 'Female', '40000', '321 Main St'),
('E5', 'James Davis', 'james.davis@gmail.com', '9876543214', 'Receptionist', '1999-05-17', 'Part-time', '2022-01-01', 'Male', '30000', '654 Main St');

insert into CUSTOMER (C_ID, C_Fname, C_Lname, C_Address, C_Age, C_Sex, C_Phone, C_Mail) values
('C1', 'Sarah', 'Johnson', '123 Main St', '35', 'Female', '9876543210', 'sarah.johnson@gmail.com'),
('C2', 'Michael', 'Williams', '456 Main St', '40', 'Male', '9876543211', 'michael.williams@gmail.com'),
('C3', 'Emily', 'Brown', '789 Main St', '38', 'Female', '9876543212', 'emily.brown@gmail.com'),
('C4', 'David', 'Smith', '321 Main St', '42', 'Male', '9876543213', 'david.smith@gmail.com'),
('C5', 'Jessica', 'Jones', '654 Main St', '35', 'Female', '9876543214', 'jessica.jones@gmail.com');

insert into SALES (S_ID, S_Date, S_Time, Total_Amt, C_ID, E_ID) values
('S1', '2021-01-05', '10:00:00', '100', 'C1', 'E1'),
('S2', '2021-02-08', '11:00:00', '200', 'C2', 'E2'),
('S3', '2021-02-15', '12:00:00', '300', 'C3', 'E3'),
('S4', '2022-01-04', '13:00:00', '400', 'C4', 'E4'),
('S5', '2022-02-05', '14:00:00', '500', 'C5', 'E5');

insert into MEDICINES (Med_ID, Med_Name, Med_Qty, Category, Med_Price, Location_Rack) values
('M1', 'Aspirin', '100', 'Pain Relief', '10', 'A1'),
('M2', 'Ibuprofen', '200', 'Pain Relief', '20', 'A2'),
('M3', 'Acetaminophen', '300', 'Pain Relief', '30', 'A3'),
('M4', 'Amoxicillin', '400', 'Antibiotic', '40', 'A4'),
('M5', 'Ciprofloxacin', '0', 'Antibiotic', '50', 'A5');

insert into SUPPLIERS (Sup_ID, Sup_Name, Sup_Mail, Sup_Phone, Sup_Add) values
('SU1', 'Acme Pharmaceuticals', 'acme@gmail.com', '9876543210', '123 Main St'),
('SU2', 'XYZ Inc.', 'xyz@gmail.com', '9876543211', '456 Main St'),
('SU3', 'ABC Corp.', 'abc@gmail.com', '9876543212', '789 Main St'),
('SU4', 'Definite Drugs', 'definite@gmail.com', '9876543213', '321 Main St'),
('SU5', 'GHC Limited', 'ghc@gmail.com', '9876543214', '654 Main St');

insert into PURCHASE (P_ID, Med_ID, Sup_ID, Pur_Date, Mfg_Date, Exp_Date, P_Qty, P_Cost) values
('P1', 'M1', 'SU1', '2021-01-01', '2020-03-01', '2022-04-01', '100', '100'),
('P2', 'M2', 'SU2', '2021-01-02', '2020-04-02', '2022-02-02', '200', '200'),
('P3', 'M3', 'SU3', '2021-01-03', '2021-03-01', '2024-01-03', '300', '300'),
('P4', 'M4', 'SU4', '2022-01-04', '2021-01-04', '2025-01-04', '400', '400'),
('P5', 'M5', 'SU5', '2022-01-05', '2021-01-05', '2024-01-05', '500', '500');

insert into SALES_ITEMS (S_ID, Med_ID, Sale_Qty, Tot_Price) values
('S1', 'M1', '10', '100'),
('S1', 'M2', '20', '200'),
('S2', 'M3', '30', '300'),
('S2', 'M4', '40', '400'),
('S3', 'M5', '50', '500'),
('S4', 'M1', '60', '600'),
('S4', 'M2', '70', '700'),
('S5', 'M3', '80', '800'),
('S5', 'M4', '90', '900'),
('S5', 'M5', '100', '999');



