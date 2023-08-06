<?php

namespace Tests\Feature\Livewire;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;


class ArticleFormTest extends TestCase
{

    use RefreshDatabase;

    function test_article_form_renders()
    {
        $this->get(route('articles.create'))
            ->assertSeeLivewire('article-form');

        $article = Article::factory()->create();

        $this->get(route('articles.edit', $article))
            ->assertSeeLivewire('article-form');
    }

    function test_blade_template_is_wired()
    {
        Livewire::test('article-form')
            ->assertSeeHtml('wire:submit.prevent="save"')
            ->assertSeeHtml('wire:model="article.title"')
            ->assertSeeHtml('wire:model="article.content"')
        ;
    }

    function test_can_create_new_articles()
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

    function test_can_update_articles()
    {
        $article = Article::factory()->create();
        Livewire::test('article-form', ['article' => $article])
            ->assertSet('article.title', $article->title)
            ->assertSet('article.content', $article->content)
            ->set('article.title', 'New Title 0608')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('home'))
        ;

        $this->assertDatabaseHas('articles', [
            'title' => 'New Title 0608'
        ]);

        $this->assertDatabaseCount('articles', 1);
    }

    function test_title_is_required()
    {
        Livewire::test('article-form')
            ->set('article.content', 'Article Content')
            ->call('save')
            ->assertHasErrors(['article.title' => 'required'])
            // Check the Blade component too
            ->assertSeeHtml(__('validation.required', ['attribute' => 'title']))
        ;
    }

    function test_title_must_be_4_characters_min()
    {
        Livewire::test('article-form')
            ->set('article.title', 'one')
            ->call('save')
            ->assertHasErrors(['article.title' => 'min:4'])
            ->assertSeeHtml(__('validation.min.string', [
                'attribute' => 'title',
                'min' => 4
            ]))

        ;
    }

    function test_content_is_required()
    {
        Livewire::test('article-form')
            ->set('article.content', '')
            ->call('save')
            ->assertHasErrors(['article.content' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => 'content']))
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
