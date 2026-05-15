<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../actions/valida_create_post_action.php';

class test_valida_create_post_action extends TestCase {

    public function testPostValido() {

        $result = validatePost("Titolo", "Descrizione");

        $this->assertTrue($result);
    }
}