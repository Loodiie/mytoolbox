<?php

function getPercent($percent = null, $of = null, $result = null)
{

    if ($result === null) {
        $result = $percent * $of / 100;

        return [
            'result' => $result,
        ];
    }
    if ($percent === null) {
        $percent = $of / $result * 100;

        return [
            'percent' => $percent,
        ];
    }
    if ($of === null) {
        $of = $result * 100 / $percent;

        return [
            'of' => $of,
        ];
    }
}

function ruleOfThird($a = 1, $b = 1, $c = 1): array
{
    return [
        'd' => ($b * $c)  / $a,
    ];
}
function cesar($clear, $key, $reverse = false)
{
    $clearing = str_split($clear);
    $result = '';

    foreach($clearing as $lettres){
        $ascii = ord($lettres);
        
        if($ascii >= 32 && $ascii <= 126){
            $ascii = $reverse ? $ascii - $key : $ascii + $key;
            
            if ($ascii > 126) {
                $ascii = $ascii - 94;
            }
            if ($ascii < 32)
            $ascii = $ascii + 94;
            $result .= chr($ascii);

        }else {
            $result .= $lettres;
        }
        
    } 
    if ($reverse) {
        return [
            'clear' => $result,
        ];
    } else {
        return [
            'result' => $result,
        ];
    }
}

function convertCurrency($amount = null, $from, $to){ 
        
    $url = 'https://open.er-api.com/v6/latest/' . $from;
    
    $data = file_get_contents($url);
    $data = json_decode($data, true);
    $rate = $data['rates'][$to];
    
    $convertedAmount = $amount * $rate;
    return [
        'result' => $convertedAmount,
    ];
}

function write_to_console($data)
{
    $console = $data;
    if (is_array($console))
        $console = implode(',', $console);

    echo "<script>console.log('Console: " . $console . "' );<:script>";
}

   // write_to_console($data);