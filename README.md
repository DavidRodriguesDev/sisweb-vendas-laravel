# Sistema de Vendas

Sistema de gerenciamento de vendas desenvolvido com Laravel 11, Tailwind CSS, Alpine.js e MySQL.

## Funcionalidades

- **Dashboard** - Resumo de vendas do dia/mês, produtos mais vendidos, estoque baixo, vendas recentes
- **Produtos** - CRUD completo com controle de estoque e alerta de estoque mínimo
- **Categorias** - CRUD para organização dos produtos
- **Clientes** - Cadastro de clientes (CPF/CNPJ, endereço, telefone)
- **Vendas (PDV)** - Ponto de venda com seleção de cliente, produtos, quantidade, desconto e forma de pagamento
- **Pagamentos** - Suporte a dinheiro, cartão de crédito, débito, PIX e boleto
- **Relatórios** - Relatório de vendas com exportação em PDF
- **Autenticação e Permissões** - Login com controle de acesso por papéis (admin, vendedor, cliente) via Spatie Laravel Permission

## Requisitos

- Docker e Docker Compose

## Instalação

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/vendas.git
cd vendas

# Copie o arquivo de configuração
cp .env.example .env

# Suba os containers
docker compose up -d

# Instale as dependências do PHP
docker compose exec php composer install

# Gere a chave da aplicação
docker compose exec php php artisan key:generate

# Rode as migrations e seeders
docker compose exec php php artisan migrate --seed

# Ajuste as permissões
docker compose exec php chmod -R 775 storage bootstrap/cache
docker compose exec php chown -R www-data:www-data storage bootstrap/cache
```

## Acesso

Acesse: **http://localhost:8081**

| Usuário        | E-mail              | Senha      | Cargo     |
|---------------|---------------------|-----------|-----------|
| Administrador | admin@vendas.com    | password  | admin     |
| Vendedor      | vendedor@vendas.com | password  | vendedor  |

## Permissões por Papel

| Funcionalidade       | admin | vendedor | cliente |
|---------------------|:-----:|:--------:|:-------:|
| Dashboard           | sim   | sim      | sim     |
| Gerenciar Usuários  | sim   | nao      | nao     |
| Gerenciar Categorias| sim   | sim      | nao     |
| Gerenciar Produtos  | sim   | sim      | nao     |
| Gerenciar Clientes  | sim   | sim      | nao     |
| Gerenciar Vendas    | sim   | sim      | nao     |
| Gerenciar Pagamentos| sim   | sim      | nao     |
| Ver Relatórios      | sim   | sim      | nao     |

## Estrutura do Projeto

```
app/
  Http/
    Controllers/Web/    # Controllers das views (MVC tradicional)
    Requests/            # Validacao de formularios
  Models/                # Eloquent Models
  Policies/              # Autorizacao por recurso
  Providers/             # Service providers (Auth + App)
  Services/              # Logica de negocio (SaleService)
database/
  migrations/            # Schema do banco
  seeders/               # Dados iniciais (roles, users, categories, products, customers)
resources/
  views/                 # Blade templates com Tailwind CSS + Alpine.js
  js/app.js              # Frontend JS
  css/app.css            # Estilos
docker/
  nginx/default.conf     # Configuracao do Nginx
  php/Dockerfile          # Imagem PHP 8.3 FPM
routes/
  web.php                # Rotas da aplicacao
```

## Tecnologias

- **Backend:** Laravel 11, PHP 8.3
- **Frontend:** Tailwind CSS, Alpine.js, Vite
- **Banco de Dados:** MySQL 8.0
- **Infraestrutura:** Docker (Nginx, PHP-FPM, MySQL, Node)

## Comandos Uteis

```bash
# Parar containers
docker compose down

# Rebuild apos alteracao no Dockerfile
docker compose build php && docker compose up -d

# Acessar o container PHP
docker compose exec php bash

# Rodar migrations
docker compose exec php php artisan migrate

# Limpar caches
docker compose exec php php artisan view:clear
docker compose exec php php artisan cache:clear
docker compose exec php php artisan config:clear
```

## Licenca

Este projeto e de uso privado.