# Dream Page | Site com Painel de Artigos (PHP + MySQL)

Projeto de site institucional com painel administrativo para publicar e excluir artigos.

## Visao geral

Este projeto entrega:

- Site publico responsivo.
- Painel admin com login.
- Publicacao de artigos com titulo, categoria, data, imagem de capa e conteudo.
- Exclusao individual e em lote de artigos.
- Persistencia em MySQL.

## Stack

- PHP 8+
- MySQL / MariaDB
- HTML5
- CSS3
- JavaScript

## Estrutura

- `trabalho html/index.php` -> pagina publica principal
- `trabalho html/admin/login.php` -> login do painel
- `trabalho html/admin/dashboard.php` -> gerenciamento de artigos
- `trabalho html/includes/` -> configuracao, auth e conexao com banco
- `trabalho html/database.sql` -> schema inicial

## Requisitos

- PHP 8+
- MySQL ou MariaDB

## Como rodar localmente

1. Suba o banco MySQL/MariaDB.
2. Execute o SQL inicial em `trabalho html/database.sql`.
3. Configure as variaveis de ambiente do banco (opcional) ou use os defaults de `trabalho html/includes/config.php`.
4. Inicie o servidor PHP na raiz do repositorio:

```bash
php -S localhost:8000 -t "trabalho html"
```

5. Acesse:

- Site: `http://localhost:8000/index.php`
- Painel: `http://localhost:8000/admin/login.php`

## Configuracao de banco (variaveis de ambiente)

A conexao aceita os seguintes valores:

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`
- `DB_CHARSET`

Se nao forem definidos, o projeto usa valores padrao de desenvolvimento local.

## Observacoes

- `trabalho html/uploads/capas/` guarda capas dos artigos enviados.
- Imagens de upload estao ignoradas no Git para manter o repositorio limpo.

## Autor

Dream Page
