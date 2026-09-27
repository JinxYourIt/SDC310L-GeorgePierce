INSERT INTO vendors (vendor_name, contact_email, contact_phone)
VALUES ('Hallz', 'Hallz@example.com', '123-456-7890'),
       ('MeatGrinders', 'MG@example.com', '987-654-3210'),
       ('Hardwares Supply', 'hwsupply@example.com', '111-222-3333'),
       ('Berthas Lovely Sweets', 'berthasweets@example.com', '444-555-6666'),
       ('Belindas Food Processing', 'bfprocessing@example.com', '777-888-9999');

INSERT INTO products (vendor_id, product_name, description, price, stock_quant)
VALUES (1, 'Hallz Chips', 'These are delicious chips.', 10.00, 100),
       (2, 'MeatGrinders Ground Beef', 'Delicious Ground Beef', 20.00, 200),
       (3, 'Steel Hammer', 'Generic Steel Hammer', 30.00, 300),
       (4, 'Assorted Sweets', 'Assorted Dilectables', 40.00, 400),
       (5, 'String Cheese', 'Belindas Own String Cheese', 50.00, 500);