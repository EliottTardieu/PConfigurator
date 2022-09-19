<?php

namespace PConfigurator\Models;

use AgileBundle\Utils\Dbg;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\DatabaseException;
use Kreait\Firebase\Exception\FirebaseException;
use PConfigurator\App;

class Component extends Model {

    const STORAGE = 'components';

    const COLUMNS = ["id", "type", "name", "manufacturer", "obsolete"];

    public $name;
    public $type;
    public $manufacturer;
    public $obsolete;

    /**
     * Sets the obsolete attribute of the component.
     *
     * @return bool
     */
    public function changeAbility(): bool {
        if ($this->obsolete == 0) {
            $this->obsolete = 1;
        } else {
            $this->obsolete = 0;
        }
        $this->save();
        return true;
    }
}