<?php
namespace Nagoya4\Doukaku\Model;

class AllDequeueingPolicy
{
    public function __invoke(QueueCollection $collection)
    {
        array_map(function (Queue $queue) {
            $queue->dequeue();
        }, $collection->elements);
    }
}