<?php
// Package\Uc\DataStruct/JwtConfig


namespace Package\Uc\DataStruct;


class JwtConfig
{
    public function __construct(string $key, int $ttl)
    {
        $this->key = $key;
        $this->ttl = $ttl;
    }

    public string $key;

    public int $ttl;
}