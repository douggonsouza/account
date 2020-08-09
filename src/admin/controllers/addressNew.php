<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use account\common\models\users;
    use account\common\models\addresses;
    use alerts\alerts\alerts;

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
            self::setLayout(self::getHeartwoodLayouts().'/cooladmin1.phtml');

            $this->param('html', new html());
            $this->param('addresses', new addresses());
            $this->param('users', (new users())->dicionary());

            if(array_key_exists('bmV3QWRkcmVzcw==',$_POST)){
                $address = new addresses();
                $address->populate($_POST);
                if(!$address->save()){
                    alerts::set($address->getError(), alerts::BADGE_DANGER);
                    return $this->view();
                }
                alerts::set('Endereço salva com sucesso.');
            }

            return $this->view();
        }

    }

?>