<?php

namespace PConfigurator\Models;

class UserRequest extends Model {

    const STORAGE = 'requests';

    const COLUMNS = ["id", "title", "content", "author", "date", "status"];

    public $title;
    public $content;
    public $author;
    public $date;
    public $status;
}