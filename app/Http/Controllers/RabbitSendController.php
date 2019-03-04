<?php
/**
 * Created by PhpStorm.
 * User: vedran.bojicic
 * Date: 01.03.2019
 * Time: 12:59 PM
 */

namespace App\Http\Controllers;


use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Connectors\RabbitMQConnector;

use Faker\Factory as Faker;

class RabbitSendController
{


    public function sendMessages(int $number)
    {
        $queue = $this->setUpQueue();

//        $queue->getContext()->purgeQueue($queue->getContext()->createQueue('default'));

//        $expectedPayload = __METHOD__.microtime(true);

        $i=0;
        while ($i<$number) {
            $queue->pushRaw(
                json_encode([
                    'email'         => $this->fakeData()->email,
                    'name'          => $this->fakeData()->name,
                    'subscribed'    => true
                ])
            );
            $i++;
        }

    }

    public function getMessages()
    {
        $queue = $this->setUpQueue();
        dd($queue->pop()->getRawBody());
    }

    public function fakeData()
    {
        return Faker::create();

    }

    public function setUpQueue()
    {
        $connector = new RabbitMQConnector(new Dispatcher());
        $queue = $connector->connect(config('queue.connections.cloudAmpq'));
        $queue->setContainer(new Container());
        return $queue;
    }

}