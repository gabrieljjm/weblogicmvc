<?php

class User extends \ActiveRecord\Model
{
    static $validates_presence_of = array(
        array('id', 'message' => 'YooaaH it must be provided'),
        array('email', 'message' => 'YooaaH it must be provided'),
        array('username', 'message' => 'YooaaH it must be provided'),
        array('pwd', 'message' => 'YooaaH it must be provided')
    );
}
