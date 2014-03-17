<?php
namespace Nagoya4\Doukaku\Model;

class ShortestQueueingPolicy
{
    function __invoke(QueueCollection $collection, QueueElement $element)
    {
        /** @var Queue $firstShortest */
        $firstShortest = array_reduce($collection->elements, function (Queue $current = null, Queue $element) {
            if (!$current) return $element;

            if ($current->length > $element->length) {
                $current = $element;
            }

            return $current;
        }, null);

        $firstShortest->enqueue($element);
    }
}