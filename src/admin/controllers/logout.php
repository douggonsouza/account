<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use account\common\models\users;

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
            self::setLayout(self::getHeartwoodLayouts().'/cooladmin1.phtml');

            return $this->view();
        }

    }

?>