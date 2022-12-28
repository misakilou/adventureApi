<?php

namespace App\Entity;

class Character
{
    private string $id;

    private int $lifePoint;

    private int $attackValue;

    private int $armorValue;

    public function getId(): string
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
     * @return int
     */
    public function getLifePoint(): int
    {
        return $this->lifePoint;
    }

    /**
     * @param int $lifePoint
     */
    public function setLifePoint(int $lifePoint): void
    {
        $this->lifePoint = $lifePoint;
    }

    /**
     * @return int
     */
    public function getAttackValue(): int
    {
        return $this->attackValue;
    }

    /**
     * @param int $attackValue
     */
    public function setAttackValue(int $attackValue): void
    {
        $this->attackValue = $attackValue;
    }

    /**
     * @return int
     */
    public function getArmorValue(): int
    {
        return $this->armorValue;
    }

    /**
     * @param int $armorValue
     */
    public function setArmorValue(int $armorValue): void
    {
        $this->armorValue = $armorValue;
    }


}
