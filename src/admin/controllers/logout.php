<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use account\common\models\users;
    use alerts\alerts\alerts;

    class logout extends action
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
            if(!$this->logout()){
                alerts::set('Não foi possível limpar a sessão do usuário.', alerts::BADGE_DANGER);
            }

            router::relativeRedirection('/');
        }

        protected function logout()
        {
            if(!isset($_SESSION['login'])){
                return false;
            }
            
            try{
                unset($_SESSION['login']);
            }catch(\Exception $e){
                return false;
            }

            return true;
        }

    }

?>