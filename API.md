# Team Challenge

[//]: # (<hr>)

[//]: # (<b> Name: </b>)

[//]: # ()

[//]: # (<b>Request method: </b> <i>GET<i/> [http://localhost]&#40;http://localhost:8080&#41;)

[//]: # ()

[//]: # (<b>Headers: </b> <i>Content-Type: application/json<i/>)

[//]: # ()

[//]: # (<b>Body&#40;json&#41;: </b> <pre>{}</pre>)

[//]: # ()

[//]: # (<b>Params: </b><i>Empty</i>)

[//]: # ()

[//]: # (<b>Return: </b>)

[//]: # (<hr>)

## API Doc

<hr>
<b> Name: Homepage</b>

<b>Request method: </b> <i>GET<i/> [http://localhost:8080](http://localhost:8080)

<b>Headers: </b> <i>Empty<i/>

<b>Body(json): </b> <i>Empty<i/>

<b>Params: </b><i>Empty</i>

<b>Return: </b><i>Empty</i>
<hr>
<details>
<summary>Auth</summary>
<br>
<b> Name: Login</b>

<b>Request method: </b> <i>POST<i/> [http://localhost:8080/api/v1/login](http://localhost:8080/api/v1/login)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b>
<pre>{ 
"email": "m3rl1n1k@gmail.com", 
"password": "1111" 
}</pre>

<b>Params: </b><i>Empty</i>

<b>Return: </b><i>Authentication token</i>
<hr>
<b> Name: Registration</b>

<b>Request method: </b> <i>
POST<i/> [http://localhost:8080/api/v1/registration](http://localhost:8080/api/v1/registration)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b>
<pre>{
"email": "m3rl1n1k@gmail.com", 
"password": "1111", 
"re-password": "1111", 
"name": "Serhii"
}</pre>

<b>Params: </b><i>Empty</i>

<b>Return: </b><i>Msg of result</i>
<hr>
</details>
<hr>
<details>
<summary>Product</summary>
<br>
<b> Name: Get collections of products</b>

<b>Request method: </b> <i>
GET<i/> [http://localhost:8080/api/v1/product?type=shoes&page=1&limit=10&sort=price.up](http://localhost:8080/api/v1/product?type=shoes&)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b> <i>Empty<i/>

<b>Params: </b>
<table>
<tr>
<td>type*</td>
<td>Filter product by type</td>
<td>filter=shoes
<br>if you need more use' | 'example: shoes|pants
</td>
</tr>
<tr>
<td>page*</td>
<td>Show page number 1</td>
<td>page=1</td>
</tr>
<tr>
<td>limit</td>
<td>Set limits selected records to 10. Max 10 records</td>
<td>limit=10</td>
</tr>
<tr>
<td>sorting</td>
<td>Set type for sorting selected records</td>
<td>sort=column.up/down</td>
</tr>
</table>

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>200</td>
<td>Json string with records</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
<hr>
<b> Name: Create new record</b>

<b>Request method: </b> <i>
POST </i> [http://localhost:8080/api/v1/product/shoes](http://localhost:8080/api/v1/product/shoes)

<b>Headers: </b> <br>
<i>Content-Type: application/json<i/> <br>
<i>Authorization: auth-token*<i/>

* auth token - you get this token after successfully authorization

<b>Body(json): </b>
<pre>{
  "name": "Training Shoes",
  "size": {
    "38": true,
    "39": true,
    "40": false
  },
  "color": "Green",
  "article": 9474480,
  "brand": "Under Armour",
  "model": "Project Rock",
  "price": 149,
  "genre": "Woman",
  "description": "Durable training shoes for gym workouts",
  "image": "path/to/image5.jpg"
}</pre>

<b>Params: </b> Empty

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>201</td>
<td>Json string with success message</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
<hr>
<b> Name: Update record</b>

<b>Request method: </b> <i>
PUT </i> [http://localhost:8080/api/v1/product/shoes/{article}](http://localhost:8080/api/v1/product/shoes/9474480)

<b>Headers: </b> <br>
<i>Content-Type: application/json<i/>
<br>
<i>Authorization: auth-token*<i/>

* auth token - you get this token after successfully authorization

<b>Body(json): </b>
<pre>{
  "name": "Training Shoes",
  "size": {
    "38": false,
    "39": false,
    "40": false
  },
  "color": "Pink",
  "article": 9474480,
  "brand": "Under Armour",
  "model": "Project Rock",
  "price": 149,
  "genre": "Woman",
  "description": "Durable training shoes for gym workouts",
  "image": "path/to/image5.jpg"
}</pre>

<b>Params: </b>
<table>
<tr><td>{article}</td> <td>Article of product 9474480</td></tr>
</table>

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>200</td>
<td>Json string with success message</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
<hr>

<b> Name: Show record</b>

<b>Request method: </b> <i>
GET <i/> [http://localhost:8080/api/v1/product/shoes/{show}](http://localhost:8080//api/v1/product/shoes/9474480)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b> <i>Empty</i>

<b>Params: </b>

<table>
<tr>
<td>show</td>
<td>uniq article 9474480</td>
</tr>
</table>

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>200</td>
<td>Json string with record</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
<hr>

<b> Name: Delete record</b>

<b>Request method: </b> <i>
DELETE <i/> [http://localhost:8080/api/v1/product/shoes/{article}](http://localhost:8080/api/v1/shoes/9474480)

<b>Headers: </b> <br>
<i>Content-Type: application/json<i/>
<br>
<i>Authorization: auth-token * <i/>

* auth token - you get this token after successfully authorization

<b>Body(json): </b> <i>Empty</i>

<b>Params: </b>

<table>
<tr>
<td>article</td>
<td>article of record</td>
</tr>
</table>

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>200</td>
<td>Empty</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
</details>
<hr><details>
<summary>Accessories</summary>
<br>
<b> Name: Get collections records</b>

<b>Request method: </b> <i>
GET<i/> [http://localhost:8080/api/v1/product/shoes?page=1&limit=10&sort=price.up](http://localhost:8080/api/v1/product/shoes?page=1&limit=10&sort=price.up)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b> <i>Empty<i/>

<b>Params: </b>
<table>
<tr>
<td>page*</td>
<td>Show page number 1</td>
<td>page=1</td>
</tr>
<tr>
<td>limit</td>
<td>Set limits selected records to 10. Max 10 records</td>
<td>limit=10</td>
</tr>
<tr>
<td>sorting</td>
<td>Set type for sorting selected records</td>
<td>sort=column.up/down</td>
</tr>
</table>

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>200</td>
<td>Json string with records</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
<hr>
<b> Name: Create new record</b>

<b>Request method: </b> <i>
POST </i> [http://localhost:8080/api/v1/product/shoes](http://localhost:8080/api/v1/product/shoes)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b>
<pre>{
  "name": "Training Shoes",
  "size": {
    "38": true,
    "39": true,
    "40": false
  },
  "color": "Green",
  "article": 9474480,
  "brand": "Under Armour",
  "model": "Project Rock",
  "price": 149,
  "genre": "Woman",
  "description": "Durable training shoes for gym workouts",
  "image": "path/to/image5.jpg"
}</pre>

<b>Params: </b> Empty

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>201</td>
<td>Json string with success message</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
<hr>
<b> Name: Update record</b>

<b>Request method: </b> <i>
PUT </i> [http://localhost:8080/api/v1/product/shoes/{article}](http://localhost:8080/api/v1/product/shoes/9474480)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b>
<pre>{
  "name": "Training Shoes",
  "size": {
    "38": false,
    "39": false,
    "40": false
  },
  "color": "Pink",
  "article": 9474480,
  "brand": "Under Armour",
  "model": "Project Rock",
  "price": 149,
  "genre": "Woman",
  "description": "Durable training shoes for gym workouts",
  "image": "path/to/image5.jpg"
}</pre>

<b>Params: </b>
<table>
<tr><td>{article}</td> <td>Article of product 9474480</td></tr>
</table>

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>200</td>
<td>Json string with success message</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
<hr>

<b> Name: Show record</b>

<b>Request method: </b> <i>
GET <i/> [http://localhost:8080/api/v1/product/shoes/{show}](http://localhost:8080//api/v1/product/shoes/9474480)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b> <i>Empty</i>

<b>Params: </b>

<table>
<tr>
<td>show</td>
<td>uniq article 9474480</td>
</tr>
</table>

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>200</td>
<td>Json string with record</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
<hr>

<b> Name: Delete record</b>

<b>Request method: </b> <i>
DELETE <i/> [http://localhost:8080/api/v1/product/shoes/{article}](http://localhost:8080/api/v1/shoes/9474480)

<b>Headers: </b> Empty

<b>Body(json): </b> <i>Empty</i>

<b>Params: </b>

<table>
<tr>
<td>article</td>
<td>article of record</td>
</tr>
</table>

<b>Return: </b>
<table>
<tr>
<td></td>
<td>Status code</td>
<td>Response</td>
</tr>
<tr>
<td>Success</td>
<td>200</td>
<td>Empty</td>
</tr>
<tr>
<td>Fail</td>
<td>400</td>
<td>Json string with fail message</td>
</tr>
</table>
</details>
<hr>
