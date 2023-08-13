<?php

namespace Tests\Feature\Livewire;

use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;


class ArticleFormTest extends TestCase
{

    use RefreshDatabase;

    function test_article_form_renders()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('articles.create'))
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
            ->assertSeeHtml('wire:model="article.slug"')
        ;
    }

    function test_can_create_new_articles()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('post-image.png');

        $user = User::factory()->create();

        $category = Category::factory()->create();

        Livewire::actingAs($user)->test('article-form')
            ->set('image', $image)
            ->set('article.title', 'New Article')
            ->set('article.slug', 'new-article')
            ->set('article.content', 'Article Content')
            ->set('article.category_id', $category->id)
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('home'))
        ;

        $this->assertDatabaseHas('articles', [
            'image' => $imagePath = Storage::disk('public')->files()[0],
            'title' => 'New Article',
            'slug' => 'new-article',
            'content' => 'Article Content',
            'category_id' => $category->id,
            'user_id' => $user->id
        ]);

        Storage::disk('public')->assertExists($imagePath);
    }

    function test_can_update_articles()
    {
        $article = Article::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)->test('article-form', ['article' => $article])
            ->assertSet('article.title', $article->title)
            ->assertSet('article.slug', $article->slug)
            ->assertSet('article.content', $article->content)
            ->set('article.title', 'New Title 0608')
            ->set('article.slug', 'new-title-0608')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('home'))
        ;

        $this->assertDatabaseHas('articles', [
            'title' => 'New Title 0608',
            'slug' => 'new-title-0608'
        ]);

        $this->assertDatabaseCount('articles', 1);
    }

    function test_can_update_article_image()
    {
        Storage::fake('public');

        $oldImage = UploadedFile::fake()->image('old-image.png');
        $oldImagePath = $oldImage->store('/', 'public');

        $newImage = UploadedFile::fake()->image('new-image.png');

        $article = Article::factory()->create([
            'image' => $oldImagePath
        ]);

        $user = User::factory()->create();

        Livewire::actingAs($user)->test('article-form', ['article' => $article])
            ->set('image', $newImage)
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('home'));

        Storage::disk('public')
            ->assertExists($article->fresh()->image)
            ->assertMissing($oldImagePath);
    }

    function test_image_is_required()
    {
        Livewire::test('article-form')
            ->set('article.title', 'Article Title')
            ->set('article.content', 'Article Content')
            ->call('save')
            ->assertHasErrors(['image' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => 'image']))
            ;
    }

    function test_image_field_should_be_image_type()
    {
        Livewire::test('article-form')
            ->set('image', 'string-not-allowed')
            ->call('save')
            ->assertHasErrors(['image' => 'image'])
            ->assertSeeHtml(__('validation.image', ['attribute' => 'image']))
            ;
    }

    function test_image_must_be_2mb_max()
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('post-image.png')->size(3000);

        Livewire::test('article-form')
            ->set('image', $image)
            ->call('save')
            ->assertHasErrors(['image' => 'max'])
            ->assertSeeHtml(__('validation.max.file', [
                'attribute' => 'image',
                'max' => '2048',
            ]));
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

    function test_slug_is_required()
    {
        Livewire::test('article-form')
            ->set('article.title', 'Article Title')
            ->set('article.slug', null)
            ->set('article.content', 'Article Content')
            ->call('save')
            ->assertHasErrors(['article.slug' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => 'slug']))
        ;
    }

    function test_slug_must_be_unique()
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        Livewire::actingAs($user)->test('article-form')
            ->set('article.title', 'New Article')
            ->set('article.slug', $article->slug)
            ->set('article.content', 'Content')
            ->call('save')
            ->assertHasErrors(['article.slug' => 'unique'])
            ->assertSeeHtml(__('validation.unique', ['attribute' => 'slug']))
        ;
    }

    function test_unique_rule_should_be_ignored_when_updating_same_slug()
    {
        $article = Article::factory()->create();
        $user = User::factory()->create();

        Livewire::actingAs($user)->test('article-form', ['article' => $article])
            ->set('article.title', 'New Title')
            ->set('article.slug', $article->slug)
            ->set('article.content', 'Content')
            ->call('save')
            ->assertHasNoErrors(['article.slug' => 'unique'])
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

    function test_slug_is_generated_automatically()
    {
        Livewire::test('article-form')
            ->set('article.title', 'New Title')
            ->assertSet('article.slug', 'new-title');
    }

    function test_slug_must_only_contain_letters_numbers_dashes_and_underscores()
    {
        Livewire::test('article-form')
            ->set('article.title', 'Title')
            ->set('article.slug', 'title$*%')
            ->set('article.content', 'Content')
            ->call('save')
            ->assertHasErrors(['article.slug' => 'alpha_dash'])
            ->assertSeeHtml(__('validation.alpha_dash', ['attribute' => 'slug']))
            ;
    }

    /**
     * Middleware
     */
    function test_guests_cannot_create_nor_update_articles()
    {
        $this->withExceptionHandling();

        $this->get(route('articles.create'))
            ->assertRedirect('login');

        $article = Article::factory()->create();

        $this->get(route('articles.edit', $article))
            ->assertRedirect('login');
    }
}
