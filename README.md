# Concursonautas

O Concursonautas é um projeto acadêmico que visa auxiliar concursandos e vestibulandos na organização de seus estudos. Ele oferece as seguintes funcionalidades:
- Agenda de Estudos
- Acompanhamento de Progresso
- Notificações Personalizadas
- Estatísticas de Desempenho

Neste repositório estaremos desenvolvendo a API do projeto.

## Tecnologias Utilizadas

- **API** - A API está sendo desenvolvida em Laravel, um Framework PHP.
- **Banco de Dados** - O banco de dados utilizado sera o MySQL.

## Pré-requisitos

Antes de começar, certifique-se de que o seu sistema atende aos seguintes requisitos:

- PHP >= 8.1
- Composer (para instalar dependências PHP)
- MySQL ou outro banco de dados suportado
- Um servidor web como Apache ou Nginx

### 1. Clone o Repositório
```bash
git clone git@github.com:mark079/api-concursonautas.git
```

2. Instale as Dependências PHP

```bash
cd seu-projeto-laravel
composer install
```

3. Copie o Arquivo de Configuração

```bash
cp .env.example .env
```

Abra o arquivo .env e configure as informações do banco de dados.
4. Gere a Chave de Aplicação

```bash
php artisan key:generate
```

5. Execute as Migrações do Banco de Dados

```bash
php artisan migrate
```

6. Inicie o Servidor Laravel

```bash
php artisan serve
```

O seu projeto Laravel agora deve estar rodando em http://localhost:8000.

## Licença

Este projeto é licenciado sob a Licença MIT, o que permite o uso, modificação e distribuição conforme os termos da licença.
