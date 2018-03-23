<?php

class JsonConnexion implements IRequestConnexion
{

    public function __construct(array $idents)
    {
        parent::__construct($idents);
    }
}