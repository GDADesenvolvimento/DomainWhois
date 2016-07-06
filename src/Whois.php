<?php
namespace DomainWhois;


class Whois
{
    private $domain;
    private $owner;
    private $ownerid;
    private $responsible;
    private $country;
    private $owner_c;
    private $admin_c;
    private $tech_c;
    private $billing_c;
    private $nserver1;
    private $nserver2;
    private $nserver3;
    private $nserver4;
    private $saci;
    private $created;
    private $expires;
    private $changed;
    private $status;
    private $nic_hdl_br;
    private $person;
    private $e_mail;

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain($domain)
    {
        if(!preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $domain)) {
            return false;
        }

        $this->domain = $domain;
        return $this;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    private function setOwner($owner)
    {
        $owner = trim($owner);
        $this->owner = $owner;
        return $this;
    }

    public function getCreated() {
        return $this->created;
    }

    private function setCreated($created) {
        $created = trim($created);
        if( !empty($created) ){
            if( strpos($created, "-") !== false ){
                $created = substr($created, 0, 10);
                $this->created = $created;
            }else{
                $created = substr($created, 0, 4)."-".substr($created, 4, 2)."-".substr($created, 6, 2);
                $this->created = $created;
            }
        }
        return $this;
    }

    public function getExpires() {
        return $this->expires;
    }

    private function setExpires($expires){
        $expires = trim($expires);
        if( strpos($expires, "-") !== false ){
            $expires = substr($expires, 0, 10);
            $this->expires = $expires;
        }else{
            $expires = substr($expires, 0, 4)."-".substr($expires, 4, 2)."-".substr($expires, 6, 2);
            $this->expires = $expires;
        }
        return $this;
    }

    public function getChanged() {
        return $this->changed;
    }

    private function setChanged($changed){
        $changed = trim($changed);
        if( strpos($changed, "-") !== false ){
            $changed = substr($changed, 0, 10);
            $this->changed = $changed;
        }else{
            $changed = substr($changed, 0, 4)."-".substr($changed, 4, 2)."-".substr($changed, 6, 2);
            $this->changed = $changed;
        }
        return true;
    }

    public function getStatus() {
        return $this->status;
    }

    private function setStatus($status){
        $status = trim($status);
        $this->status = $status;
        return $this;
    }



    function __construct($domain)
    {
        $this->setDomain($domain);

        $WhoisServer = new WhoisServer();
        $returnRquest = $WhoisServer->LookupDomain($domain);
        $this->getReturn($returnRquest);
    }

    private function getReturn($result){

        $linhas = explode("\n", $result);

        foreach( $linhas as $linha ){

            //SET OWNER
            if( strpos($linha, "owner:") !== false ){
                $this->setOwner(str_replace("owner:     ", "",      $linha));
            }elseif( strpos($linha, "Admin Name:") !== false ){
                $this->setOwner(str_replace("Admin Name: ", "",      $linha));
            }

            //SET CREATED
            if( strpos($linha, "created:") !== false ){
                $this->setCreated(str_replace("created:     ", "",      $linha));
            }elseif( strpos($linha, "Creation Date:") !== false ){
                $this->setCreated(str_replace("Creation Date: ", "",      $linha));
            }

            //SET EXPIRES
            if( strpos($linha, "expires:") !== false ){
                $this->setExpires(str_replace("expires:     ", "",      $linha));
            }elseif( strpos($linha, "Registrar Registration Expiration Date:") !== false ){
                $this->setExpires(str_replace("Registrar Registration Expiration Date: ", "",      $linha));
            }

            //SET CHANGED
            if( strpos($linha, "changed:") !== false ){
                $this->setChanged(str_replace("changed:     ", "",      $linha));
            }elseif( strpos($linha, "Updated Date:") !== false ){
                $this->setChanged(str_replace("Updated Date: ", "",      $linha));
            }

            //SET STATUS
            if( strpos($linha, "status:") !== false ){
                $this->setStatus(str_replace("status:      ", "",       $linha));
            }elseif( strpos($linha, "Domain Status:") !== false ){
                $status = str_replace("Domain Status: ", "",       $linha);
                $status = dirname($status);
                $status = substr($status, 0, strpos($status, " "));
                $this->setStatus($status);
            }else{
                if( $this->getExpires() > date("Y-m-d") ){
                    $this->setStatus('published');
                }
            }
        }
    }
}