<?php
namespace Nagoya4\Doukaku\Model;

class StopperQueueElement extends QueueElement
{
    function __construct()
    {
        parent::__construct(1);
    }
}