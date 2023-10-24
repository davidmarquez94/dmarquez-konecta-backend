Prueba técnica PHP David Márquez (Lonecta)<br /><br />
Para comenzar, por favor ejecute los siguientes comandos en la terminal<br />
composer install <br />
cp .env.example.env<br />
php artisan key:generate<br />
php artisan migrate --seed<br /><br />
Las rutas de este proyecto son expuestas como webservice, para su posterior consumo en una aplicación desarrollada con Angular (Repositorio adjunto en el correo)<br /><br />
<h3>Productos</h3>
GET: /products (Obtiene el listado de todos los productos)

GET: /products/getProduct/{id} (Obtiene un producto por Id)

POST: /products/create (Creación de un producto)<br />
Raw example: {
    "name": "Torta de queso",
    "reference": "REF002",
    "price": 4000,
    "weight": 200,
    "stock": 8,
    "category_id": 1
}<br />

PUT: /products/update (Actualiza un producto)<br />
raw example: {
    "id": 1,
    "name": "Café americano pequeño",
    "reference": "REF001",
    "price": 2000,
    "weight": 100,
    "stock": 6,
    "category_id": 3
}<br />

DELETE: /products/destroy/{id} (Elimina un producto)<br />

GET: /products/majorStock (Producto con mayor stock, esta ruta no está integrada en la app Angular, puede consultarse con Postman)

GET: /sales/mostSold (Producto más vendido, esta ruta no está integrada en la app Angular, puede consultarse con Postman)

POST: /sales/create (Registra una venta)<br />
raw example: {
    "employee_id": 1,
    "product_id": 2,
    "quantity": 7
}<br />

GET: /categories (Obtiene las categorías [esta ruta se utiliza para la creación de nuevos productos])

GET: /employees (Listado de vendedores [Esta ruta se utiliza en el registro de una venta])<br /><br />
Las pruebas unitarias pueden encontrarse en el directorio <strong>test/unit</strong>, y pueden ser ejecutadas utilizando el comando php artisan test