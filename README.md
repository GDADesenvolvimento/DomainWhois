# DomainWhois
Lib para fazer o consulta dos whois de um domínio

## Exemplo
```php
<?php

//EXEMPLO
use DomainWhois\Whois;
$whois = new Whois("terra.com.br");
$whois->getDomain() //Retorna o dominio
$whois->getOwner() //Retorna o Dono
$whois->getCreated() //Retorna a data de criação do dominio
?>
```
