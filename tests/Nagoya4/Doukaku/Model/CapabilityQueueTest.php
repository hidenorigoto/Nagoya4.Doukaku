<?php
namespace Nagoya4\Doukaku\Model;

class CapabilityQueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CapabilityQueue
     */
    private $SUT;

    /**
     * @test
     */
    public function 要素の追加()
    {
        $this->SUT = new CapabilityQueue(1);

        $this->SUT->enqueue(new QueueElement(3));
        $this->assertThat($this->SUT->length, $this->equalTo(3));
    }

    /**
     * @test
     * @dataProvider 要素取り出しのテストデータ
     */
    public function 要素の取り出し($capability, $number, $iteration, $expect)
    {
        $this->SUT = new CapabilityQueue($capability);
        $this->SUT->enqueue(new QueueElement($number));
        for ($i = 0; $i < $iteration; $i++) {
            $this->SUT->dequeue();
        }
        $this->assertThat($this->SUT->length, $this->equalTo($expect));
    }

    public function 要素取り出しのテストデータ()
    {
        return [
            [1, 3, 1, 2],
            [3, 8, 2, 2]
        ];
    }
}
 