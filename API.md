# Team Challenge

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
<summary>Product</summary>
<br>
<b> Name: Get collections of products</b>

<b>Request method: </b> <i>
GET<i/> /api/v1/product?filter=shoes&page=1&limit=10&sort=price.up

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b> <i>Empty<i/>

<b>Params: </b>
<table>
<tr>
<td>filter</td>
<td>Filter product by type</td>
<td>filter=shoes
<br>if you need more, use' | 'example: shoes|pants
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
<td>sort</td>
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

<b> Name: Show record</b>

<b>Request method: </b> <i>
GET <i/> /api/v1/product/shoes/{article}

<b>Headers: </b> <i>Content-Type: application/json<i/>

<b>Body(json): </b> <i>Empty</i>

<b>Params: </b>

<table>
<tr>
<td>article</td>
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
</details>
<hr>
