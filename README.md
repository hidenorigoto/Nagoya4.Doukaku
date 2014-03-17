# レジ待ち行列問題 PHP解答コード例

[第18回オフラインリアルタイムどう書く]()

## コメント

* 問題のうち、「モデル」となる部分を切り出して「Model」へ実装しています。この部分はアプリケーション（問題特有の設定）非依存です。
* モデルレイヤーは、１つ抽象度を上げた名前をつけています。
* 問題特有の部分（パタメーター的なもの、問題空間の構成、問題を解く）はAppへまとめています。
* 待ち行列なのでQueueという言葉を使ってはいますが、今回は並んだ人個別には興味が（ほとんど）なくて、待っている合計人数にのみ興味があるととらえたため、合計での処理のみになっています。お客のバリエーションがもっと多い場合は、お客を1つ1つ別々に扱う（その時はそれもオブジェクトととらえる）かもしれません。
* x客がない場合は、CapabilityQueue（処理能力つきキュー）だけで問題が解ける
* x客のための特殊処理を StopperbleCapabilityQueue（停止機能つき処理能力つきキュー）としています。ここの実装が今回の問題の1つのカギですね。今回の実装はあまり賢くはないと思います。
* 待ち行列問題では、複数あるレジに「どのようなルールで並ぶのか」、「どのように処理が終わっていくのか」が問題設定で異なるため、これらをポリシーとして独立させてあります（今回は1つずつしか用意していません）

## Model内

* 基礎部品レイヤー Queue, QueueElement, QueueCollection,
* 応用ツリー1(キューの特殊化) CapabilityQueue, StoppableCapabilityCueue
* 応用ツリー2(キュー要素の特殊化） StopperQueueElement
* 応用レイヤー（個別ポリシー） ShortestQueueingPolicy, AllDequeueingPolicy

## 著作権

Copyright (c) 2014 GOTO Hidenori &lt;hidenorigoto@gmail.com&gt;, All rights reserved.

## ライセンス

[修正 BSD ライセンス](http://www.opensource.org/licenses/bsd-license.php)