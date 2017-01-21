<?php

namespace Koalamon\CookieMakerHelper;

class CookieMaker
{
    private $executable;

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
        $command = $this->executable . " '" . $session . "'";
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
