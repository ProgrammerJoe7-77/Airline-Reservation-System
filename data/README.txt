IMPORTING ecommercedb.sql

After downloading XAMPP run the following:
<path_to_xampp_mysql_bin>\mysql -u root e-commercedb < e-commercedb.sql
Example:
C:\xampp\mysql\bin\mysqldump.exe -u root e-commercedb < e-commercedb.sql

Make sure you are in the directory where you saved e-commercedb.sql

This sould run all the sql commands in the .sql file and create a new database using data I already created.
You can verify this using phpMyAdmin or using mysql from the Windows commandline.

You should see boarding_pass_info, cities, login, order_details, order_header, payment_methods, product, and user_profile tables.
Most/All tables should already have some data in it that I used to test the models.
