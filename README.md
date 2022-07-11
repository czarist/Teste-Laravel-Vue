# Como iniciar o sistema para efetuar o teste

## composer install
## npm install

## php artisan migrate

## php artisan db:seed

# Liberar login por cpf 

## Entrar na pasta vendor->laravel->ui->auth-backend->AuthenticatesUsers.php
## Em AuthenticatesUsers.php ir na linha 157 e altrar para : "return 'cpf';"

## Login do sistema : cpf 123.456.789-01 senha: 123456