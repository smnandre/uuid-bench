<?php

namespace App\Tests;

class MonoBench
{
    public const NB_ITER = 1000;

    public function benchUuidV4Before()
    {
        for ($i = 0; $i < self::NB_ITER; $i++) {
            $uuid = random_bytes(16);
            $uuid[6] = $uuid[6] & "\x0F" | "\x40";
            $uuid[8] = $uuid[8] & "\x3F" | "\x80";
            $uuid = bin2hex($uuid);
            $uuid = substr($uuid, 0, 8).'-'.substr($uuid, 8, 4).'-'.substr($uuid, 12, 4).'-'.substr($uuid, 16, 4).'-'.substr($uuid, 20, 12);
        }
    }

    public function benchUuidV4After()
    {
        for ($i = 0; $i < self::NB_ITER; $i++) {
            $uuid = bin2hex(random_bytes(18));
            $uuid[8] = $uuid[13] = $uuid[18] = $uuid[23] = '-';
            $uuid[14] = '4';
            $uuid[19] = ['8', '9', 'a', 'b', '8', '9', 'a', 'b', 'c' => '8', 'd' => '9', 'e' => 'a', 'f' => 'b'][$uuid[19]] ?? $uuid[19];
        }
    }
}

