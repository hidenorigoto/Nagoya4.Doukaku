<?php
namespace Nagoya4\Doukaku;

use Nagoya4\Doukaku\Model\AllDequeueingPolicy;
use Nagoya4\Doukaku\Model\QueueCollection;
use Nagoya4\Doukaku\Model\QueueElement;
use Nagoya4\Doukaku\Model\ShortestQueueingPolicy;
use Nagoya4\Doukaku\Model\StoppableCapabilityQueue;
use Nagoya4\Doukaku\Model\StopperQueueElement;

/**
 * Nagoya.Doukaku
 *
 * @package Nagoya.Doukaku
 */
class App
{
    /**
     * @var QueueCollection
     */
    private $registers;

    public function configure($capabilities)
    {
        $list = [];
        foreach ($capabilities as $capability) {
            $list[] = new StoppableCapabilityQueue($capability);
        }
        $this->registers = new QueueCollection($list);
        $this->registers->queueingPolicy = new ShortestQueueingPolicy();
        $this->registers->dequeueingPolicy = new AllDequeueingPolicy();
    }

    public function run($customerPattern)
    {
        for ($i = 0; $i < strlen($customerPattern); $i++) {
            $this->process($customerPattern[$i]);
        }
    }

    public function process($customer)
    {
        switch (true) {
            case $this->isNormalCustomer($customer):
                $this->registers->enqueue(new QueueElement($customer));
                break;
            case $this->isProcess($customer):
                $this->registers->dequeue();
                break;
            case $this->isStopper($customer):
                $this->registers->enqueue(new StopperQueueElement());
                break;
            default:
                throw new \RuntimeException('想定外の入力');
        }
    }

    public function state()
    {
        return implode(',', $this->registers->elements);
    }

    private function isProcess($character)
    {
        return '.' == $character;
    }

    private function isStopper($character)
    {
        return 'x' == $character;
    }

    private function isNormalCustomer($character)
    {
        return 1 == preg_match('/^[1-9]$/', $character);
    }
}
