<?php

namespace App\Application\ChainHandlers;

use App\Domain\MovableInterface;
use App\Infrastructure\InversionOfControlContainer;
use Doctrine\Common\Collections\ArrayCollection;

class DefineAreaHandler extends AbstractHandler
{
    private CONST AREAS = [
        [1, 2, 3, 4, 5],
        [6, 7, 8, 9, 10],
        [11, 12, 13, 14, 15],
        [16, 17, 18, 19, 20],
        [21, 22, 23, 24, 25]
    ];

    public function handle(array $request)
    {
        $body = [
            'game_id' => $request['game_id'],
            'object_id' => $request['object_id'],
        ];
        /**
         * @var $movable MovableInterface
         */
        $movable = InversionOfControlContainer::getInstance()
            ->resolve('game.' . $body['game_id'] . '.object.' . $body['object_id']);
        $x = ceil($movable->getPosition()->getX() / 3) - 1;
        $y = ceil($movable->getPosition()->getY() / 3) - 1;
        $area = self::AREAS[$y][$x];
        /**
         * @var $objectsArea ArrayCollection
         */
        $objectsArea = InversionOfControlContainer::getInstance()
            ->resolve('game.'. $request['game_id'].'.objects.area');
        /**
         * @var $objectsUpdatedArea ArrayCollection
         */
        $objectsUpdatedArea = InversionOfControlContainer::getInstance()
            ->resolve('game.'. $request['game_id'].'.objects.updatedArea');
        if (
            $objectsArea->get($request['object_id']) !== $area
        ) {
            $objectsArea->remove($request['object_id']);
            $objectsUpdatedArea->set($request['object_id'], $area);
            parent::handle($request);
        }
    }
}