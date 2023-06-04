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

/*function cesar($clear, $key, $reverse = false)
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $alphabet = str_split($alphabet);
    $clear = str_split($clear);
    $result = '';

    foreach ($clear as $letter) {
        if ($letter === ' ') { // Vérifier si le caractère est un espace
            $result .= ' '; // Ajouter l'espace directement au résultat
        } elseif (in_array($letter, $alphabet)) { // Vérifier si le caractère est dans l'alphabet
            $index = array_search($letter, $alphabet);
            $index = $reverse ? $index - $key : $index + $key;
            if ($index > 25) {
                $index = $index - 26;
            }
            if ($index < 0)
                $index = $index + 26;
            $result .= $alphabet[$index];
        } else {
            $result .= $letter; // Ajouter le caractère spécial directement au résultat sans le changer
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
}*/


function convertCurrency($amount = null, $from, $to)
{

    $url = 'https://open.er-api.com/v6/latest/' . $from;

    $data = file_get_contents($url);
    $data = json_decode($data, true);
    $rate = $data['rates'][$to];

    $convertedAmount = $amount * $rate;
    return [
        'result' => $convertedAmount,
    ];
}


/* function convertEuroDollars($euro = null, $dollars = null, $livre = null, $yen = null){
        $currency = $euro === null ? 'USD' : 'EUR';
        $reverseCurrency = $currency === 'EUR' ? 'USD' : 'EUR';
        
        $url = 'https://v6.exchangerate-api.com/v6/0a0575a23e02c7fee5a6c464/latest/' . $currency;
    
        $data = file_get_contents($url);
        write_to_console($data);
        $data = json_decode($data, true);
        $rate = $data['rates'][$reverseCurrency];
    
        if($euro === null){
            $euro = $dollars * $rate;
            return [
                'EUR' => $euro,
                'JPY' => $euro * $data['rates']['JPY'],
                'GBP' => $euro * $data['rates']['GBP']
            ];
        }
        if($dollars === null){
            $dollars = $euro * $rate;
            return [
                'USD' => $dollars,
                'JPY' => $dollars * $data['rates']['JPY'],
                'GBP' => $dollars * $data['rates']['GBP']
            ];
        }
        if($livre === null){
            $livre = $euro * $rate * $data['rates']['GBP'];
            return [
                'GBP' => $livre,
                'JPY' => $livre * $data['rates']['JPY'],
                'USD' => $livre / $data['rates']['GBP']
            ];
        }
        if($yen === null){
            $yen = $euro * $rate * $data['rates']['JPY'];
            return [
                'JPY' => $yen,
                'GBP' => $yen * $data['rates']['GBP'],
                'USD' => $yen / $data['rates']['JPY']
            ];
        }
    }*/


function write_to_console($data)
{
    $console = $data;
    if (is_array($console))
        $console = implode(',', $console);

    echo "<script>console.log('Console: " . $console . "' );<:script>";
}

   // write_to_console($data);