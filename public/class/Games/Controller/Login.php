<?php

    namespace Games\Controller;

    use Games\Controller\LoadGames;
    use Games\Controller;

    class Login extends Controller
    {

        protected bool $_verified = false;

        public function __construct()
        {
            if (isset($_POST) && !empty($_POST))
            {
                $this->_verifyInput();
            }
        }

        /**
         * @return void
         */
        protected function _verifyInput(): void
        {
            $user     = '';
            $password = '';
            $token    = '';

            if (!empty($_POST['user']))
            {
                $user = $_POST['user'];
            }

            if (!empty($_POST['password']))
            {
                $password = $_POST['password'];
            }

            if (!empty($_POST['token']))
            {
                $token = $_POST['token'];
            }


            if ($_SESSION['token'] === $token && $user === 'gekophetweb' && $password === 'Tzpr7RS9')
            {
                $this->_verified  = true;
                $_SESSION['user'] = 'gekophetweb';
            }
        }

        public function display(): void
        {
            if ($this->_verified)
            {
                $loadGames = new Games();
                $loadGames->display();
                return;
            }

            $backgroundId = rand(1, 11);

            if($backgroundId < 10)
            {
                $backgroundId = "0".$backgroundId;
            }

            $token             = md5("games---".strtotime("now"));
            $_SESSION['token'] = $token;

            $page = "login";

            include_once(SITE_SNIPPETS_PATH."display.php");
        }

          public function displayScripts()
        {
            $scripts = array(
                "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js",
                "/js/main.js",
            );

            foreach ($scripts as $jsFile)
            {
                include(SITE_SNIPPETS_PATH."component/script.php");
            }
        }

    }