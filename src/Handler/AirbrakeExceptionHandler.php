<?php

namespace adamtester\laravelairbrake\Handler;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Foundation\Application;

class AirbrakeExceptionHandler implements ExceptionHandler
{
    /**
     * @var
     */
    private $handler;

    /**
     * @var Application
     */
    private $app;

    public function __construct(ExceptionHandler $handler, Application $app)
    {
        $this->handler = $handler;
        $this->app = $app;
    }

    /**
     * Report or log an exception.
     *
     * @param \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->handler->shouldReport($e)) {
            $this->app['Airbrake\Instance']->notify($e);
        }

        return $this->handler->report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Exception                                        $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        return $this->handler->render($request, $e);
    }

    /**
     * Render an exception to the console.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Exception                                        $e
     *
     * @return void
     */
    public function renderForConsole($output, Exception $e)
    {
        return $this->handler->renderForConsole($output, $e);
    }
}
