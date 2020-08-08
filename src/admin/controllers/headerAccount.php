<?php

    namespace account\admin\controllers;

    use driver\control\action;
    use driver\helper\html;
    use account\common\models\users;
    use driver\router\router;
    use alerts\alerts\alerts;

    class headerAccount extends action
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
            self::setLayout(__DIR__.'/../responses/headerAccount.phtml');
            
            return $this->view();
        }

    }

?>