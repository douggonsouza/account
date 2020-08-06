<?php

namespace account\common\models;

use data\model\model;

class users extends model
{
    public $table = 'users';
    public $key   = 'user_id';
    public $dicionary = "SELECT user_id as value, name as label FROM users;";

    /**
     * Evento construtor da classe
     */
    public function __construct()
    {
        parent::__construct($this->visibleColumns()['table'], $this->visibleColumns()['key']);
    }

    /**
     * Informações das colunas visíveis
     *
     * @return void
     */
    public function visibleColumns()
    {
        return array(
            'table'   => 'users',
            'key'     => 'user_id',
            'columns' => array(
                'user_id' => array(
                    'label' => 'Id',
                    'pk'    => true,
                    'type'  => 'integer',
                    'limit' => 11,
                ),
                'name' => array(
                    'label' => 'Nome',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 120,
                ),
                'profile_id' => array(
                    'label' => 'Perfil',
                    'pk'    => false,
                    'type'  => 'integer',
                    'limit' => 11,
                ),
                'email' => array(
                    'label' => 'E-mail',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 255,
                ),
                'birth' => array(
                    'label' => 'Nascimento',
                    'pk'    => false,
                    'type'  => 'date',
                    'limit' => 10,
                ),
                'ddd' => array(
                    'label' => 'DDD',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 3,
                ),
                'phone' => array(
                    'label' => 'Fone',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 15,
                ),
                'token' => array(
                    'label' => 'Token',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 160,
                ),
            ),
        );
    }

    public function profile()
    {
        if(empty($this->getField('profile_id'))){
            return null;
        }

        return $this->manyForOne(new permission\common\models\profiles(), 'profile_id');
    }
}
?>