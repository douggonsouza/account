<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use account\common\models\users;
    use alerts\alerts\alerts;

    class account extends action
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

            $search = $this->where();
            if(array_key_exists('c2VhcmNoQWNjb3VudA==',$_POST)){
                $search = $this->where($_POST);
            }
    
            $this->param('registros', new users());
            $users = (new users())->seek($search);
            if(!$users->isNew()){
                $this->param('registros', $users);
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
            $search = array('usr.active = 1');

            if(!isset($post) || empty($post)){
                return $search;
            }

            if(isset($post['name']) && !empty($post['name'])){
                $search['name'] = "usr.name like '%".$post['name']."%'";
            }

            if(isset($post['email']) && !empty($post['email'])){
                $search['email'] = "usr.email like '%".$post['email']."%'";
            }

            return $search;
        }

    }

?>