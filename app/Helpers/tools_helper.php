<?php
function place_floor(int $floor){
    $text = $floor < 0 ? 'Sótano' : 'Piso';
    $text .= ' '.abs($floor);
    return $text;
}
function place(?int $floor, ?string $letter, ?int $number){
    if(is_null($floor) || is_null($letter) || is_null($number)){
        return '';
    }
    $text = place_floor($floor);
    $text .= ' - '.$letter.$number;
    return $text;
}
function cute_date(string $date, $all = true){
    if(empty($date)) return '';
    $time = strtotime($date);
    //return str_replace(' ', '<br>', date('d/m/Y g:mA', $time));
    $format = $all ? 'd/m/Y g:mA' : 'd/m/Y';
    return date($format, $time);
}
function color_free(int $free, int $total){
    $mid = $total / 2;
    $quarter = $mid + $mid/2;

    if($free >= $mid){
        return "#0057ff";
    } else if( $free >= $quarter){
        return "#d96914";
    } else {
        return "#dc3545";
    }
}