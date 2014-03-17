<?php
namespace Nagoya4\Doukaku\Model;

class QueueCollection
{
    public $elements = [];
    public $queueingPolicy = null;
    public $dequeueingPolicy = null;

    public function __construct($elements)
    {
        $this->elements = $elements;
    }

    public function enqueue(QueueElement $element)
    {
        if ($this->queueingPolicy) {
            call_user_func($this->queueingPolicy, $this, $element);
        }
    }

    public function dequeue()
    {
        if ($this->dequeueingPolicy) {
            call_user_func($this->dequeueingPolicy, $this);
        }
    }
}