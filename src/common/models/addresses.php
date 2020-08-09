<?php

namespace account\common\models;

use data\model\model;
use account\common\models\users;

class addresses extends model
{
    const TYPE_ALL      = 'all';
    const TYPE_BILLING  = 'billing';
    const TYPE_SHIPPING = 'shipping';

    const DEFAULT_YES = 'yes';
    const DEFAULT_NO  = 'no';

    const LIST_TYPE = array(
        self::TYPE_ALL      => 'Ambos',
        self::TYPE_BILLING  => 'Cobrança',
        self::TYPE_SHIPPING => 'Entregua'
    );

    const DICIONARY_TYPE = array(
        array(
            'value' => self::TYPE_ALL,
            'label' => self::LIST_TYPE[self::TYPE_ALL]
        ),
        array(
            'value' => self::TYPE_BILLING,
            'label' => self::LIST_TYPE[self::TYPE_BILLING]
        ),
        array(
            'value' => self::TYPE_SHIPPING,
            'label' => self::LIST_TYPE[self::TYPE_SHIPPING]
        ),
    );

    const LIST_DEFAULT = array(
        self::DEFAULT_YES => 'Sim',
        self::DEFAULT_NO  => 'Não'
    );

    const DICIONARY_DEFAULT = array(
        array(
            'value' => self::DEFAULT_YES,
            'label' => self::LIST_DEFAULT[self::DEFAULT_YES]
        ),
        array(
            'value' => self::DEFAULT_NO,
            'label' => self::LIST_DEFAULT[self::DEFAULT_NO]
        ),
    );

    public $table = 'addresses';
    public $key   = 'address_id';
    public $dicionary = "SELECT address_id as value, address as label FROM addresses;";

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
            'table'   => 'addresses',
            'key'     => 'address_id',
            'columns' => array(
                'address_id' => array(
                    'label' => 'Id',
                    'pk'    => true,
                    'type'  => 'integer',
                    'limit' => 11,
                ),
                'user_id' => array(
                    'label' => 'Nome',
                    'pk'    => false,
                    'type'  => 'integer',
                    'limit' => 11,
                ),
                'type' => array(
                    'label' => 'Tipo',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 15,
                ),
                'default' => array(
                    'label' => 'Principal',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 5,
                ),
                'company' => array(
                    'label' => 'Empresa',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 120,
                ),
                'address' => array(
                    'label' => 'Endereço',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 255,
                ),
                'address' => array(
                    'label' => 'Endereço',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 255,
                ),
                'complement' => array(
                    'label' => 'Complemento',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 255,
                ),
                'neighborhood' => array(
                    'label' => 'Bairro',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 120,
                ),
                'postcode' => array(
                    'label' => 'CEP',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 15,
                ),
                'city' => array(
                    'label' => 'Cidade',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 45,
                ),
                'state' => array(
                    'label' => 'Estado',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 2,
                ),
                'country' => array(
                    'label' => 'País',
                    'pk'    => false,
                    'type'  => 'varchar',
                    'limit' => 45,
                ),
            ),
        );
    }

    public function user()
    {
        if(empty($this->getField('user_id'))){
            return null;
        }

        return $this->manyForOne(new profiles(), 'user_id');
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
            $where = array('acc.active = 1');
        }

        return sprintf("SELECT 
                acc.*,
                usr.name as user_label
            FROM addresses AS acc
            JOIN users AS usr ON usr.user_id = acc.user_id AND usr.active = 1
            WHERE
                %s;",
            implode(' AND ', $where)
        );
    }
}
?>