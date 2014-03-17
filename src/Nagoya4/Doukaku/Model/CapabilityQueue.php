<?php
namespace Nagoya4\Doukaku\Model;

class CapabilityQueue extends Queue
{
    protected $capability = 0;

    public function __construct($capability) {
        $this->capability = $capability;
    }

    public function enqueue(QueueElement $element) {
        $this->length += $element->count;
    }

    public function dequeue() {
        $this->length = max(0, $this->length - $this->capability);
    }
}