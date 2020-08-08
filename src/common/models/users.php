<?php

namespace account\common\models;

use data\model\model;
use permission\common\models\profiles;

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
                'document' => array(
                    'label' => 'Documento',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 45,
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
                'image' => array(
                    'label' => 'Foto',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 255,
                ),
                'token' => array(
                    'label' => 'Token',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 160,
                ),
                'password' => array(
                    'label' => 'Senha',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 90,
                ),
            ),
        );
    }

    public function profile()
    {
        if(empty($this->getField('profile_id'))){
            return null;
        }

        return $this->manyForOne(new profiles(), 'profile_id');
    }

    /**
     * Devolve sql para a realização da busca
     *
     * @param string $where
     * @return string
     */
    public function sqlSeek(array $where = null)
    {
        if(!isset($where) || empty($where)){
            $where = array('usr.active = 1');
        }

        return sprintf("SELECT 
                usr.*,
                prf.label as profile_label
            FROM users AS usr
            JOIN profiles AS prf ON prf.profile_id = usr.profile_id AND prf.active = 1
            WHERE
                %s;",
            implode(' AND ', $where)
        );
    }
}
?>