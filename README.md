# example-app
App examplo usando Laravel + Vue 
![](https://raw.githubusercontent.com/silvajunior/example-app/refs/heads/main/example-app_laravel_vue.png)
Clone project and Go to app.
```bash
git clone git@github.com:silvajunior/example-app.git
cd example-app
```
Instale dependências
```bash
composer install
npm install
```
Copie o .env.example para .env
```bash
cp .env.example .env
```
Para teste de envio de e-mail foi usado o Mailtrap.
Vá em .env e altere para seu usuário e senha.
```bash
MAIL_MAILER=smtp
#MAIL_SCHEME=null
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=usuario
MAIL_PASSWORD=senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@mailtrap.io"
MAIL_FROM_NAME="${APP_NAME}"
```
Obs: Em produção pode ser usado um outro smtp, como o do google, com a porta 587 e as demais credenciais.
Teste
```bash
php artisan test --filter=ApplicationControllerTest
```
Rode o projeto
```bash
composer run dev
```
