<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use account\common\models\addresses;
    use account\common\models\users;
    use alerts\alerts\alerts;

    class address extends action
    {
        const _LOCAL = __DIR__;

        /**
         * Função a ser executada no contexto da action
         *
         * @param array $info
         * @return void
         */
        public function main(array $info)
        {
            self::setLayout(self::getHeartwoodLayouts().'/cooladmin1.phtml');

            $this->param('html', new html());
            $this->param('addresses', new addresses());
            $this->param('registros', new addresses());
            $this->param('users', (new users())->dicionary());

            $search = $this->where();
            if(array_key_exists('c2VhcmNoQWRkcmVzc2Vz',$_POST)){
                $search = $this->where($_POST);
            }

            $address = (new addresses())->seek($search);
            if(!$address->isNew()){
                $this->param('registros', $address);
            }

            return $this->view();
        }

        /**
         * Cria o array de busca
         *
         * @param array $post
         * @return void
         */
        protected function where(array $post = null)
        {
            $search = array('acc.active = 1');

            if(!isset($post) || empty($post)){
                return $search;
            }

            if(isset($post['user_id']) && !empty($post['user_id'])){
                $search['user_id'] = "acc.user_id = ".$post['user_id'];
            }

            if(isset($post['address']) && !empty($post['address'])){
                $search['address'] = "acc.address like '%".$post['address']."%'";
            }

            return $search;
        }

    }

?>