<?php

namespace App\Application\ChainHandlers;

use App\Application\Commands\CheckCollisionCommand;
use App\Infrastructure\InversionOfControlContainer;
use App\Infrastructure\Queue\QueueStorage;
use Doctrine\Common\Collections\ArrayCollection;

class CheckCollisionHandler extends AbstractHandler
{
    public function handle(array $request)
    {
        $currentObject = InversionOfControlContainer::getInstance()
            ->resolve('game.' . $request['game_id'] . '.object.' . $request['object_id']);
        $objectsUpdatedArea = InversionOfControlContainer::getInstance()
            ->resolve('game.'. $request['game_id'].'.objects.updatedArea');
        /**
         * @var $objectsUpdatedArea ArrayCollection
         */
        $currentObjectArea = $objectsUpdatedArea->get($request['object_id']);
        foreach ($objectsUpdatedArea->toArray() as $objectId => $objectArea) {
            if ($objectId !== $request['object_id']) {
                if ($currentObjectArea == $objectArea) {
                    QueueStorage::push(new CheckCollisionCommand(
                        $currentObject,
                        InversionOfControlContainer::getInstance()
                            ->resolve(
                                'game.' . $request['game_id'] . '.object.' . $objectId
                            )
                    ));
                }
            }
        }
        parent::handle($request);
    }
}