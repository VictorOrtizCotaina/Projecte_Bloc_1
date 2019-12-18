<?php


function validarFormulariText($value, $name){
    $val= trim($value);
    if (!empty($val)){
        return null;
    }
    else {
        return "El text del camp $name esta buit.";
    }
}

function validarFormulariData($value, $name){
    $val= trim($value);
    if (empty($val)){
        return "El text del camp $name esta buit.";
    } elseif (DateTime::createFromFormat('d-m-Y', $val) === false) {
        return "El text del camp $name no es una data valida (d-m-Y).";
    } else {
        return null;
    }
}

function validarFormulariNum($value, $name){
    $val= trim($value);
    if (empty($val)){
        return "El text del camp $name esta buit o no es un numero.";
    } else {
        return null;
    }
}