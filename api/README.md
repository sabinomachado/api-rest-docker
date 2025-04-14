# Rotas

## Rotas de Pedidos

### 1. Listar todos os Pedidos - Get All

```bash
get http://localhost:8000/api/v1/orders/
```
### Exemplo de Retorno - Get All
```json
{
    "data": {
        "id": 10,
        "city": {
            "id": 31,
            "name": "Barreto do Leste"
        },
        "client": {
            "id": 31,
            "name": "Diana Sanches Aranda Filho",
            "email": "cortes.norma@example.net"
        },
        "seller": {
            "id": 10,
            "name": "Sabino Machado",
            "email": "teste@example.com"
        },
        "boarding_date": "2023-01-20",
        "return_date": "1981-09-10",
        "status": "canceled",
        "created_at": "2025-04-14T12:34:00.000000Z",
        "updated_at": "2025-04-14T12:34:00.000000Z"
    }
}

```

### 1.1. Listar todos os Pedidos Com Filtro de Cidades- Get All

```bash
get http://localhost:8000/api/v1/orders/search?city=Porto
```


### 1.1. Listar todos os Pedidos Com Intervalo de Datas- Get All

```bash
get http://localhost:8000/api/v1/orders/search?date_start=2025-04-14&date_end=2025-04-15
```

### 2. Listar todos os Pedidos - Get All

```bash
get http://localhost:8000/api/v1/orders/{ID}
```
### Exemplo de Retorno - Get By Id
```json
{
    "data": {
        "id": 10,
        "city": {
            "id": 31,
            "name": "Barreto do Leste"
        },
        "client": {
            "id": 31,
            "name": "Diana Sanches Aranda Filho",
            "email": "cortes.norma@example.net"
        },
        "seller": {
            "id": 10,
            "name": "Sabino Machado",
            "email": "teste@example.com"
        },
        "boarding_date": "2023-01-20",
        "return_date": "1981-09-10",
        "status": "canceled",
        "created_at": "2025-04-14T12:34:00.000000Z",
        "updated_at": "2025-04-14T12:34:00.000000Z"
    }
}
```


### 3. Atualizar um Pedido

```bash
put http://localhost:8000/api/v1/orders/{ID}

Body

{
    "id_client": "required|integer|exists:clients,id",
    "id_city": "required|integer|exists:cities,id",
    "id_user":"required|integer|exists:users,id",
    "boarding_date": "2025-04-20",
    "return_date": "2025-04-25",
    "status": "confirmed"
}
```

### Exemplo de Retorno
```json
{
    "success": {
        "code": 200,
        "message": "Pedido atualizado com sucesso!",
        "data": []
    }
}
```

### 4. Atualizar um Satus de Pedido

```bash
put http://localhost:8000/api/v1/orders/{ID}/update-status

Body
{
    "status": "required|string|in:pending,confirmed,canceled"
}
```
### Exemplo de Retorno - Atualizar um Satus de Pedido
```json
{
    "success": {
        "code": 200,
        "message": "Pedido atualizado com sucesso!",
        "data": []
    }
}
```

### 5. Criar um Pedido

```bash
put http://localhost:8000/api/v1/orders/

Body:
{
    "id_client": "required|integer|exists:clients,id",
    "id_city": "required|integer|exists:cities,id",
    "id_user":"required|integer|exists:users,id",
    "boarding_date": "2025-04-20",
    "return_date": "2025-04-25",
    "status": "confirmed"
}
```


### Exemplo de Retorno - POST - Criar Pedido
```json
{
    "data": {
        "id_client": 1,
        "id_city": 10,
        "id_user": 3,
        "boarding_date": "2025-04-20",
        "return_date": "2025-04-25",
        "status": "confirmed",
        "updated_at": "2025-04-14T05:27:06.000000Z",
        "created_at": "2025-04-14T05:27:06.000000Z",
        "id": 21
    }
}
```

### 6. Deletar um Pedido

```bash
delete http://localhost:8000/api/v1/orders/{ID}
```
### Exemplo de Retorno - Get By Id
```json
{
    "success": {
        "code": 200,
        "message": "Pedido removido com sucesso!",
        "data": []
    }
}
```



