<?php

    namespace Games\Controller;

    use Games\Controller;

    class Games extends Controller
    {
        const GAME_FOLDER = '/var/www/vhosts/gekophetweb.nl/games/';

        protected array $_games         = array();
        protected array $_gamesVersions = array();

        public function __construct()
        {
            $this->readFolder(static::GAME_FOLDER);
        }

        /**
         * @return array
         */
        public function getGameVersions(): array
        {
            return $this->_gamesVersions;
        }

        /**
         * Read games folder on server
         * @param string $folder
         * @param bool $isGame
         * @return array
         */
        public function readFolder(string $folder, bool $isGame = false): array
        {
            $folders           = array();
            $data              = scandir($folder);
            $scanned_directory = array_diff($data, array('..', '.'));

            foreach ($scanned_directory as $dir)
            {
                if (is_dir($folder.$dir))
                {
                    $folders[$dir] = $folder.$dir;

                    if (!$isGame)
                    {
                        $versions                   = $this->readFolder($folder.$dir."/", true);
                        $this->_gamesVersions[$dir] = $versions;
                    }
                }
            }

            if (!$isGame)
            {
                $this->_games = $folders;
            }

            return $folders;
        }

        /**
         * @return void
         */
        public function display()
        {
            $page = "gameList";

            $backgroundId = rand(1, 11);

            if ($backgroundId < 10)
            {
                $backgroundId = "0".$backgroundId;
            }

            include_once(SITE_SNIPPETS_PATH."display.php");
        }

        /**
         * @return void
         */
        public function displayGames()
        {
            $games = $this->_games;
            foreach ($games as $game => $location)
            {
                include(SITE_SNIPPETS_PATH."component/game.php");
            }
        }

        /**
         * @return void
         */
        public function displayVersions()
        {
            $version = $this->_gamesVersions;
            foreach ($version as $game => $versions)
            {
                foreach ($versions as $version => $location)
                {
                    include(SITE_SNIPPETS_PATH."component/version.php");
                }
            }
        }

        /**
         * @return void
         */
        public function displayScripts()
        {
            $scripts = array(
                "https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js",
                "/js/main.js",
                "/js/games.js",
            );

            foreach ($scripts as $jsFile)
            {
                include(SITE_SNIPPETS_PATH."component/script.php");
            }
        }

    }