# hiae-laravel-test - Klisóstom

### Passos para executar a aplicação:

- Abrir o terminal na raiz do projeto.
- Executar os comandos:
  - `docker-compose build`
  - `docker-compose up -d`

### Para executar os testes:
- Entrar no container do docker com o comando:
  - `docker exec -it backend-test-app bash`
  - Executar o comando `./vendor/bin/pest` ou `./vendor/bin/pest --testdox`

#### Tecnologias utilizadas:
- php 8.1.1
- docker compose 3.7
- laravel 9.x
