<?php

function active_class($path, $active = 'active')
{
  return call_user_func_array('Request::is', (array) $path) ? $active : '';
}

function is_active_route($path)
{
  return call_user_func_array('Request::is', (array) $path) ? 'true' : 'false';
}

function show_class($path)
{
  return call_user_func_array('Request::is', (array) $path) ? 'show' : '';
}
function generateRandomString($length = 20)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
