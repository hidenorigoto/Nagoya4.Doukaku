<?php
namespace Nagoya4\Doukaku\Model;

abstract class Queue
{
    public $length = 0;

    abstract public function enqueue(QueueElement $element);

    abstract public function dequeue();

    public function __toString()
    {
        return (string)$this->length;
    }
}