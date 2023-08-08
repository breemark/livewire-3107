<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlesTest extends TestCase
{

    function test_articles_component_renders_correctly()
    {
        $this->get('/')->assertSeeLivewire('articles');
    }
}
