<?php
namespace Nagoya4\Doukaku\Model;

class QueueElement
{
    public $count;

    function __construct($count)
    {
        $this->count = $count;
    }
}