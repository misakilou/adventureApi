<?php

namespace App\Entity;

class Adventure
{
    private string $id;
    private Tile $tile;
    private int $score;
    private Character $character;
    private int $tileNumber = 0;
    private int $bossNumber = 0;
    private int $monsterNumber = 0;
    private string $message = "game running";

    private bool $state;

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }



    /**
     * @return Tile
     */
    public function getTile(): Tile
    {
        return $this->tile;
    }

    /**
     * @param Tile $tile
     */
    public function setTile(Tile $tile): void
    {
        $this->tile = $tile;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return Character
     */
    public function getCharacter(): Character
    {
        return $this->character;
    }

    /**
     * @param Character $character
     */
    public function setCharacter(Character $character): void
    {
        $this->character = $character;
    }

    /**
     * @return bool
     */
    public function isState(): bool
    {
        return $this->state;
    }

    /**
     * @param bool $state
     */
    public function setState(bool $state): void
    {
        $this->state = $state;
    }

    /**
     * @return int
     */
    public function getTileNumber(): int
    {
        return $this->tileNumber;
    }

    /**
     * @param int $tileNumber
     */
    public function setTileNumber(int $tileNumber): void
    {
        $this->tileNumber = $tileNumber;
    }

    /**
     * @return int
     */
    public function getBossNumber(): int
    {
        return $this->bossNumber;
    }

    /**
     * @param int $bossNumber
     */
    public function setBossNumber(int $bossNumber): void
    {
        $this->bossNumber = $bossNumber;
    }

    /**
     * @return int
     */
    public function getMonsterNumber(): int
    {
        return $this->monsterNumber;
    }

    /**
     * @param int $monsterNumber
     */
    public function setMonsterNumber(int $monsterNumber): void
    {
        $this->monsterNumber = $monsterNumber;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }


}
