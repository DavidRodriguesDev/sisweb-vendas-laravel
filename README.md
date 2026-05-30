# Sistema de Vendas

Sistema de gerenciamento de vendas desenvolvido com Laravel 11, Tailwind CSS, Alpine.js e PostgreSQL.

## Funcionalidades

- **Dashboard** - Resumo de vendas do dia/mês, produtos mais vendidos, estoque baixo, vendas recentes
- **Produtos** - CRUD completo com controle de estoque e alerta de estoque mínimo
- **Categorias** - CRUD para organização dos produtos
- **Clientes** - Cadastro de clientes (CPF/CNPJ, endereço, telefone)
- **Vendas (PDV)** - Ponto de venda com seleção de cliente, produtos, quantidade, desconto e forma de pagamento
- **Pagamentos** - Suporte a dinheiro, cartão de crédito, débito, PIX e boleto
- **Relatórios** - Relatório de vendas com exportação em PDF
- **Autenticação e Permissões** - Login com controle de acesso por papéis (admin, vendedor) via Spatie Laravel Permission

## Requisitos

### Para desenvolvimento local (sem Docker)

- PHP 8.2+
- Composer
- Node.js 20+ e npm
- Banco de dados: PostgreSQL 16+, MySQL 8.0+ ou SQLite

### Para Docker (Recomendado)

- Docker 24+
- Docker Compose 2.0+

## Instalação (Docker) - Recomendado

```bash
# Clone o repositório
git clone https://github.com/DavidRodriguesDev/sisweb-vendas-laravel.git
cd sisweb-vendas-laravel

# Configure as variáveis de ambiente (opcional - usa defaults do docker-compose.yml)
cp .env.example .env

# Edite o .env se precisar personalizar:
# DB_CONNECTION=pgsql (padrão)
# DB_HOST=postgres (padrão - nome do container no Docker)
# DB_DATABASE=sales_system (padrão)
# DB_USERNAME=sales_user (padrão)
# DB_PASSWORD=sales_secret (padrão)

# Suba os containers
docker compose up -d --build

# Aguarde alguns segundos até que o PHP e o PostgreSQL estejam prontos

# Acesse o menu inicial do sistema
# Abra o navegador em: http://localhost:8081
```

**O Docker irá automaticamente:**
- Instalar as dependências Composer (vendor/)
- Gerar a chave da aplicação (`APP_KEY`)
- Executar as migrations e seeders
- Configurar as permissões corretas

## Instalação (Local - Sem Docker)

```bash
# Clone o repositório
git clone https://github.com/DavidRodriguesDev/sisweb-vendas-laravel.git
cd sisweb-vendas-laravel

# Instale as dependências PHP
composer install

# Instale as dependências Node
npm install

# Copie o arquivo de configuração
cp .env.example .env

# Edite o .env e configure seu banco de dados:
# Para PostgreSQL:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sales_system
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

# Para MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=sales_system
# DB_USERNAME=root
# DB_PASSWORD=sua_senha

# Gere a chave da aplicação
php artisan key:generate

# Execute as migrations e seeders
php artisan migrate --seed

# Compile os assets
npm run build

# Inicie o servidor de desenvolvimento
php artisan serve --host=0.0.0.0 --port=8000
```

## Acesso

### URLs

- **Docker:** http://localhost:8081
- **Local (Artisan):** http://localhost:8000

### Usuários Padrão (com dados de seed)

| Nome              | E-mail              | Senha      | Cargo     |
|-------------------|---------------------|------------|-----------|
| Administrador     | admin@vendas.com    | password   | admin     |
| Vendedor          | vendedor@vendas.com | password   | vendedor  |

## Comandos Úteis (Docker)

```bash
# Ver logs em tempo real
docker compose logs -f

# Parar containers
docker compose down

# Parar e remover volumes (cuidado! - apaga todos os dados)
docker compose down -v

# Rebuild após alteração no Dockerfile
docker compose build php && docker compose up -d

# Acessar o container PHP
docker compose exec php bash

# Acessar o container PostgreSQL
docker compose exec postgres psql -U sales_user -d sales_system

# Acessar o container Node (para npm)
docker compose exec npm bash

# Ver containers
docker compose ps

# Verificar estado das vendas no banco
docker compose exec php php artisan tinker --execute="echo 'Total de Vendas: ' . App\Models\Sale::count(); echo PHP_EOL; echo 'Total vendido: R\$ ' . App\Models\Sale::sum('grand_total');"
```

## Estrutura do Projeto

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/Web/    # Controllers das views (MVC tradicional)
│   │   └── Requests/           # Validação de formulários
│   ├── Models/                 # Eloquent Models
│   ├── Policies/               # Autorização por recurso
│   ├── Providers/              # Service providers
│   └── Services/               # Lógica de negócio
├── database/
│   ├── migrations/             # Schema do banco de dados
│   └── seeders/                # Dados iniciais (roles, users, categories, products, customers, sales)
├── resources/
│   ├── views/                  # Blade templates com Tailwind CSS + Alpine.js
│   ├── js/app.js               # Frontend JS com Alpine.js
│   └── css/app.css             # Estilos Tailwind CSS
├── docker/
│   ├── nginx/
│   │   └── default.conf      # Configuração do Nginx
│   └── php/
│       ├── Dockerfile          # Imagem PHP 8.4 FPM
│       └── docker-entrypoint.sh # Script de inicialização e setup automático
├── routes/
│   └── web.php                 # Rotas da aplicação
├── public/                     # Arquivos públicos (builds, assets)
├── .dockerignore
├── .env.example                # Template de configuração
└── docker-compose.yml          # Orquestração dos containers
```

## Tecnologias

- **Backend:** Laravel 11, PHP 8.2+
- **Frontend:** Tailwind CSS, Alpine.js, Vite
- **Banco de Dados:** PostgreSQL 16 (configurado por padrão), MySQL 8.0 ou SQLite
- **Infraestrutura:** Docker (Nginx, PHP-FPM, Postgres, Node)

## Permissões por Papel

| Funcionalidade       | admin | vendedor |
|---------------------|:-----:|:--------:|
| Dashboard           | sim   | sim      |
| Gerenciar Usuários  | sim   | não      |
| Gerenciar Categorias| sim   | sim      |
| Gerenciar Produtos  | sim   | sim      |
| Gerenciar Clientes  | sim   | sim      |
| Gerenciar Vendas    | sim   | sim      |
| Gerenciar Pagamentos| sim   | sim      |
| Ver Relatórios      | sim   | sim      |

## Notas Importantes

- O projeto usa `docker-compose.yml` para orquestração dos containers
- O banco de dados PostgreSQL está configurado por padrão com credenciais:`sales_user/sales_secret`
- Os mounts do Docker mapeiam o diretório atual para `/var/www/html` no container
- Para uso em produção, configure variáveis sensíveis no `.env` e defina `APP_DEBUG=false`
- O seed de vendas cria 25 vendas demonstrativas com datas distribuídas ao longo de Abril e Maio de 2026

## Estrutura do Banco de Dados

| Tabela              | Registros (seed) | Descrição                     |
|---------------------|------------------|-------------------------------|
| users               | 2                | Admin e Vendedor              |
| customers           | 5                | Clientes demo                 |
| products            | 10               | Produtos por categoria        |
| categories          | 6                | Eletrônicos, Informática, etc |
| sales               | 25               | Vendas com diferentes statuses|
| payments            | 24               | Pagamentos das vendas         |
| roles               | 2                | admin, vendedor               |
| permissions         | 15+              | Permitidos por role           |


