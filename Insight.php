<?php
class Insight {
    /**
     * @var int
     */
    public $impressions;

    /**
     * @var int
     */
    public $sales;

    /**
     * @var int
     */
    public $conversions;

    /**
     * @var int
     */
    public $clicks;

    /**
     * @var int
     */
    public $spend;

    /**
     * @var string
     */
    public $provider;

    /**
     * @var string
     */
    public $created_at;

    public function __construct(
        int $impressions,
        int $sales,
        int $conversions,
        int $clicks,
        int $spend,
        string $provider,
        string $created_at
    ) {
        $this->impressions = $impressions;
        $this->sales = $sales;
        $this->conversions = $conversions;
        $this->clicks = $clicks;
        $this->spend = $spend;
        $this->provider = $provider;
        $this->created_at = $created_at;
    }
}