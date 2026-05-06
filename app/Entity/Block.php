<?php

namespace App\Entity;

class Block
{
    private int $index;
    private string $data;
    private int $timestamp;
    private string $previousHash = '';
    private string $hash = '';


    public function __construct(int $index, string $previousHash, string $data){
        $this->index = $index;
        $this->previousHash = $previousHash;
        $this->data = $data;
        $this->timestamp = time();
    }

    public function setHash(string $hash): self{
        $this->hash = $hash;
        return $this;
    }

    public function getIndex(): int{
        return $this->index;
    }

    public function getHash(): string{
        return $this->hash;
    }

    public function getPreviousHash(): string{
        return $this->previousHash;
    }

    public function getData(): string{
        return $this->data;
    }

    public function getTimestamp(): int{
        return $this->timestamp;
    }
}
