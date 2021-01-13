# as_t
 ## 設問
 1. facebookとyahooのそれぞれの合計を求めなさい。
 2. facebookとyahooのそれぞれの合計から、cpc、cpa,ctr,コンバージョンレート,ROAS（Return On Advertising Spend）を算出してConsoleで表示しなさい。

 ## Jsonパース方法
 ```php
 $json = file_get_contents('insight.json');
 $json = mb_convert_encoding($json, 'UTF8');
 $this->data = json_decode($json, true);
 ```
 ## パラメーター説明
 |パラメーター名|意味|
 |:--:|:--:|
 |impressions|広告の表示回数|
 |sales|広告からの売上|
 |conversions|広告からの成約数|
 |clicks|広告のクリック数|
 |spend|広告の費用|
 |platform|広告プロバイダー|

 ## 統計数値説明
 |パラメーター名|意味|
 |:--:|:--:|
 |CPC|cost per clickの略称で、1クリックを獲得するためにかかった費用。|
 |CPA|cost per actionの略称で、1conversionを獲得するために掛かった費用である。|
 |CTR|Click Through Rateの略称で、Impressionに対してclickされた比率を指す。|
 |コンバージョンレート(CVR)|Conversion Rateの略称で、click総数に対してconversionした比率を指す。|
 |ROAS|Return On Advertising Spendの略称で、投資した広告費用の回収率。 総売上/総コスト * 100 (%)|
## Hot to run
```shell
$ php main.php
```
