<?php

class Collection {

    private $except = ['created_at', 'provider'];
    /**
     * @var any[]
     */
    private $collections;

    public function __construct(array $collections = [])
    {
        $this->collections = $collections;
    }

    public function append($instance): void
    {
        $this->collections[] = $instance;
    }

    public function sum(): array
    {
        if (count($this->collections) > 0) {
            $sumArray = [];
            foreach ($this->collections[0] as $key => $_) {
                if (!in_array($key, $this->except, true)) {
                    $sumArray[$key] = array_sum(array_column($this->collections, $key));
                }
            }
            return $sumArray;
        }
    }
}