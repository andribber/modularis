# Modularis

Repositório contendo o código para gestão modularizada de negócios

## Requisitos

- Git
- [docker]
- [docker-compose] (instale preferencialmente o plugin, caso já não esteja instalado)

## Build das imagens Docker

Após realizar ter clonado o repositório no seu computador, execute os seguintes comandos na raiz do projeto:

1) `docker compose pull` para baixar as imagens necessárias
2) `docker compose build` para fazer o build das imagens

## Configuração

### ⚠️ Atenção

Durante os passos à seguir, o comando `docker compose run app` vai ser utilizado várias vezes, para evitar a repetição, vamos abreviar o comando para `dcra`.

### Configuração do ambiente

1) Copie o arquivo `.env.example` localizado na raiz do projeto para `.env` e edite-o conforme achar necessário
    - cp env.example .env
2) Execute o comando `dcra composer install` para instalar as dependências do projeto
3) Gere a chave de criptografia do Laravel com o comando `dcra php artisan key:generate`
4) Gere o secret do JWT com o comando `dcra php artisan jwt:secret`
5) Execute as migrations do projeto com `dcra php artisan migrate`
6) Faça o seed do banco com `dcra php artisan db:seed`

## Leitura recomendada

Para um melhor entendimento do que está acontecendo aqui, recomendo pesquisar sobre qualquer termo técnico que você desconheça, especialmente sobre `docker`, `docker compose` e `composer`.

[docker]: https://www.docker.com/
[docker-compose]: https://docs.docker.com/compose/
