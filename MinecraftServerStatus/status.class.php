<?php

    class MinecraftServerStatus {

        public function getStatus($host = '127.0.0.1', $port = 25565) {

            if (substr_count($host , '.') != 4) {
                $host = gethostbyname($host);
            }

            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $connect = socket_connect($socket, $host, $port);

            if ($connect) {

                socket_send($socket, "\xFE", 1, 0);
                $d = '';
                socket_recv($socket, $d, 150, 0);
                socket_close($socket);

                $result = (String)$d;
                $result =  explode("\xA7", $result);

                $players = $result[sizeof($result)-2];
                $slots = $result[sizeof($result)-1];
                
                $res = array();
                $res['hostname'] = $host;
                $res['players'] = $players;
                $res['maxplayers'] = $slots;
                return $res;

            } else {

                return false;

            }

        }

    }

?>