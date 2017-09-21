# order-service-api

The suggestion was to **over-engineer** this seemingly simple task, thus my goal was to comply but not **overkill**, while trying to put as much knowledge as I have within reasonable time frame. I have hopefully accomplished 2nd level of RESTfulness of my application.

Tools/Environment I've used to accomplish the assignment:
 - Phalcon (High performance PHP framework) 
 - Docker (+ docker-compose)
 - Redis (cache and cart)
 - Postgres (product DB)
 - PHP 7.0 FPM
 - Postman (tests)
 - Nginx (webserver)
 - Composer (to pull a simple XML converter)
 
Every element of the list above as well as code design choices have their reasons but I'd rather prefer to explain them face to face instead of writing everything down :-) Also, tl;dr

## Running the API

Of course, you, as a web developer, have Docker and Docker Compose installed on your UNIX machine (myself I'm using Windows with Vagrant because I love Microsoft <3). Thus to run the API simply do the following

    $ git clone git@github.com:mike-code/gogapi
    $ cd gogapi
    $ docker-compose up

The service will be exposed on port 80

## Using the API

**NOTE:** Whenever inserting/updating data (POST/PUT), the POST/PUT data should be in `application/x-www-form-urlencoded` format.
**NOTE:** Each request that returns list of object (i.e. list of cart items) takes additional `?format=xml|json` parameter which returns data in either `json` or `xml` format. This defaults to `json`.


### Add product to the database

    POST /product
    
Additional data:
* title (string) mandatory
* price (float) mandatory
* currency (string) [USD|EUR|PLN] mandatory
    
    
### Update product in the database

    PUT /product/{id:int}
    
Additional data (**at least** one of the parameters below are required)
* title (string) optional
* price (float) optional
* currency (string) [USD|EUR|PLN] optional
    

### Remove product from the database

    DELETE /product/{id:int}
    
    
### List all products (paginated) in the database

    GET /product[?format=xml][?start=1]
    
Additional parameters
* format (string) optional [xml|json]
* start (int) optional defaults to 0 -- page number

**Note:** Since the application is not fully restfull (level 2 out of 3 as I call it), the API does not return URL to the next page.


### Create cart

    POST /cart
 
**Note:** You have to create the cart before trying to add/get items from it. Otherwise you'll get 401 Unauthorized.

### Add item to the cart

    POST /cart/product/{id:int}

**Note:** According to specification you cannot add more than 3 products to the cart.
    
### Remove item to the cart

    DELETE /cart/product/{id:int}
    

### Get all items from the cart

    GET /cart[?format=xml]
    

## Tests

(In progress) API tests will be written in Newman/Postman as a tool of choice to test APIs.


    
