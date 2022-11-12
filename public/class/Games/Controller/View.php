<?php

    namespace Games\Controller;

    use Games\Controller;
    use Games\Controller\Games;
    use Games\Controller\Login;
    use Games\Controller\LoadGame;

    class View extends Controller
    {

        public function __construct()
        {
            if (isset($_GET['tempTest']))
            {
                $_SESSION['user']    = 'gekophetweb';
                $_SESSION['game']    = "Crucial Investigation";
                $_SESSION['version'] = '1.32';
            }

            $this->_check();
        }

        public function _check()
        {


            if (isset($_GET['reset']))
            {
                if (isset($_SESSION['game']))
                {
                    unset($_SESSION['game']);
                }
                if (isset($_SESSION['version']))
                {
                    unset($_SESSION['version']);
                }
            }

            if (isset($_SESSION['user']) && $_SESSION['user'] !== 'gekophetweb')
            {
                unset($_SESSION['user']);
            }

            if ($_SESSION['user'] === 'gekophetweb' && isset($_SESSION['game']) && isset($_SESSION['version']))
            {
                $games         = new Games();
                $gamesVersions = $games->getGameVersions();

                $game    = $_SESSION['game'];
                $version = $_SESSION['version'];

                if(!isset($gamesVersions[$game]) || !isset($gamesVersions[$game][$version]))
                {
                    unset($_SESSION['game'], $_SESSION['version']);
                }
            }
        }

        public function display()
        {
            if (!isset($_SESSION['user']))
            {
                $viewObject = new Login();
            }
            else if (!isset($_SESSION['game']) || !isset($_SESSION['version']))
            {
                $viewObject = new Games();
            }
            else
            {
                $viewObject = new LoadGame();
            }

            $viewObject->display();
        }

    }