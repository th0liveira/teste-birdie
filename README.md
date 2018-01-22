# [ Teste Birdie ]

Link: https://gist.github.com/meneguite/33d4a486c2b938631db0eff6f105fa26

### Ambiente

Ambiente utilizando Docker para funcionamento, onde possui os seguintes containers:

- **Nginx:** servidor de aplicação;
- **PHP-FPM:** PHP 7 com extensão para MongoDB e Redis;
- **MongoDB:** utilizado para armazenamento dos dados do TXT;
- **Redis:** utilizado para cache.

Além dos containers acima, outros dois são provisionados para preparo do ambiente, porém os mesmos só executam ao iniciar o ambiente, são eles:
- Container com mongo, responsável por inicializar o DB e Collection no container do MongoDB.  
- Container com PHP Composer, para instalar a dependência do projeto

### Iniciando o Ambiente

Para inicializar o ambiente, basta executar:

`# docker-composer up`

### Executando a Aplicação

Basta  acessar em qualquer navegador:

`http://18.1.22.2/`