# API

## Requests

### **GET** - /api/v1/throws

#### CURL

```sh
curl -X GET "http://localhost:8000/api/v1/throws\
?page=2" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json"
```

#### Query Parameters

- **page** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "2"
  ],
  "default": "2"
}
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

### **POST** - /api/v1/throws

#### CURL

```sh
curl -X POST "http://localhost:8000/api/v1/throws" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n  \"user_id\": \"1\",\n  \"game_id\": \"2\",\n  \"pie_value\": \"25\",\n  \"multiplier\": \"1\"\n}"
}
```

### **PATCH** - /api/v1/throws/11

#### CURL

```sh
curl -X PATCH "http://localhost:8000/api/v1/throws/11" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n  \"user_id\": \"3\",\n  \"game_id\": \"2\",\n  \"pie_value\": \"50\",\n  \"multiplier\": \"1\"\n}"
}
```

### **DELETE** - /api/v1/throws/37

#### CURL

```sh
curl -X DELETE "http://localhost:8000/api/v1/throws/37" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n  \"name\": \"Isac Hammes The Second\",\n  \"username\": \"delbertT22\"\n}"
}
```

### **GET** - /api/v1/gametypes

#### CURL

```sh
curl -X GET "http://localhost:8000/api/v1/gametypes" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

### **POST** - /api/v1/gametypes

#### CURL

```sh
curl -X POST "http://localhost:8000/api/v1/gametypes" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n\t\"name\": \"1024\",\n\t\"description\": \"Nullam faucibus ante velit. Sed nec hendrerit mi, sit amet auctor nibh. Integer quis aliquam erat. Etiam a nisl sed nibh mattis vestibulum. Vivamus faucibus porta diam eget facilisis. Curabitur eget tristique purus. Nulla gravida varius maximus. \"\n}"
}
```

### **PATCH** - /api/v1/gametypes/11

#### CURL

```sh
curl -X PATCH "http://localhost:8000/api/v1/gametypes/11" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\"description\":\"Lorem ipsum dollar sit ammet.\",\"name\":\"20 to 15\"}"
}
```

### **DELETE** - /api/v1/gametypes/3

#### CURL

```sh
curl -X DELETE "http://localhost:8000/api/v1/gametypes/3" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n  \"name\": \"Isac Hammes The Second\",\n  \"username\": \"delbertT22\"\n}"
}
```

### **GET** - /api/v1/games/

#### CURL

```sh
curl -X GET "http://localhost:8000/api/v1/games/\
?sort_by=asc" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json"
```

#### Query Parameters

- **sort_by** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "asc"
  ],
  "default": "asc"
}
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

### **POST** - /api/v1/games

#### CURL

```sh
curl -X POST "http://localhost:8000/api/v1/games" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\"game_type_id\":1}"
}
```

### **PATCH** - /api/v1/games/1

#### CURL

```sh
curl -X PATCH "http://localhost:8000/api/v1/games/1" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n  \"game_type_id\": 5\n}"
}
```

### **DELETE** - /api/v1/games/1

#### CURL

```sh
curl -X DELETE "http://localhost:8000/api/v1/games/1" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n  \"name\": \"Isac Hammes The Second\",\n  \"username\": \"delbertT22\"\n}"
}
```

### **GET** - /api/v1/users/1/throws

#### CURL

```sh
curl -X GET "http://localhost:8000/api/v1/users/1/throws" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

### **POST** - /api/v1/users

#### CURL

```sh
curl -X POST "http://localhost:8000/api/v1/users" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n  \"email\": \"kalle@example.com\",\n  \"username\": \"Kalle\",\n  \"password\": \"nicepassword\",\n  \"name\": \"foo\"\n}"
}
```

### **PATCH** - /api/v1/users/2

#### CURL

```sh
curl -X PATCH "http://localhost:8000/api/v1/users/2" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n  \"name\": \"Isac Hammes The Second\",\n  \"username\": \"delbertT22\"\n}"
}
```

### **DELETE** - /api/v1/users/11

#### CURL

```sh
curl -X DELETE "http://localhost:8000/api/v1/users/11" \
    -H "Accept: application/json" \
    -H "Content-Type: application/json" \
    --data-raw "$body"
```

#### Header Parameters

- **Accept** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```
- **Content-Type** should respect the following schema:

```
{
  "type": "string",
  "enum": [
    "application/json"
  ],
  "default": "application/json"
}
```

#### Body Parameters

- **body** should respect the following schema:

```
{
  "type": "string",
  "default": "{\n  \"name\": \"Isac Hammes The Second\",\n  \"username\": \"delbertT22\"\n}"
}
```

## References

