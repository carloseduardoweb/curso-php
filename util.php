<?php

function getReqParamAndDestroy(&$request, $key) {
    if (array_key_exists($key, $request)) {
        $value = $request[$key];
        $request[$key] = null;
        unset($request[$key]);
        return $value;
    }
}
