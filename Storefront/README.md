# Project Name: Ol' George's Market

## Project Description

Ol' George's Market is a responsive PHP storefront developed for the SDC310L Catalog Project. Users can browse products, add quantities to a shopping cart, remove products, review order totals, and place orders. The application stores products, vendors, orders, and order items in a MySQL/MariaDB database and updates inventory after checkout.

## Project Tasks

- **Task 1: Set up the development environment**
  - Use XAMPP to run Apache, PHP, and MySQL/MariaDB locally.
  - Place the project in the XAMPP `htdocs` directory.
- **Task 2: Design the application**
  - Organize code into models, views, a controller, and shared includes.
  - Create catalog and cart pages with a consistent header and footer.
- **Task 3: Develop the frontend**
  - Build product tables and shopping cart forms with PHP and HTML.
  - Use CSS and Bootstrap for styling and responsive layouts.
- **Task 4: Develop the backend**
  - Handle adding products, removing products, and placing orders with PHP.
  - Validate product IDs and positive whole-number quantities.
  - Calculate item subtotals, 5% tax, 10% shipping, and final order totals.
  - Check available stock before checkout.
- **Task 5: Connect to a database**
  - Create related tables for vendors, products, orders, and order items.
  - Use MySQLi and prepared statements for parameterized database operations.
  - Save order details, reduce inventory, and mark orders as completed.
  - Display the ten most recent orders on the catalog page.
- **Task 6: Test the application**
  - Use the PHP test script to check catalog retrieval, cart validation, totals, order records, and inventory updates.
  - Manually check browser navigation, cart actions, and insufficient-stock handling.
- **Task 7: Document the project**
  - Provide a README with project details, setup instructions, and testing notes.

## Project Skills Learned

- Frontend development with HTML, CSS, and Bootstrap.
- Backend development and form handling with PHP.
- Organizing application code into models, views, and controllers.
- Input validation and shopping cart calculations.
- Relational database design with SQL and MySQL/MariaDB.
- Database access with MySQLi and prepared statements.
- Order processing and inventory management.
- Automated functional testing and manual browser testing.
- Writing project documentation.

## Language Used

- **PHP**: Backend logic, form handling, database access, and page rendering.
- **HTML**: Page structure, tables, and forms.
- **CSS**: Styling, including the bundled Bootstrap stylesheet.
- **SQL**: Database schema, sample data, and database queries.

## Notes

### Local Setup

1. Install XAMPP with PHP and MySQL/MariaDB support.
2. Place the project in `C:\xampp\htdocs\Storefront`.
3. Start **Apache** and **MySQL** in the XAMPP Control Panel.
4. Open `http://localhost/phpmyadmin` and create an empty database named `catalog_db`.
5. Select that database and import [sql/catalog_db.sql](sql/catalog_db.sql) to create the tables.
6. Import [sql/insert_products_vendors.sql](sql/insert_products_vendors.sql) once to load sample vendors and products. Use a fresh schema because the sample products assume vendor IDs start at 1.
7. Check [models/database.php](models/database.php). The default connection uses host `localhost`, username `root`, an empty password, and database `catalog_db`. Adjust these values for your local setup.
8. Open `http://localhost/Storefront/views/index.php`.

Bootstrap is included in `layout/bootstrap.min.css`. No npm installation is required.

### Testing

With MySQL running and `catalog_db` created, run the existing test script from the `tests` directory. In PowerShell, starting at the project root:

```powershell
Set-Location tests
& C:\xampp\php\php.exe storefront_test.php
```

The script checks catalog retrieval, invalid quantities, totals and rounding, saved orders, inventory reductions, and recent orders. It uses temporary tables on its database connection, leaving existing application records unchanged. It prints `PASS` when all checks succeed or `FAIL` when a check fails.

For browser testing, add two Hallz Chips and one MeatGrinders Ground Beef using the sample prices. Expect 3 units, a $40.00 subtotal, $2.00 tax, $4.00 shipping, and a $46.00 total. Also check removing products, reviewing an empty cart, and attempting checkout with quantities exceeding available stock. Successful browser checkout creates database records and reduces stock.

### Application Behavior

- Cart contents travel through hidden form fields. Use **Review Your Order** and **Back to the Shelves** to preserve the cart between pages. Opening the catalog directly starts an empty cart.
- Products with zero stock remain visible; stock availability is checked at checkout.
- Tax and shipping are calculated from the subtotal and rounded separately to two decimal places.
- Placing an order saves it to the database and marks it completed. The application does not process payments.
