<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use alerts\alerts\alerts;
    use account\common\managments\upload;
    use account\common\models\users;
    use permission\common\models\profiles;

    class addressNew extends action
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
            // self::setLayout(self::getHeartwoodLayouts().'/cooladmin1.phtml');

            $this->param('html', new html());
            $this->param('profiles', (new profiles())->dicionary());

            if(array_key_exists('cmVnaXN0ZXJBY2NvdW50',$_POST)){
                // recebe arquivo
                if(isset($_FILES)){
                    $result = (new Upload())->save('/users');
                    if($result['image']['status']){
                        $_POST['image'] = $result['image']['mensagem'];
                    }
                }

                // hash da senha 
                $_POST['password'] = md5($_POST['password']);

                $user = new users();
                $user->populate($_POST);
                if(!$user->save()){
                    alerts::set($user->getError(), alerts::BADGE_DANGER);
                    return $this->view();
                }
                alerts::set('Comunicação salva com sucesso.');
            }

            return $this->view();
        }

    }

?>