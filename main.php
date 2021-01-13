<?php

/**
 * 設問
 * 1. facebookとyahooのそれぞれの合計
 * 2. facebookとyahooのそれぞれの合計から、cpc、cpa,ctr,コンバージョンレート,ROAS（Return On Advertising Spend）を算出してConsoleで表示
 * 
 * 説明
 * impressions: 広告の表示回数
 * sales: 広告からの売上
 * conversions: 広告からの成約数
 * clicks: 広告のクリック数
 * spend: 広告の費用
 * platform: 広告プロバイダー
 * 
 * CPCとは、cost per clickの略称で、1クリックを獲得するためにかかった費用。
 * CPAとは、cost per actionの略称で、1conversionを獲得するために掛かった費用である。
 * CTRとは、Click Through Rateの略称で、Impressionに対してclickされた比率を指す。
 * コンバージョンレート(CVR)とは、Conversion Rateの略称で、click総数に対してconversionした比率を指す。
 * ROASとは、Return On Advertising Spendの略称で、投資した広告費用の回収率。 総売上/総コスト * 100 (%)
 */

require('Insight.php');
require('Collection.php');

class Main {
    /**
     * @var object
     */
    private $data;
    
    public function __construct()
    {
        $array = file_get_contents('insight.json');
        $array = mb_convert_encoding($array, 'UTF8');
        $this->data = json_decode($array, true);
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
                $val['platform'],
                $val['created_at'],
            );
            switch ($val['platform']) {
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