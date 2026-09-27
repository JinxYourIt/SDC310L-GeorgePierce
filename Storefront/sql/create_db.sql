CREATE TABLE IF NOT EXISTS vendors(
    vendor_id INT AUTO_INCREMENT PRIMARY KEY,
    vendor_name VARCHAR(100) NOT NULL,
    contact_email VARCHAR(150),
    contact_phone VARCHAR(25)
);

CREATE TABLE IF NOT EXISTS products (
	product_id INT AUTO_INCREMENT PRIMARY KEY,
    vendor_id INT,
    product_name VARCHAR(150) NOT NULL,
    description VARCHAR(150),
    price DECIMAL(10, 2) NOT NULL,
    stock_quant INT NOT NULL    
);

ALTER TABLE products
ADD CONSTRAINT fk_products_vendor_id
FOREIGN KEY (vendor_id) 
REFERENCES vendors(vendor_id);

CREATE TABLE IF NOT EXISTS order_items (
	order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL
);

ALTER TABLE order_items
ADD CONSTRAINT fk_items_order_id
FOREIGN KEY (order_id)
REFERENCES orders(order_id);

ALTER TABLE order_items
ADD CONSTRAINT fk_items_product_id
FOREIGN KEY (product_id)
REFERENCES products(product_id);
