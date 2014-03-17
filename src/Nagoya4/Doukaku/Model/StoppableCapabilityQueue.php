<?php
namespace Nagoya4\Doukaku\Model;

class StoppableCapabilityQueue extends CapabilityQueue
{
    public $stopping = false;
    private $limit = PHP_INT_MAX;

    public function enqueue(QueueElement $element)
    {
        if ($element instanceof StopperQueueElement && !$this->stopping) {
            $this->stopping = true;
            $this->limit = $this->length;
        }

        parent::enqueue($element);
    }

    public function dequeue()
    {
        $this->length = max(0, $this->length - min($this->limit, $this->capability));
        if ($this->stopping) {
            $this->limit = max(0, $this->limit - $this->capability);
        }
    }
}