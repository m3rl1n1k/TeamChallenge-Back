# Team Challenge

<hr>
<b> Name: </b>

<b>Request method: </b> <i>GET<i/> [http://localhost](http://localhost:8080)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(only json): </b> <pre>{}</pre>

<b>Params: </b><i>Empty</i>

<b>Return: </b>
<hr>

## API Doc

<hr>
<b> Name: Homepage</b>

<b>Request method: </b> <i>GET<i/> [http://localhost:8080](http://localhost:8080)

<b>Headers: </b> <i>Empty<i/>

<b>Body(only json): </b> <i>Empty<i/>

<b>Params: </b><i>Empty</i>

<b>Return: </b><i>Empty</i>
<hr>

<b> Name: Login</b>

<b>Request method: </b> <i>POST<i/> [http://localhost:8080/api/v1/login](http://localhost:8080/api/v1/login)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(only json): </b>
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

<b>Body(only json): </b>
<pre>{
"email": "m3rl1n1k@gmail.com", 
"password": "1111", 
"re-password": "1111", 
"name": "Serhii"
}</pre>

<b>Params: </b><i>Empty</i>

<b>Return: </b><i>Msg of result</i>
<hr>
<b> Name: Get All products</b>

<b>Request method: </b> <i>
GET<i/> [http://localhost:8080/api/v1/product/{type}?limit=10&sort=price.up](http://localhost:8080/api/v1/product/shoes?limit=10&sort=price.up])

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(only json): </b> <i>Empty<i/>

<b>Params: </b>
<table>
<tr>
<td>type</td>
<td>Select all products by type "shoes"</td>
<td>etc. shoes/sweats </td>
</tr>
<tr>
<td>limit</td>
<td>Set limits selected records to 10</td>
<td>limit=10</td>
</tr>
<tr>
<td>sorting</td>
<td>Set type for sorting selected records</td>
<td>sort=column_name.up/down</td>
</tr>
</table>

<b>Return: </b><i>JSON string</i>
<hr>
<b> Name: Create new product</b>

<b>Request method: </b> <i>
POST <i/> [http://localhost:8080/api/v1/product/new/{type}](http://localhost:8080/api/v1/product/new/shoes)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(only json): </b>
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

<b>Params: </b>

<table>
<tr>
<td>type</td>
<td>Name of table where save record</td>
</tr>
</table>

<b>Return: </b><i>ID of created record</i>
<hr>

<b> Name: Show product</b>

<b>Request method: </b> <i>
POST <i/> [http://localhost:8080/api/v1/product/shoes/show/{show}](http://localhost:8080//api/v1/product/shoes/show/9474480)

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(only json): </b> <i>Empty</i>

<b>Params: </b>

<table>
<tr>
<td>show</td>
<td>uniq article ex. 9474480</td>
</tr>
</table>

<b>Return: </b><i>JSON string</i>