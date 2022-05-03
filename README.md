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

### Instruções para rodar os testes

Primeiro passo é criar a imagem que irá rodar a aplicação. Caso não tenha executado os comandos acima, dentro da pasta do repositório execute o seguinte comando:

`docker build -t eureciclo/laravel:9 docker_images/`

Depois da imagem criada, ainda dentro da pasta do repositório, execute o seguinte comando para executar os testes:

`docker run -it -v $PWD/backend:/var/www/html --rm -e APP_ENV=testing eureciclo/laravel:9 php artisan test`

Para executar os testes com coverage:

`docker run -it -v $PWD/backend:/var/www/html --rm -e APP_ENV=testing eureciclo/laravel:9 php artisan test --coverage`

Para gerar coverage em html:

`docker run -it -v $PWD/backend:/var/www/html --rm -e APP_ENV=testing eureciclo/laravel:9 vendor/bin/phpunit --coverage-html reports/`