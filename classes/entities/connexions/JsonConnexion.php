<?php

namespace sql_links\Entities\connexions;

use \sql_links\Entities\extended\ExtendedRequestConnexion;

class JsonConnexion extends ExtendedRequestConnexion
{
    public function __construct(array $idents)
    {
        if(count($idents) > 1) {
            $this->database($idents['path_to_database'].'/'.$idents['database']);
        }
        else {
            parent::__construct($idents);
        }
    }

    protected   $path_to_database = '';
    protected	$database = '';
}