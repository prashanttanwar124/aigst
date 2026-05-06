<?php

use Inertia\Testing\AssertableInertia as Assert;

it('renders public marketing pages for guests', function (string $routeName, string $component) {
    $this->get(route($routeName))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component($component)
            ->has('seo', fn (Assert $seo) => $seo
                ->where('siteName', 'Indian Grocery & Takeout')
                ->where('defaultTitle', 'Indian Grocery & Takeout')
                ->where('defaultImage', '/indian_grocery_takeout.jpg')
                ->has('baseUrl')
                ->has('defaultDescription')
                ->has('locale')
                ->etc()
            ));
})->with([
    ['home', 'Welcome'],
    ['menu', 'Menu'],
    ['catering', 'Catering'],
    ['party-trays', 'PartyTrays'],
    ['contact', 'Contact'],
]);

it('serves a sitemap for public marketing pages', function () {
    $this->get(route('sitemap'))
        ->assertOk()
        ->assertHeaderContains('Content-Type', 'application/xml')
        ->assertSee(route('home'), escape: false)
        ->assertSee(route('menu'), escape: false)
        ->assertSee(route('catering'), escape: false)
        ->assertSee(route('party-trays'), escape: false)
        ->assertSee(route('contact'), escape: false);
});
