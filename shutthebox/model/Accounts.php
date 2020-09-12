<?php

class Accounts extends \ActiveRecord\Model
{
    static $validates_presence_of = array(
        array('user_id', 'message' => 'YooaaH it must be provided'),
        array('valor', 'message' => 'YooaaH it must be provided'),
        array('descricao', 'message' => 'YooaaH it must be provided'),
        array('data', 'message' => 'YooaaH it must be provided'),

    );
}