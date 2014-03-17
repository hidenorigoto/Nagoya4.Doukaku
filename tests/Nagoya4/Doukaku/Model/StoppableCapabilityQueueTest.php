<?php
namespace Nagoya4\Doukaku\Model;

class StoppableCapabilityQueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StoppableCapabilityQueue
     */
    private $SUT;

    /**
     * @test
     * @dataProvider 停止状態チェックテストデータ
     */
    public function 停止状態になること($inputs, $expectedStopping, $expectedLength)
    {
        foreach ($inputs as $input) {
            $this->SUT->enqueue($input);
        }

        $this->assertThat($this->SUT->stopping, $this->equalTo($expectedStopping));
        $this->assertThat($this->SUT->length, $this->equalTo($expectedLength));
    }

    public function 停止状態チェックテストデータ()
    {
        return [
            [[], false, 0],
            [[new QueueElement(1)], false, 1],
            [[new QueueElement(1), new StopperQueueElement()], true, 2],
            [[new QueueElement(1), new StopperQueueElement(), new QueueElement(2)], true, 4],
        ];
    }

    /**
     * @test
     * @dataProvider 停止状態の取り出しテストデータ
     */
    public function 停止状態の取り出し($inputs, $processTimes, $expect)
    {
        foreach ($inputs as $input) {
            $this->SUT->enqueue($input);
        }

        for ($i = 0; $i < $processTimes; $i++) {
            $this->SUT->dequeue();
        }

        $this->assertThat($this->SUT->length, $this->equalTo($expect));
    }

    public function 停止状態の取り出しテストデータ()
    {
        return [
            [[], 1, 0],
            [[new QueueElement(1)], 1, 0],
            [[new QueueElement(1), new StopperQueueElement()], 1, 1],
            [[new QueueElement(1), new StopperQueueElement()], 2, 1],
            [[new QueueElement(1), new StopperQueueElement(), new QueueElement(2)], 2, 3],
            [[new QueueElement(1), new StopperQueueElement(), new QueueElement(2), new StopperQueueElement()], 3, 4],
        ];
    }

    protected function setUp()
    {
        $this->SUT = new StoppableCapabilityQueue(1);
    }
}
 