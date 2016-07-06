<?php
require_once "../vendor/autoload.php";

use DomainWhois\Whois;

echo "<pre>";
$whois = new Whois("terra.com.br");
var_dump($whois);
echo "</pre>";
