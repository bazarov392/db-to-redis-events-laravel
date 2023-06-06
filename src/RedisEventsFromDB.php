<?php

namespace Bazarov392;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;

class RedisEventsFromDB
{
    static function init(): void
    {
        Event::listen(['eloquent.created*', 'eloquent.updated*', 'eloquent.deleted*'], function(string $event, array $models) {
            preg_match("/^eloquent\\.(created|updated|deleted): .+/", $event, $matches);
            $event = &$matches[1];
            $model = &$models[0];
            $stringEvent = "db_event.";
            $stringEvent .= $model->getTable().".";
            $stringEvent .= $event.".";
            $idModel = $model->getAttribute($model->getKeyName());
            if($idModel != null) $stringEvent .= $idModel;

            $utfEight = true;
            foreach($model->getAttributes() as $attr)
            {
                if(!mb_check_encoding($attr, 'UTF-8'))
                {
                    $utfEight = false;
                    break;
                }
            }
            Redis::publish($stringEvent, ($idModel != null) ? "{}" : (($utfEight) ? $model->toJSON() : '{}'));
        });
    }
}