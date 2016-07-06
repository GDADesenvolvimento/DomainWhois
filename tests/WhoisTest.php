<?php
namespace DomainWhois\Tests;

use DomainWhois\Whois;


class WhoisTest extends \PHPUnit_Framework_TestCase
{
    public function test_set_domain()
    {
        $whois = new Whois("terra.com.br");
        $this->assertEquals("terra.com.br", $whois->getDomain());

        $whois = new Whois("http://terra.com.br");
        $this->assertEquals("", $whois->getDomain());

        $whois = new Whois("www.terra.com.br");
        $this->assertEquals("", $whois->getDomain());

        $whois = new Whois("http://www.terra.com.br");
        $this->assertEquals("", $whois->getDomain());
    }

    public function test_get_owner()
    {
        $whois = new Whois("terra.com.br");

        $this->assertEquals("Terra Networks Brasil S.A.", $whois->getOwner());
        $this->assertEquals("1998-01-22", $whois->getCreated());
    }
}