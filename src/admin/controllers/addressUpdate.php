<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use account\common\models\users;
    use account\common\models\addresses;
    use alerts\alerts\alerts;

    class addressUpdate extends action
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
            $this->param('address', new addresses());
            $this->param('users', (new users())->dicionary());

            if(array_key_exists('dXBkYXRlQWRkcmVzcw==',$_POST)){
                $address = new addresses();
                $address->populate($_POST);
                if(!$address->save()){
                    alerts::set($address->getError(), alerts::BADGE_DANGER);
                    $address = (new addresses())->search(
                        array(
                            'user_id' => $info['url'][1]
                        )
                    );
                    if(!$address->isNew()){
                        $this->param('address', $address);
                    }
            
                    return $this->view();
                }
            }

            $address = (new addresses())->search(
                array(
                    'address_id' => $info['url'][1]
                )
            );
            if(!$user->isNew()){
                $this->param('address', $address);
            }

            return $this->view();
        }

    }

?>