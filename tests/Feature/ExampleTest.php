<?php

it('has welcome page', function () {
$this->get('/')->assertOk();
});
