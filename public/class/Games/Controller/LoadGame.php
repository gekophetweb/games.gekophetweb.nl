<?php

    namespace Games\Controller;

    use Games\Controller;
    use Games\Controller\Games;

    class LoadGame extends Controller
    {
        protected string $_game;
        protected string $_version;
        protected string $_gameLocation;

        public function __construct()
        {
            $game                = $this->game = $_SESSION['game'];
            $version             = $this->version = $_SESSION['version'];
            $games               = new Games();
            $gamesVersions       = $games->getGameVersions();
            $this->_gameLocation = $gamesVersions[$game][$version]."/";
        }

        public function displayFile(string $fileLoc): void
        {
            $mimeType     = mime_content_type($fileLoc);
            header('Content-type: ' . $mimeType);
            require($fileLoc);
            exit;
        }

        public function display()
        {
            $dir = $this->_gameLocation;

            $data              = scandir($dir);
            $scanned_directory = array_diff($data, array('..', '.'));

            if (isset($_GET['file']))
            {
                $file = $_GET['file'];
                if (is_file($dir.$file))
                {
                    $this->displayFile($dir.$file);
                }
            }

            foreach ($scanned_directory as $file)
            {
                if (is_file($dir.$file) && stristr($file, ".html") && !stristr($file, ".html.tmp"))
                {
                    require($dir.$file);
                }
            }
        }

    }