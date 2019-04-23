<?php
namespace Kit;
use InvalidArgumentException;
use Closure;

/**
 * Pipeline, pipe mode.
 *
 * @author MirQin https://github.com/wazsmwazsm
 */
class Pipeline
{
    /**
     * Pipes.
     *
     * @var array
     */
    protected $_pipes = [];
    /**
     * set pipes, array mode.
     * 
     * @param array $pipes
     * @throws \InvalidArgumentException
     */
    public function __construct(array $pipes = [])
    {
        foreach ($pipes as $pipe) {
            if (FALSE === is_callable($pipe)) {
                throw new InvalidArgumentException('All pipes should be callable.');
            }
        }
        $this->_pipes = $pipes;
    }
    /**
     * set pipes, single mode.
     *
     * @param callable $pipe
     * @return self
     * @throws \InvalidArgumentException
     */
    public function pipe($pipe) 
    {
        if (FALSE === is_callable($pipe)) {
            throw new InvalidArgumentException('pipe should be callable.');
        }
        $this->_pipes[] = $pipe;
        return $this;
    }
    /**
     * process pipeline flow, when payload passed as a closure, stop pipeline flow.
     *
     * @param mixed $payload
     * @return mixed
     */
    public function flow($payload) 
    {
        foreach ($this->_pipes as $pipe) {
            // process pipe
            $payload = call_user_func($pipe, $payload);
            
            if ($payload instanceOf Closure) {
                // if payload is a closure, stop pipeline flow
                return call_user_func($payload);
            }     
        }
        return $payload;
    }
}
