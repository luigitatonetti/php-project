# PHP project

## Description

The goal of the project was to create a RESTful API that allows CRUD operations on the data of a database that manages the orders of a company that tracks the co2 footprint of its products

### Entities:

- products = id, name, co2
- orders = id, date, destination
- orders_rows = id_order, id_product, quantity

### Instructions (products):

- **GET /products** = returns all products
- **POST /products** = allows the entry of a product
  ```json
  {
    "name": "Pork",
    "co2": 1.1
  }
  ```
- **PUT /products** = allows updating of a product

  ```json
  {
    "id": 4,
    "name": "Pork",
    "co2": 1.1
  }
  ```

- **DELETE /products** = allows the cancellation of a product
  ```json
  {
    "id": 5
  }
  ```

### Instructions (orders):

- **GET /orders** = returns all orders

- **POST /orders** = allows placing an order
  ```json
  {
    "date": "2022-05-05",
    "destination": "italy",
    "products": [
        {
            "id_product": 4,
            "name": "Steak",
            "quantity": 2,
            "co2": 5.6
        },
        {
            "id_product": 1,
            "name": "Beef",
            "quantity": 5,
            "co2": 10.5
        }
     ]
    }
  ```
- **PUT /orders** = allows updating of an order

  ```json
  {
    "id": 3,
    "date": "2022-05-05",
    "destination": "italy",
    "products": [
        {
            "id_product": 4,
            "name": "Steak",
            "quantity": 2,
            "co2": 5.6
        },
        {
            "id_product": 1,
            "name": "Beef",
            "quantity": 5,
            "co2": 10.5
        }
     ]
    }
  ```

- **DELETE /products** = allows the cancellation of an order

  ```json
  {
    "id": 3
  }
  ```
  
  ### Instructions (totCO2):

- **GET /totCO2** = return all saved CO2 (It can filter between two dates, by country and by product. All parameters are optional)

  ```json
  {
    "startDate": "01/01/2000",
    "endDate": "31/12/2000",
    "dountry": "italy",
    "id_product": 3
  }
  ```
