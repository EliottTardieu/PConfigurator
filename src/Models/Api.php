<?php

namespace PConfigurator\Models;

class Api extends Model {

    const STORAGE = 'apis';

    const COLUMNS = ["id", "name", "url", "valid"];

    public $name;
    public $url;
    public $valid;

    /**
     * Sets the obsolete attribute of the component.
     *
     * @return bool
     */
    public function changeAbility(): bool {
        if ($this->valid == 0) {
            $this->valid = 1;
        } else {
            $this->valid = 0;
        }
        $this->save();
        return true;
    }
}