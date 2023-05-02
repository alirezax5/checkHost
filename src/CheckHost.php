<?php

namespace Alirezax5\CheckHost;
class CheckHost
{
    private $host, $request_id;
    private $checkHostUrl = [
        'ping' => 'https://check-host.net/check-ping',
        'http' => 'https://check-host.net/check-http',
        'tcp' => 'https://check-host.net/check-tcp',
        'dns' => 'https://check-host.net/check-dns',
        'check' => 'https://check-host.net/check-result/',
        'listNode' => 'https://check-host.net/nodes/hosts'
    ];
    private $checkHostNods = [
        'ae1' => 'ae1.node.check-host.net',
        'at1' => 'at1.node.check-host.net',
        'au1' => 'au1.node.check-host.net',
        'bg1' => 'bg1.node.check-host.net',
        'br1' => 'br1.node.check-host.net',
        'ch1' => 'ch1.node.check-host.net',
        'cz1' => 'cz1.node.check-host.net',
        'de1' => 'de1.node.check-host.net',
        'de4' => 'de4.node.check-host.net',
        'fi1' => 'fi1.node.check-host.net',
        'fr1' => 'fr1.node.check-host.net',
        'fr2' => 'fr2.node.check-host.net',
        'hk1' => 'hk1.node.check-host.net',
        'il1' => 'il1.node.check-host.net',
        'ir1' => 'ir1.node.check-host.net',
        'ir3' => 'ir3.node.check-host.net',
        'ir4' => 'ir4.node.check-host.net',
        'it2' => 'it2.node.check-host.net',
        'jp1' => 'jp1.node.check-host.net',
        'kz1' => 'kz1.node.check-host.net',
        'lt1' => 'lt1.node.check-host.net',
        'md1' => 'md1.node.check-host.net',
        'nl1' => 'nl1.node.check-host.net',
        'pl1' => 'pl1.node.check-host.net',
        'pl2' => 'pl2.node.check-host.net',
        'pt1' => 'pt1.node.check-host.net',
        'rs1' => 'rs1.node.check-host.net',
        'ru1' => 'ru1.node.check-host.net',
        'ru2' => 'ru2.node.check-host.net',
        'ru3' => 'ru3.node.check-host.net',
        'ru4' => 'ru4.node.check-host.net',
        'th1' => 'th1.node.check-host.net',
        'tr1' => 'tr1.node.check-host.net',
        'tr2' => 'tr2.node.check-host.net',
        'ua1' => 'ua1.node.check-host.net',
        'ua2' => 'ua2.node.check-host.net',
        'ua3' => 'ua3.node.check-host.net',
        'uk1' => 'uk1.node.check-host.net',
        'us1' => 'us1.node.check-host.net',
        'us3' => 'us3.node.check-host.net',
    ];
    private $nodes = [];

    public function __construct($host)
    {
        $this->host = $host;
    }

    public function request($rout)
    {
        $ch = curl_init();
        $options = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->buildUrl($rout),
            CURLOPT_POST => 1,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["Accept: application/json"],
        ];
        curl_setopt_array($ch, $options);
        $StatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $res = curl_exec($ch);
        return json_decode($res, true);
    }

    private function buildUrl($rout)
    {
        if (in_array($rout, ['ping', 'http', 'tcp', 'dns']))
            return $this->checkHostUrl[$rout] . '?host=' . $this->host . $this->buildNode();

        if ($rout == 'check')
            return $this->checkHostUrl[$rout] . $this->request_id;

        return $this->checkHostUrl[$rout];
    }

    private function buildNode()
    {
        if (count($this->nodes) == 0)
            return;

        $st = '';
        foreach ($this->nodes as $item) {
            $st .= '&node=' . $this->checkHostNods[$item];
        }
        return $st;
    }

    private function requestCheck($method)
    {
        $ping = $this->request($method);
        $this->request_id = $ping["request_id"];
        sleep(10);
        return $this;
    }

    public function nodesList()
    {
        return $this->request('listNode');
    }

    public function ping()
    {
        return $this->requestCheck('ping')->request('check');
    }

    public function http()
    {
        return $this->requestCheck('http')->request('check');
    }

    public function tcp()
    {
        return $this->requestCheck('tcp')->request('check');
    }

    public function dns()
    {
        return $this->requestCheck('dns')->request('check');
    }

    public function node($name)
    {
        if (!isset($this->checkHostNods[$name]))
            throw new \ErrorException($name . ' not node', 0);

        $this->nodes[] = $name;
        return $this;
    }
}