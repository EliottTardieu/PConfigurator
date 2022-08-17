<?php

namespace PConfigurator\Models;

use AgileBundle\Utils\Dbg;
use Kreait\Firebase\Exception\DatabaseException;

class Component extends Model
{

    const STORAGE = 'components';

    const COLUMNS = ["id", "type", "name", "manufacturer", "obsolete"];

    public $name;
    public $type;
    public $manufacturer;
    public $obsolete;
}