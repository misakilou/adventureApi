<?php

namespace App\Entity;

class Tile
{
    private TileType $type;
    private int $specialEffect;
    private Monster $monster;

    private bool $restState = true;

    /**
     * @return TileType
     */
    public function getType(): TileType
    {
        return $this->type;
    }

    /**
     * @param TileType $type
     */
    public function setType(TileType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getSpecialEffect(): int
    {
        return $this->specialEffect;
    }

    /**
     * @param int $specialEffect
     */
    public function setSpecialEffect(int $specialEffect): void
    {
        $this->specialEffect = $specialEffect;
    }

    /**
     * @return Monster
     */
    public function getMonster(): Monster
    {
        return $this->monster;
    }

    /**
     * @param Monster $monster
     */
    public function setMonster(Monster $monster): void
    {
        $this->monster = $monster;
    }

    /**
     * @return bool
     */
    public function isRestState(): bool
    {
        return $this->restState;
    }

    /**
     * @param bool $restState
     */
    public function setRestState(bool $restState): void
    {
        $this->restState = $restState;
    }


}
