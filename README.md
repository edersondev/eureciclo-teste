# Desafio de programação da eureciclo

## Tecnologias usadas no desenvolvimento:

### Frontend

- Node versão 16
- Angular 13
- Angular Material 13

### Frontend

- PHP 8
- Laravel 9

### Banco de Dados

- PostgreSql 14

### Requisitos para rodar a aplicação

Ter instalado o Docker e o Docker Composer.

### Instruções para rodar a aplicação

Depois que baixar os arquivos do repositório para sua máquina execute o seguinte comando:

`docker-compose up -d`

Aguarde o docker baixar as imagens para fazer o build do backend e frontend. As imagens personalizadas do backend e do frontend irão executar o composer install e o npm install respectivamente.

Acompanhe o andamento das instalações usando os comandos abaixo:

`docker logs -f NAME_CONTAINER`

Depois de tudo terminado acesse no navegador o seguinte endereço:
http://localhost:4200

