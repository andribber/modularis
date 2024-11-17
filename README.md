# Modularis

Repositório contendo o código para gestão modularizada de negócios

## Requisitos

-   Git
-   [docker]
-   [docker-compose] (instale preferencialmente o plugin, caso já não esteja instalado)

## Build das imagens Docker

Após realizar ter clonado o repositório no seu computador, você deve acessar os diretórios `app_backend` e `app_frontend` e executar os seguintes comandos em cada diretório:

1. `docker compose pull` para baixar as imagens necessárias
2. `docker compose build --no-cache` para fazer o build das imagens
3. `docker compose up -d --wait` para fazer iniciar o container
3. `docker compose donw --remove-orphans` para fazer parar o container

## Configuração

### Configuração do ambiente BACKEND

#### ⚠️ Atenção

Para esse trecho deve acessar o diretório `app_backend` e seguir as instruções:

Durante os passos à seguir, o comando `docker compose run api` vai ser utilizado várias vezes, para evitar a repetição, vamos abreviar o comando para `dcra`.

1. Copie o arquivo `.env.example` para `.env` e edite-o conforme achar necessário
    - cp env.example .env
2. Execute o comando `dcra composer install` para instalar as dependências do projeto
3. Gere a chave de criptografia do Laravel com o comando `dcra php artisan key:generate`
4. Gere o secret do JWT com o comando `dcra php artisan jwt:secret`
5. Execute as migrations do projeto com `dcra php artisan migrate`
6. Faça o seed do banco com `dcra php artisan db:seed`

### Configuração do ambiente FRONTEND

Para esse trecho deve acessar o diretório `app_frontend` e seguir as instruções:

1. Copie o arquivo `.env.example` para `.env` e edite-o conforme achar necessário
    - cp env.example .env
2. Execute o comando: `openssl rand -base64 32`, depois pegue o valor que aparecer e coloque no arquivo `.env` em frente ao `NEXTAUTH_SECRET=`. Caso você queria compartilhar a sessão do usuário entre a dashboard e o checkout, você deve colocar o mesmo valor no arquivo `.env` do checkout. A sessão compartilhada só funcionará se os protocolos comunicação de rede de ambos os projetos forem iguais (HTTP ou HTTPS).
3. Instale as dependências do ambiente de desenvolvimento executando o comando: `docker compose run app npm install`
4. Suba o ambiente para desenvolvimento executando o comando: `docker compose up app`
5. No navegador acesse o endereço http://modularis.localhost/ para visualizar o projeto rodando.

## Leitura recomendada

Para um melhor entendimento do que está acontecendo aqui, recomendo pesquisar sobre qualquer termo técnico que você desconheça, especialmente sobre `docker`, `docker compose` e `composer`.

[docker]: https://www.docker.com/
[docker-compose]: https://docs.docker.com/compose/
