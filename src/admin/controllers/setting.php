<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use account\common\models\users;
    use permission\common\models\profiles;

    class setting extends action
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
            $this->param('profiles', (new profiles())->dicionary());

            $user = (new users())->search(
                array(
                    'user_id' => $info['url'][1]
                )
            );
            if(!$user->isNew()){
                $this->param('user', $user);
            }

            return $this->view();
        }

    }

?>