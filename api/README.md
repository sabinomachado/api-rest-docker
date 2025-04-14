# Laravel Docker Project

Este repositório contém um projeto Laravel configurado para rodar com Docker, incluindo MySQL e MailHog para desenvolvimento local.

## Requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- Git

## Inicialização do Projeto

### 1. Clonar o Repositório

```bash
git clone git@github.com:sabinomachado/api-rest-docker.git
cd api
```

### 2. Configuração do Ambiente

Copie o arquivo de ambiente de exemplo e ajuste conforme necessário:

```bash
cp .env.example .env
```

Certifique-se de que o arquivo `.env` contém as seguintes configurações:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

### 3. Iniciar os Containers Docker

```bash
docker-compose up -d
```

Este comando irá construir e iniciar todos os containers definidos no arquivo `docker-compose.yml`.

### 4. Instalar Dependências do Laravel

```bash
docker-compose exec app composer install
```

### 5. Gerar Chave da Aplicação

```bash
docker-compose exec app php artisan key:generate
```

### 6. Executar Migrações do Banco de Dados

```bash
docker-compose exec app php artisan migrate
```

## Acessando os Serviços

Após iniciar os containers, você pode acessar os seguintes serviços:

- **Laravel Application**: [http://localhost:8000](http://localhost:8000)
- **MailHog Interface**: [http://localhost:8025](http://localhost:8025)
- **MySQL**: Disponível na porta 3306
    - Host: localhost (ou 127.0.0.1)
    - Port: 3306
    - Username: laravel
    - Password: secret
    - Database: laravel

## Comandos Úteis

### Gerenciamento de Containers

```bash
# Iniciar todos os containers
docker-compose up -d

# Parar todos os containers
docker-compose down

# Verificar logs dos containers
docker-compose logs

# Verificar logs de um container específico
docker-compose logs app
docker-compose logs mysql
docker-compose logs mailhog
```

### Comandos Laravel

```bash
# Executar migrações
docker-compose exec app php artisan migrate

# Executar seeds
docker-compose exec app php artisan db:seed

# Limpar cache
docker-compose exec app php artisan cache:clear

# Criar um controller
docker-compose exec app php artisan make:controller NomeController

# Criar um model com migração
docker-compose exec app php artisan make:model Nome -m

# Executar testes
docker-compose exec app php artisan test
```

### Acesso ao Container

```bash
# Abrir um terminal no container da aplicação
docker-compose exec app bash

# Abrir um terminal no container MySQL
docker-compose exec mysql bash
```

## Solução de Problemas

### Permissões de Arquivo

Se encontrar problemas de permissão ao executar comandos Artisan, tente:

```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### Container não inicia

Verifique se as portas necessárias estão disponíveis (8000, 3306, 8025) e não estão sendo usadas por outros serviços.

```bash
# Verificar portas em uso (macOS/Linux)
lsof -i :8000
lsof -i :3306
lsof -i :8025
```

### Problemas de Conexão com o Banco de Dados

Verifique se as configurações no arquivo `.env` correspondem às configuradas no `docker-compose.yml`.

## Desenvolvimento

O diretório do projeto está mapeado para o container, então as alterações feitas localmente serão refletidas no container automaticamente.

Para instalar novas dependências do Composer:

```bash
docker-compose exec app composer require [pacote]
```

Para instalar dependências NPM e compilar assets:

```bash
# Instalar dependências
docker-compose exec app npm install

# Compilar assets
docker-compose exec app npm run dev
```
