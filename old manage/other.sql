insert into EMPLOYEE (E_ID, E_Name, E_Mail, E_Phone, E_Role, E_Bdate, E_Type, E_Jdate, E_Sex, E_Salary, E_Add) values
('E1', 'John Smith', 'john.smith@gmail.com', '9876543210', 'Manager', '1995-01-01', 'Full-time', '2020-01-01', 'Male', '50000', '123 Main St'),
('E2', 'Alice Williams', 'alice.williams@gmail.com', '9876543211', 'Pharmacist', '1996-02-14', 'Part-time', '2020-02-01', 'Female', '40000', '456 Main St'),
('E3', 'Bob Johnson', 'bob.johnson@gmail.com', '9876543212', 'Receptionist', '1997-03-15', 'Full-time', '2020-03-01', 'Male', '30000', '789 Main St'),
('E4', 'Samantha Brown', 'samantha.brown@gmail.com', '9876543213', 'Pharmacist', '1998-04-16', 'Full-time', '2020-04-01', 'Female', '40000', '321 Main St'),
('E5', 'James Davis', 'james.davis@gmail.com', '9876543214', 'Receptionist', '1999-05-17', 'Part-time', '2020-05-01', 'Male', '30000', '654 Main St');

insert into CUSTOMER (C_ID, C_Fname, C_Lname, C_Address, C_Age, C_Sex, C_Phone, C_Mail) values
('C1', 'Sarah', 'Johnson', '123 Main St', '35', 'Female', '9876543210', 'sarah.johnson@gmail.com'),
('C2', 'Michael', 'Williams', '456 Main St', '40', 'Male', '9876543211', 'michael.williams@gmail.com'),
('C3', 'Emily', 'Brown', '789 Main St', '38', 'Female', '9876543212', 'emily.brown@gmail.com'),
('C4', 'David', 'Smith', '321 Main St', '42', 'Male', '9876543213', 'david.smith@gmail.com'),
('C5', 'Jessica', 'Jones', '654 Main St', '35', 'Female', '9876543214', 'jessica.jones@gmail.com');

insert into SALES (S_ID, S_Date, S_Time, Total_Amt, C_ID, E_ID) values
('S1', '2022-01-01', '10:00:00', '100', 'C1', 'E1'),
('S2', '2022-01-02', '11:00:00', '200', 'C2', 'E2'),
('S3', '2022-01-03', '12:00:00', '300', 'C3', 'E3'),
('S4', '2022-01-04', '13:00:00', '400', 'C4', 'E4'),
('S5', '2022-01-05', '14:00:00', '500', 'C5', 'E5');

insert into MEDICINES (Med_ID, Med_Name, Med_Qty, Category, Med_Price, Location_Rack) values
('M1', 'Aspirin', '100', 'Pain Relief', '10', 'A1'),
('M2', 'Ibuprofen', '200', 'Pain Relief', '20', 'A2'),
('M3', 'Acetaminophen', '300', 'Pain Relief', '30', 'A3'),
('M4', 'Amoxicillin', '400', 'Antibiotic', '40', 'A4'),
('M5', 'Ciprofloxacin', '500', 'Antibiotic', '50', 'A5');

insert into SUPPLIERS (Sup_ID, Sup_Name, Sup_Mail, Sup_Phone, Sup_Add) values
('SU1', 'Acme Pharmaceuticals', 'acme@gmail.com', '9876543210', '123 Main St'),
('SU2', 'XYZ Inc.', 'xyz@gmail.com', '9876543211', '456 Main St'),
('SU3', 'ABC Corp.', 'abc@gmail.com', '9876543212', '789 Main St'),
('SU4', 'Definite Drugs', 'definite@gmail.com', '9876543213', '321 Main St'),
('SU5', 'GHC Limited', 'ghc@gmail.com', '9876543214', '654 Main St');

insert into PURCHASE (P_ID, Med_ID, Sup_ID, Pur_Date, Mfg_Date, Exp_Date, P_Qty, P_Cost) values
('P1', 'M1', 'SU1', '2021-01-01', '2020-03-01', '2022-04-01', '100', '1000'),
('P2', 'M2', 'SU2', '2021-01-02', '2020-04-02', '2022-02-02', '200', '2000'),
('P3', 'M3', 'SU3', '2022-01-03', '2021-01-03', '2023-01-03', '300', '3000'),
('P4', 'M4', 'SU4', '2022-01-04', '2021-01-04', '2023-01-04', '400', '4000'),
('P5', 'M5', 'SU5', '2022-01-05', '2021-01-05', '2023-01-05', '500', '5000');

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
('S5', 'M5', '100', '1000');

/* 
UPDATE EMPLOYEE
SET age = FLOOR(DATEDIFF(CURDATE(), E_Bdate) / 365);
-- OR 
*/


/*        Functions         */

-- This code creates a MySQL stored function named P_AMT that calculates the total cost of purchases made within a specified date range. The function takes two parameters: start and end, which represent the start and end dates of the date range. The function uses a SELECT statement to sum the P_COST column from the PURCHASE table for all purchases made within the specified date range. The result of the SELECT statement is stored in a local variable named PAMT, and the function returns the value of this variable.

-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` FUNCTION `P_AMT`(`start` DATE, `end` DATE) RETURNS decimal(8,2)
--     NO SQL
--     DETERMINISTIC
-- BEGIN
-- DECLARE PAMT DECIMAL(8,2) DEFAULT 0.0;
-- SELECT SUM(P_COST) INTO PAMT FROM PURCHASE WHERE PUR_DATE >= start AND PUR_DATE<= end;
-- RETURN PAMT;
-- END$$
-- DELIMITER ;


-- This code creates a MySQL stored function named S_AMT that calculates the total amount of sales made within a specified date range. The function takes two parameters: start and end, which represent the start and end dates of the date range. The function uses a SELECT statement to sum the TOTAL_AMT column from the SALES table for all sales made within the specified date range. The result of the SELECT statement is stored in a local variable named SAMT, and the function returns the value of this variable.

-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` FUNCTION `S_AMT`(`start` DATE, `end` DATE) RETURNS decimal(8,2)
--     NO SQL
-- BEGIN
-- DECLARE SAMT DECIMAL(8,2) DEFAULT 0.0;
-- SELECT SUM(TOTAL_AMT) INTO SAMT FROM SALES WHERE S_DATE >= start AND S_DATE<= end;
-- RETURN SAMT;
-- END$$
-- DELIMITER ;



/*   procedures   */

-- This code creates a MySQL stored procedure named EXPIRY that retrieves a list of purchase records that are due to expire within the next six months. The procedure uses a SELECT statement to retrieve the p_id, sup_id, med_id, p_qty, p_cost, pur_date, mfg_date, and exp_date columns from the PURCHASE table, where the exp_date is between the current date and six months in the past. This will return all purchase records with an expiration date within the next six months. The results of the SELECT statement are not stored or returned in any way; they are simply displayed to the user who called the procedure.

-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `EXPIRY`()
--     NO SQL
-- BEGIN
-- SELECT p_id,sup_id,med_id,p_qty,p_cost,pur_date,mfg_date,exp_date FROM purchase where exp_date between CURDATE() and DATE_SUB(CURDATE(), INTERVAL -6 MONTH);
-- END$$
-- DELIMITER ;



-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `SEARCH_INVENTORY`(IN `search` VARCHAR(255))
--     NO SQL
-- BEGIN
-- DECLARE mid DECIMAL(6);
-- DECLARE mname VARCHAR(50);
-- DECLARE mqty INT;
-- DECLARE mcategory VARCHAR(20);
-- DECLARE mprice DECIMAL(6,2);
-- DECLARE location VARCHAR(30);
-- DECLARE exit_loop BOOLEAN DEFAULT FALSE;
-- DECLARE MED_CURSOR CURSOR FOR SELECT MED_ID,MED_NAME,MED_QTY,CATEGORY,MED_PRICE,LOCATION_RACK FROM MEDS;
-- DECLARE CONTINUE HANDLER FOR NOT FOUND SET exit_loop=TRUE;
-- CREATE TEMPORARY TABLE IF NOT EXISTS T1 (medid decimal(6),medname varchar(50),medqty int,medcategory varchar(20),medprice decimal(6,2),medlocation varchar(30));
-- OPEN MED_CURSOR;
-- med_loop: LOOP
-- FETCH FROM MED_CURSOR INTO mid,mname,mqty,mcategory,mprice,location;
-- IF exit_loop THEN
-- LEAVE med_loop;
-- END IF;

-- IF(CONCAT(mid,mname,mcategory,location) LIKE CONCAT('%',search,'%')) THEN
-- INSERT INTO T1(medid,medname,medqty,medcategory,medprice,medlocation)
-- VALUES(mid,mname,mqty,mcategory,mprice,location);
-- END IF;
-- END LOOP med_loop;
-- CLOSE MED_CURSOR;
-- SELECT medid,medname,medqty,medcategory,medprice,medlocation FROM T1; 
-- END$$
-- DELIMITER ;




-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `STOCK`()
--     NO SQL
-- BEGIN
-- SELECT med_id, med_name,med_qty,category,med_price,location_rack FROM meds where med_qty<=50;
-- END$$
-- DELIMITER ;




-- DELIMITER $$
-- CREATE DEFINER=`root`@`localhost` PROCEDURE `TOTAL_AMT`(IN `ID` INT, OUT `AMT` DECIMAL(8,2))
--     NO SQL
-- BEGIN
-- UPDATE SALES SET S_DATE=SYSDATE(),S_TIME=CURRENT_TIMESTAMP(),TOTAL_AMT=(SELECT SUM(TOT_PRICE) FROM SALES_ITEMS WHERE SALES_ITEMS.SALE_ID=ID) WHERE SALES.SALE_ID=ID;
-- SELECT TOTAL_AMT INTO AMT FROM SALES WHERE SALE_ID=ID;
-- END$$
-- DELIMITER ;
/*
insert into EMPLOYEE values (1, 'John Doe', 'johndoe@gmail.com', 9876543210, 'Manager', '1990-01-01', 'Full-time', '2020-01-01', 'Male', 100000, '123 Main St.');
insert into EMPLOYEE values (2, 'Jane Smith', 'janesmith@gmail.com', 1234567890, 'Clerk', '1995-01-01', 'Part-time', '2020-01-01', 'Female', 50000, '456 Park Ave.');
insert into EMPLOYEE values (3, 'Bob Johnson', 'bobjohnson@gmail.com', 9876543211, 'Manager', '1985-01-01', 'Full-time', '2020-01-01', 'Male', 90000, '789 Broad St.');
insert into EMPLOYEE values (4, 'Alice Williams', 'alicewilliams@gmail.com', 1234567891, 'Clerk', '2000-01-01', 'Part-time', '2020-01-01', 'Female', 45000, '321 Oak St.');
insert into EMPLOYEE values (5, 'Michael Brown', 'michaelbrown@gmail.com', 9876543212, 'Manager', '1995-01-01', 'Full-time', '2020-01-01', 'Male', 75000, '159 Maple St.');


-- insert into CUSTOMER values ('C001','vijay','kumar','kodagu',60,'Male','8996574123','vijayk@yahoo.com');

insert into CUSTOMER values (1, 'John', 'Doe', '123 Main St.', 30, 'Male', 9876543210, 'johndoe@gmail.com');
insert into CUSTOMER values (2, 'Jane', 'Smith', '456 Park Ave.', 25, 'Female', 1234567890, 'janesmith@gmail.com');
insert into CUSTOMER values (3, 'Bob', 'Johnson', '789 Broad St.', 35, 'Male', 9876543211, 'bobjohnson@gmail.com');
insert into CUSTOMER values (4, 'Alice', 'Williams', '321 Oak St.', 20, 'Female', 1234567891, 'alicewilliams@gmail.com');
insert into CUSTOMER values (5, 'Michael', 'Brown', '159 Maple St.', 40, 'Male', 9876543212, 'michaelbrown@gmail.com');

-- insert into SALES values ('S001','2009-04-15','13:23:03',180,'C001','E001');

insert into SALES values (1, '2022-12-11', '13:30:00', 100, 1, 2);
insert into SALES values (2, '2022-12-11', '14:00:00', 150, 2, 3);
insert into SALES values (3, '2022-12-11', '14:30:00', 200, 3, 4);
insert into SALES values (4, '2022-12-11', '15:00:00', 250, 4, 5);
insert into SALES values (5, '2022-12-10', '16:00:00', 200, 4, 5);

-- insert into MEDICINES values ('M001','Dolo 650 MG',200,'Tablet',2,'rack 5');

insert into MEDICINES values (1, 'Ibuprofen', 100, 'Pain relief', 10, 'A1');
insert into MEDICINES values (2, 'Aspirin', 50, 'Pain relief', 15, 'A2');
insert into MEDICINES values (3, 'Amoxicillin', 75, 'Antibiotic', 20, 'B1');
insert into MEDICINES values (4, 'Tylenol', 120, 'Pain relief', 12, 'B2');
insert into MEDICINES values (5, 'Metformin', 200, 'Diabetes', 25, 'C1');

-- insert into SUPPLIERS values ('SUP001','XYZ Pharmaceuticals','xyz@xyzpharma.com','8745632145','Chennai, Tamil Nadu');

insert into SUPPLIERS values (1, 'Acme Inc.', 'acme@gmail.com', 9876543210, '123 Main St.');
insert into SUPPLIERS values (2, 'Smith Corp.', 'smithcorp@gmail.com', 1234567890, '456 Park Ave.');
insert into SUPPLIERS values (3, 'Johnson Enterprises', 'johnsonenterprises@gmail.com', 9876543211, '789 Broad St.');
insert into SUPPLIERS values (4, 'Williams Inc.', 'williamsinc@gmail.com', 1234567891, '321 Oak St.');
insert into SUPPLIERS values (5, 'Brown Pharmacy', 'brownpharmacy@gmail.com', 9876543212, '159 Maple St.');

-- insert into PURCHASE values ('P001','M001','SUP001','2008-09-20','2008-05-11','2009-09-15',200,200);

insert into PURCHASE values (1, 1, 1, '2022-12-11', '2022-09-01', '2025-08-31', 50, 500);
insert into PURCHASE values (2, 2, 2, '2022-12-11', '2022-10-01', '2025-09-30', 25, 375);
insert into PURCHASE values (3, 3, 3, '2022-12-11', '2022-11-01', '2025-10-31', 20, 400);
insert into PURCHASE values (4, 4, 4, '2022-12-11', '2022-12-01', '2025-11-30', 15, 180);
insert into PURCHASE values (5, 5, 5, '2022-12-11', '2022-01-01', '2026-12-31', 10, 250);

-- insert into SALES_ITEMS values ('S001','M001',180,360);

insert into SALES_ITEMS values (1, 1, 2, 20);
insert into SALES_ITEMS values (2, 2, 1, 15);
insert into SALES_ITEMS values (3, 3, 2, 40);
insert into SALES_ITEMS values (4, 4, 3, 36);
insert into SALES_ITEMS values (5, 5, 1, 25);



INSERT INTO EMPLOYEE (E_ID, E_Name, E_Mail, E_Phone, E_Role, E_Bdate, E_Type, E_Jdate, E_Sex, E_Salary, E_Add) VALUES
('E001', 'John Smith', 'john.smith@gmail.com', 1234567890, 'Manager', '1980-01-01', 'Full-time', '2020-01-01', 'Male', 100000, '123 Main St.'),
('E002', 'Jane Doe', 'jane.doe@gmail.com', 1234567891, 'Clerk', '1985-02-01', 'Part-time', '2020-02-01', 'Female', 50000, '456 Main St.'),
('E003', 'Bob Johnson', 'bob.johnson@gmail.com', 1234567892, 'Manager', '1990-03-01', 'Full-time', '2020-03-01', 'Male', 80000, '789 Main St.'),
('E004', 'Samantha Williams', 'samantha.williams@gmail.com', 1234567893, 'Clerk', '1995-04-01', 'Part-time', '2020-04-01', 'Female', 60000, '246 Main St.'),
('E005', 'Mike Thompson', 'mike.thompson@gmail.com', 1234567894, 'Manager', '2000-05-01', 'Full-time', '2020-05-01', 'Male', 90000, '369 Main St.'),
('E006', 'Emily Davis', 'emily.davis@gmail.com', 1234567895, 'Clerk', '2005-06-01', 'Part-time', '2020-06-01', 'Female', 55000, '159 Main St.');

INSERT INTO CUSTOMER (C_ID, C_Fname, C_Lname, C_Address, C_Age, C_Sex, C_Phone, C_Mail) VALUES
('C001', 'John', 'Smith', '123 Main St.', 35, 'Male', 1234567890, 'john.smith@gmail.com'),
('C002', 'Jane', 'Doe', '456 Main St.', 30, 'Female', 1234567891, 'jane.doe@gmail.com'),
('C003', 'Bob', 'Johnson', '789 Main St.', 25, 'Male', 1234567892, 'bob.johnson@gmail.com'),
('C004', 'Samantha', 'Williams', '246 Main St.', 20, 'Female', 1234567893, 'samantha.williams@gmail.com'),
('C005', 'Mike', 'Thompson', '369 Main St.', 45, 'Male', 1234567894, 'mike.thompson@gmail.com'),
('C006', 'Emily', 'Davis', '159 Main St.', 40, 'Female', 1234567895, 'emily.davis@gmail.com'),
('C007', 'James', 'Brown', '753 Main St.', 35, 'Male', 1234567896, 'james.brown@gmail.com'),
('C008', 'Emma', 'Jones', '147 Main St.', 30, 'Female', 1234567897, 'emma.jones@gmail.com'),
('C009', 'William', 'Smith', '753 Main St.', 25, 'Male', 1234567898, 'william.smith@gmail.com'),
('C010', 'Olivia', 'Johnson', '369 Main St.', 20, 'Female', 1234567899, 'olivia.johnson@gmail.com'),
('C011', 'Jacob', 'Williams', '159 Main St.', 35, 'Male', 1234567800, 'jacob.williams@gmail.com'),
('C012', 'Isabella', 'Davis', '246 Main St.', 40, 'Female', 1234567801, 'isabella.davis@gmail.com');

INSERT INTO SALES (S_ID, S_Date, S_Time, Total_Amt, C_ID, E_ID) VALUES
('S001', '2022-01-01', '10:00:00', 100, 'C001', 'E001'),
('S002', '2022-01-02', '11:00:00', 200, 'C002', 'E002'),
('S003', '2022-01-03', '12:00:00', 300, 'C003', 'E003'),
('S004', '2022-01-04', '13:00:00', 400, 'C004', 'E004'),
('S005', '2022-01-05', '14:00:00', 500, 'C005', 'E005'),
('S006', '2022-01-06', '15:00:00', 600, 'C006', 'E006'),
('S007', '2022-01-07', '16:00:00', 700, 'C007', 'E001');

INSERT INTO MEDICINES (Med_ID, Med_Name, Med_Qty, Category, Med_Price, Location_Rack) VALUES
('M001', 'Paracetamol', 100, 'Pain Relief', 10, 'A1'),
('M002', 'Ibuprofen', 200, 'Pain Relief', 20, 'A2'),
('M003', 'Acetaminophen', 300, 'Pain Relief', 30, 'A3'),
('M004', 'Amoxicillin', 400, 'Antibiotic', 40, 'A4');

INSERT INTO SUPPLIERS (Sup_ID, Sup_Name, Sup_Mail, Sup_Phone, Sup_Add) VALUES
('SU001', 'John Supplier', 'john@gmail.com', 1234567890, '123 Main St.'),
('SU002', 'Jane Supplier', 'jane@gmail.com', 1234567891, '456 Main St.'),
('SU003', 'Michael Supplier', 'michael@gmail.com', 1234567892, '789 Main St.'),
('SU004', 'Emily Supplier', 'emily@gmail.com', 1234567893, '321 Main St.'),
('SU005', 'David Supplier', 'david@gmail.com', 1234567894, '654 Main St.'),
('SU006', 'Sara Supplier', 'sara@gmail.com', 1234567895, '987 Main St.');


INSERT INTO PURCHASE (P_ID, Med_ID, Sup_ID, Pur_Date, Mfg_Date, Exp_Date, P_Qty, P_Cost) VALUES
('P001', 'M001', 'SU001', '2022-01-01', '2021-01-01', '2023-01-01', 100, 1000),
('P002', 'M002', 'SU002', '2022-01-02', '2021-01-02', '2023-01-02', 200, 2000),
('P003', 'M003', 'SU003', '2022-01-03', '2021-01-03', '2023-01-03', 300, 3000),
('P004', 'M004', 'SU004', '2022-01-04', '2021-01-04', '2023-01-04', 400, 4000);


*/