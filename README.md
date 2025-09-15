# example-app
App examplo usando Laravel + Vue 

Clone project and Go to app.
```bash
git clone https://github.com/silvajunior/example-app.git
cd example-app
```
Instale dependências
```bash
composer install
npm install
```
Rodar o projeto
```bash
composer run dev
```
Copie o .env.example para .env
```bash
cp .env.example .env
```
Para teste de envio de e-mail esta sendo usado o Mailtrap.
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
Em produção pode ser usado um outro smtp, como o do google, com a porta 587 e as demais credenciais.
