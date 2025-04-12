<?php
namespace app\Http\Actions;

use app\Model\ErrorHandling\handleExceptions;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class sendToRabbitMQAction extends baseAction {

    public function call() {
        $fn = function () {
            /* RabbitMQ teste send. Receive is message-rabbit.php */
            $connection = new AMQPStreamConnection('localhost3', 5672, 'guest', 'guest');
            $channel = $connection->channel();

            $channel->queue_declare('hello', false, false, false, false);

            $msg = new AMQPMessage('Hello World!');
            $channel->basic_publish($msg, '', 'hello');

            echo " [x] Sent 'Hello World!'\n";

            $channel->close();
            $connection->close();
        };

        new handleExceptions($fn);
    }
}