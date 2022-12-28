<?php

namespace App\Controller;

use App\Entity\Adventure;
use App\Entity\Character;
use App\Entity\Monster;
use App\Entity\MonsterType;
use App\Entity\Tile;
use App\Entity\TileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    private RequestStack $requestStack;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("adventure/start", name="adventure.start")
     */
    public function AdventureStart(): Response
    {
        $session   = $this->requestStack->getSession();
        $character = $this->characterNew();
        $adventure = new Adventure();

        $adventure->setCharacter($character);
        $adventure->setState(true);
        $adventure->setId(uniqid());
        $adventure->setTile($this->tileNew($adventure));
        $session->set($adventure->getCharacter()->getId(), $adventure->getCharacter());
        $session->set($adventure->getId(), $adventure);

        return $this->json($adventure,200);
    }

    /**
     * @Route("adventure/{adventure_id}", name="adventure.byId")
     */
    public function AdventureById(string $adventure_id): Response
    {
        $session   = $this->requestStack->getSession();
        $adventure = $session->get($adventure_id);

        if ($adventure) {
            return $this->json($adventure,200);
        }

        return $this->json(["error"=>"adventure not found"],404);
    }

    /**
     * @Route("adventure/{adventure_id}/tile", name="tile.byAdventureId")
     */
    public function TileByAdventureId(string $adventure_id): Response
    {
        $session   = $this->requestStack->getSession();
        $adventure = $session->get($adventure_id);

        if ($adventure) {
            return $this->json($adventure->getTile(),200);
        }

        return $this->json(["error"=>"adventure not found"],404);
    }

    /**
     * @Route("character/{character_id}", name="characterById")
     */
    public function CharacterById(string $character_id): Response
    {
        $session   = $this->requestStack->getSession();
        $character = $session->get($character_id);
        
        if ($character) {
            return $this->json($character,200);
        }

        return $this->json(["error"=>"character not found"],404);
    }

    /**
     * @Route("character/{character_id}/action/move", name="characterMove")
     */
    public function CharacterMove(Request $request,string $character_id): Response
    {
        $session   = $this->requestStack->getSession();
        $character = $session->get($character_id);
        $content   = json_decode($request->getContent());
        $adventure = $session->get($content->adventure_id);

        if ($adventure->isState()){
            $adventure = $this->characterMoveProcess($adventure, $character);
        }else {
            $adventure->setMessage("Game end");
        }

        return $this->json($adventure,200);
    }

    /**
     * @Route("character/{character_id}/action/attack", name="characterAttack")
     */
    public function CharacterAttack(Request $request,string $character_id): Response
    {
        $session   = $this->requestStack->getSession();
        $character = $session->get($character_id);
        $content   = json_decode($request->getContent());
        $adventure = $session->get($content->adventure_id);

        if ($adventure->isState()) {
            $adventure = $this->characterAttackProcess($adventure, $character);
        } else {
            $adventure->setMessage("Game end");
        }

        return $this->json($adventure,200);
    }

    /**
     * @Route("character/{character_id}/action/rest", name="characterRest")
     */
    public function CharacterRest(Request $request,string $character_id): Response
    {
        $session   = $this->requestStack->getSession();
        $character = $session->get($character_id);
        $content   = json_decode($request->getContent());
        $adventure = $session->get($content->adventure_id);

        if ($adventure->isState()) {
            $adventure = $this->characterRestProcess($adventure, $character);
        } else {
            $adventure->setMessage("Game end");
        }

        return $this->json($adventure,200);
    }

    /**
     * Create new Tile
     *
     * @param Adventure $adventure
     * @return Tile
     */
    private function tileNew(Adventure $adventure): Tile
    {
        $tile = new Tile();

        if ($adventure->getTileNumber() >= 10) {
            $tile->setType(TileType::Boss);
            $tile->setMonster($this->adventureBoss());
            $adventure->setBossNumber($adventure->getBossNumber() + 1);
        } else {
            $i = rand(1,6);

            switch ($i){
                case 1:
                    $tile->setType(TileType::Grasslands);

                    break;
                case 2:
                    $tile->setType(TileType::Hills);

                    break;
                case 3:
                    $tile->setType(TileType::Forest);

                    break;
                case 4:
                    $tile->setType(TileType::Mountains);

                    break;
                case 5:
                    $tile->setType(TileType::Desert);

                    break;
                case 6:
                    $tile->setType(TileType::Swamp);

                    break;
            }
            $tile->setMonster($this->monsterNew());
        }

        $adventure->setTileNumber($adventure->getTileNumber()+1);
        $session = $this->requestStack->getSession();

        $session->set($adventure->getId(), $adventure);

        return $tile;
    }

    /**
     * Create new monster
     *
     * @return Monster
     */
    private function monsterNew(): Monster
    {
        $monster = new Monster();
        $i       = rand(1,4);

        switch ($i){
            case 1:
                $monster->setType(MonsterType::Ghost);
                $monster->setLifePoint(8);
                $monster->setArmorValue(6);

                break;
            case 2:
                $monster->setType(MonsterType::Ork);
                $monster->setLifePoint(10);
                $monster->setArmorValue(4);

                break;
            case 3:
                $monster->setType(MonsterType::Gobelin);
                $monster->setLifePoint(12);
                $monster->setArmorValue(0);

                break;
            case 4:
                $monster->setType(MonsterType::Troll);
                $monster->setLifePoint(12);
                $monster->setArmorValue(6);

                break;
        }

        return $monster;
    }

    /**
     * Create new character
     *
     * @return Character
     */
    private function characterNew(): Character
    {
        $character = new Character();

        $character->setId(uniqid());
        $character->setLifePoint(20);
        $character->setArmorValue(5);

        return $character;
    }

    /**
     * Boss Process
     *
     * @return Monster
     */
    private function adventureBoss(): Monster
    {
        $monster = new Monster();

        $monster->setLifePoint(20);
        $monster->setArmorValue(8);
        $monster->setType(MonsterType::Dragon);

        return $monster;
    }

    /**
     * Character atk
     *
     * @param Adventure $adventure
     * @param Character $character
     * @return Adventure
     */
    private function characterAttackProcess(Adventure $adventure, Character $character): Adventure
    {
        if ($adventure->getTile()->getMonster()->isState()) {

            if($adventure->getTile()->getType() == TileType::Desert) {
                $adventure->getCharacter()->setLifePoint($adventure->getCharacter()->getLifePoint()-1);
            }

            $character->setAttackValue(rand(2,12));

            if ($character->getAttackValue() > $adventure->getTile()->getMonster()->getArmorValue()) {
                $lifePoint = $adventure->getTile()->getMonster()->getLifePoint() - ($character->getAttackValue() + $adventure->getTile()->getMonster()->getArmorValue());

                $adventure->getTile()->getMonster()->setLifePoint($lifePoint);

                if($adventure->getTile()->getMonster()->getLifePoint() <= 0) {
                    $adventure->getTile()->getMonster()->setState(false);

                    if($adventure->getTile()->getType() != TileType::Boss) {
                        $adventure->setMonsterNumber($adventure->getMonsterNumber() +1);
                    }

                    if($adventure->getTile()->getType() == TileType::Boss) {
                        $this->adventureEnd($adventure);
                    }

                    $session = $this->requestStack->getSession();

                    $session->set($adventure->getId(), $adventure);
                    $session->set($character->getId(), $adventure->getCharacter());
                } else {
                    return $this->monsterAttack($adventure, $character);
                }
            }
        }

        return $adventure;
    }

    /**
     * Monster atk
     *
     * @param Adventure $adventure
     * @param Character $character
     * @return Adventure
     */
    private function monsterAttack(Adventure $adventure, Character $character): Adventure
    {
        $monster = $adventure->getTile()->getMonster();

        if ($monster->isState()) {
            switch ($monster->getType()) {
                case MonsterType::Ghost:
                    $monster->setAttackValue(rand(1,4));

                    if ($adventure->getTile()->getType() == TileType::Hills) {
                        $monster->setAttackValue($monster->getAttackValue()+2);
                    }

                    break;
                case MonsterType::Ork:
                    $monster->setAttackValue(rand(1,6));

                    if ($adventure->getTile()->getType() == TileType::Grasslands) {
                        $monster->setAttackValue($monster->getAttackValue()+2);
                    }

                    break;
                case MonsterType::Gobelin:
                    $monster->setAttackValue((rand(1,4)-1));

                    if ($adventure->getTile()->getType() == TileType::Forest) {
                        $monster->setAttackValue($monster->getAttackValue()+2);
                    }

                    break;
                case MonsterType::Troll:
                    $monster->setAttackValue(rand(1,6));

                    if($adventure->getTile()->getType() == TileType::Mountains) {
                        $monster->setAttackValue($monster->getAttackValue()+2);
                    }

                    break;
                case MonsterType::Dragon:
                    $monster->setAttackValue(rand(1,6) + 2);
                    break;
            }

            if ($monster->getAttackValue() > $character->getArmorValue()) {
                $adventure->getCharacter()->setLifePoint($adventure->getCharacter()->getLifePoint() - ($monster->getAttackValue()-$adventure->getCharacter()->getArmorValue()));
                
                if ($adventure->getCharacter()->getLifePoint() <= 0) {
                    $this->adventureEnd($adventure);
                }
            }

            $session = $this->requestStack->getSession();
            
            $session->set($adventure->getId(), $adventure);
            $session->set($character->getId(), $adventure->getCharacter());

        }
        return $adventure;
    }

    /**
     * End adventure process
     *
     * @param Adventure $adventure
     * @return void
     */
    private function adventureEnd(Adventure $adventure): void
    {
        $adventure->setState(false);
        $adventure->setMessage("Game end");
        $adventure->setScore($adventure->getMonsterNumber()*10 + $adventure->getBossNumber()*20 + $adventure->getMonsterNumber()*5);

        $session = $this->requestStack->getSession();

        $session->set($adventure->getId(), $adventure);
    }

    /**
     * Character move
     *
     * @param Adventure $adventure
     * @param Character $character
     * @return void
     */
    private function characterMoveProcess(Adventure $adventure, Character $character)
    {
        if($adventure->getTile()->getType() == TileType::Desert) {
            $adventure->getCharacter()->setLifePoint($character->getLifePoint()-1);
        }

        $session = $this->requestStack->getSession();

        if ($adventure->getTile()->getMonster()->getType() != MonsterType::Dragon) {
            if ($adventure->getTile()->getType() != TileType::Swamp) {
                if ($adventure->getTile()->getMonster()->isState()) {
                    $this->monsterAttack($adventure, $character);
                }

                $adventure = $session->get($adventure->getId());
                $tile      = $this->tileNew($adventure);
                $adventure = $session->get($adventure->getId());

                $adventure->setTile($tile);
                $session->set($adventure->getId(), $adventure);
            } else {
                if ($adventure->getTile()->getMonster()->isState()) {
                    $this->monsterAttack($adventure, $character);

                    $adventure = $session->get($adventure->getId());
                    $tile      = $this->tileNew($adventure);
                    $adventure = $session->get($adventure->getId());

                    $adventure->setTile($tile);
                    $session->set($adventure->getId(), $adventure);
                }
            }
        }

        return $adventure;
    }

    private function characterRestProcess(Adventure $adventure, Character $character): Adventure
    {
        if ($adventure->isState()) {
            if ($adventure->getTile()->getType() == TileType::Desert) {
                $adventure->getCharacter()->setLifePoint($character->getLifePoint()-1);
            }

            if ($adventure->getTile()->isRestState() and !$adventure->getTile()->getMonster()->isState()) {
                $adventure->getCharacter()->setLifePoint($character->getLifePoint()+2);
            }

            $adventure->getTile()->setRestState(false);
            $session = $this->requestStack->getSession();

            $session->set($adventure->getId(), $adventure);
        }

        return $adventure;
    }
}