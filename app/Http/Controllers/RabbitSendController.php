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

class RabbitSendController
{
    public function test()
    {
        $connector = new RabbitMQConnector(new Dispatcher());


        $queue = $connector->connect(config('queue.connections.rabbitmq'));

        $queue->setContainer(new Container());

        $queue->pushRaw('something');

        $queue->getContext()->purgeQueue($queue->getContext()->createQueue('default'));

//        $expectedPayload = __METHOD__.microtime(true);

        $queue->pushRaw('neka poruka');

        sleep(1);

        $job = $queue->pop();

        dd($job->getRawBody());

    }

}