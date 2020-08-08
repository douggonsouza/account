<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use account\common\models\users;
    use driver\router\router;
    use alerts\alerts\alerts;

    class login extends action
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
            self::setLayout(self::getHeartwoodLayouts().'/login.phtml');

            if(array_key_exists('bG9naW5Vc2Vy',$_POST)){
                $user = (new users())->search(
                    array(
                        'email'    => $_POST['email'],
                        'password' => md5($_POST['password'])
                    )
                );
                if($user->isNew()){
                    alerts::set('Não encontrado usuário.', alerts::BADGE_DANGER);
                    return $this->view();
                }

                if(!$this->login($user->getData())){
                    alerts::set('Não foi possível salvar usuário na sessão.', alerts::BADGE_DANGER);
                    return $this->view();
                }

                router::relativeRedirection('/');
            }
            
            return $this->view();
        }

        protected function login(array $user)
        {
            if(!isset($user) || empty($user)){
                return false;
            }

            unset($user['password']);
            unset($user['token']);
            unset($user['document']);
            unset($user['active']);

            $_SESSION['login'] = $user;

            return true;
        }

    }

?>