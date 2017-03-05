<?php

namespace Koalamon\CookieMakerHelper;

class CookieMaker
{
    private $executable;

    private static function escapeForCommandLine($string)
    {
        $jsonString = str_replace(' ', '##space##', trim($string));
        return $jsonString;
    }

    public function __construct($executable = './CookieMaker')
    {
        $this->executable = $executable;
    }

    public function getCookies($session)
    {
        if ($session == "[]" || $session == "") {
            return [];
        }

        if (!is_string($session)) {
            $session = json_encode($session);
        }

        $session = $this->escapeForCommandLine("'" . $session . "'");

        $command = $this->executable . " " . $session;

        exec($command, $output, $result);

        if (empty($output)) {
            return [];
        }

        $cookies = json_decode($output[0], true);

        return $cookies;
    }

    public function getCookieString($session)
    {
        $cookies = $this->getCookies($session);

        $cookieString = "";
        foreach ($cookies as $key => $value) {
            $cookieString .= $key . '=' . $value . '; ';
        }
        return $cookieString;
    }
}
