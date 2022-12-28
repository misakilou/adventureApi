<?php

namespace App\Entity;
class Monster
{

    private MonsterType $type;

    private int $lifePoint;

    private int $attackValue;

    private int $armorValue;

    private bool $state = true;

    /**
     * @return MonsterType
     */
    public function getType(): MonsterType
    {
        return $this->type;
    }

    /**
     * @param MonsterType $type
     */
    public function setType(MonsterType $type): void
    {
        $this->type = $type;
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
}
