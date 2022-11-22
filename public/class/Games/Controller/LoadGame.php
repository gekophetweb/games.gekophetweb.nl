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
            $mimeType = mime_content_type($fileLoc);
            ob_get_clean();
            header('Content-type: '.$mimeType);
            $this->displayVideoFile($fileLoc, $mimeType);
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

                if (!is_file($dir.$file) && strstr($file, "/ui/"))
                {
                    $file = str_replace("/ui/", "/UI/", $file);
                }

                if (is_file($dir.$file))
                {
                    $this->displayFile($dir.$file);
                }
            }

            if (!isset($_GET['file']) || !stristr($_GET['file'], "."))
            {
                foreach ($scanned_directory as $file)
                {
                    if (is_file($dir.$file) && stristr($file, ".html") && !stristr($file, ".html.tmp"))
                    {
                        require($dir.$file);
                    }
                }
            }
        }

        public function displayVideoFile(string $path, string $mimeType)
        {
            $size = filesize($path);

            $fm = @fopen($path, 'rb');
            if (!$fm)
            {
                // You can also redirect here
                header("HTTP/1.0 404 Not Found");
                die();
            }

            $begin = 0;
            $end   = $size;

            if (isset($_SERVER['HTTP_RANGE']))
            {
                if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches))
                {
                    $begin = intval($matches[0]);
                    if (!empty($matches[1]))
                    {
                        $end = intval($matches[1]);
                    }
                }
            }

            if ($begin > 0 || $end < $size)
            {
                header('HTTP/1.0 206 Partial Content');
            }
            else
            {
                header('HTTP/1.0 200 OK');
            }

            header("Content-Type: ".$mimeType);
            header('Accept-Ranges: bytes');
            header('Content-Length:'.($end - $begin));
            header("Content-Disposition: inline;");
            header("Content-Range: bytes $begin-$end/$size");
            header("Content-Transfer-Encoding: binary\n");
            header('Connection: close');

            $cur = $begin;
            fseek($fm, $begin, 0);

            while (!feof($fm) && $cur < $end && (connection_status() == 0))
            {
                print fread($fm, min(1024 * 16, $end - $cur));
                $cur += 1024 * 16;
            }
            die();
        }

    }