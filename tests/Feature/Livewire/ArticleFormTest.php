<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;


class ArticleFormTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function can_create_new_articles()
    {
        Livewire::test('article-form')
            ->set('article.title', 'New Article')
            ->set('article.content', 'Article Content')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('home'))
        ;

        $this->assertDatabaseHas('articles', [
            'title' => 'New Article',
            'content' => 'Article Content'
        ]);
    }


    function test_title_is_required()
    {
        Livewire::test('article-form')
            ->set('article.content', 'Article Content')
            ->call('save')
            ->assertHasErrors(['article.title' => 'required'])
        ;
    }


    function test_title_must_be_4_characters_min()
    {
        Livewire::test('article-form')
            ->set('article.title', 'one')
            ->call('save')
            ->assertHasErrors(['article.title' => 'min:4'])
        ;
    }

    function test_content_is_required()
    {
        Livewire::test('article-form')
            ->set('article.content', '')
            ->call('save')
            ->assertHasErrors(['article.content' => 'required'])
        ;
    }

    function test_real_time_validation_works_for_title()
    {
        Livewire::test('article-form')
            ->set('article.title', '')
            ->assertHasErrors(['article.title' => 'required'])
            ->set('article.title', 'New')
            ->assertHasErrors(['article.title' => 'min:4'])
            ->set('article.title', 'New Article')
            ->assertHasNoErrors('article.title')
        ;
    }

        function test_real_time_validation_works_for_content()
    {
        Livewire::test('article-form')
            ->set('article.content', '')
            ->assertHasErrors(['article.content' => 'required'])
            ->set('article.content', 'New Article')
            ->assertHasNoErrors('article.title')
        ;
    }
}
