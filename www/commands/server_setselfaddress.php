<?php

$ip = get_client_ip();

file_put_contents(__DIR__ . '/../dynamic/self_ip_address.auto.cfg', $ip);

system('add-trusted-ip "' . $ip . '"');

echo 'Ok.';
