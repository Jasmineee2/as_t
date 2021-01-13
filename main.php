<?php
require('Insight.php');
require('Collection.php');

class Main {
    /**
     * @var object
     */
    private $data;
    
    public function __construct()
    {
        $json = file_get_contents('insight.json');
        $json = mb_convert_encoding($json, 'UTF8');
        $this->data = json_decode($json, true);
    }

    public function displaySummaries(): void
    {
        $summaries = $this->makeSummaries();
        $string = "=================================================\n";
        foreach ($summaries as $key => $val) {
            $string .= "[$key]\n\n";
            foreach ($val as $innerKey => $innerVal) {
                $string .= "$innerKey: $innerVal\n";
            }
            $string .= "=================================================\n";
        }

        echo $string;
    }

    private function makeSummaries(): array
    {
        $facebookInsights = new Collection();
        $yahooInsights = new Collection();
    
        foreach ($this->data as $val) {
            $insight = new Insight(
                $val['impressions'],
                $val['sales'],
                $val['conversions'],
                $val['clicks'],
                $val['spend'],
                $val['provider'],
                $val['created_at'],
            );
            switch ($val['provider']) {
                case 'yahoo':
                    $yahooInsights->append($insight);
                    break;
                case 'facebook':
                    $facebookInsights->append($insight);
                    break;
            }
        }
        $yahooSum = $yahooInsights->sum();
        $facebookSum = $facebookInsights->sum();

        $yahooSum = $this->addStatistics($yahooSum);
        $facebookSum = $this->addStatistics($facebookSum);

        return [
            'yahoo' => $yahooSum,
            'facebook' => $facebookSum,
        ];
    }

    private function addStatistics(array $summaries): array
    {
        $summaries['cpc'] = round($summaries['spend'] / $summaries['clicks'], 2);
        $summaries['cpa'] = round($summaries['spend'] / $summaries['conversions'], 2);
        $summaries['ctr'] = round($summaries['clicks'] / $summaries['impressions'] * 100, 2) . "%";
        $summaries['cvr'] = round($summaries['conversions'] / $summaries['clicks'] * 100, 2) . "%";
        $summaries['roas'] = round($summaries['sales'] / $summaries['spend'] * 100, 2) . "%";

        return $summaries;
    }
}

$main = new Main();
$main->displaySummaries();