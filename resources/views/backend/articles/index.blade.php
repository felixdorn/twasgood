<x-backend-layout title="Articles">
    <x-slot:header>
        <a href="{{ route('console.articles.create') }}">
            <x-button type="button">Créer un article</x-button>
        </a>
    </x-slot:header>

    <x-tabs>
        <x-tab-item :active="$state === 'published'" value="published">Publiés ({{ $published_count }})</x-tab-item>
        <x-tab-item :active="$state === 'unpublished'" value="unpublished">Brouillons ({{ $unpublished_count }})</x-tab-item>
    </x-tabs>

    @if (count($articles) > 0)
        <div class="sm:columns-2 lg:columns-3 xl:columns-4 mt-4">
            @foreach ($articles as $article)
                <a href="{{ route('console.articles.edit', $article) }}"
                    class="block mb-4 bg-white rounded-xl border group h-fit break-inside-avoid">
                    @if ($article->banner)
                        <img loading="lazy" src="{{ $article->banner->url }}" class="rounded-t-xl" height="507"
                            width="907" />
                    @else
                        <div
                            class="flex justify-center items-center h-40 text-sm text-gray-700 bg-gray-50 rounded-t-xl border-b">
                            Pas d'aperçu disponible
                        </div>
                    @endif

                    <div class="py-3 px-5">
                        <h3 class="justify-between items-center md:flex">
                            <span class="text-lg group-hover:underline">{{ $article->title }}</span>
                        </h3>

                        @if ($article->description)
                            <p class="mt-2 max-w-xl text-gray-700 truncate">
                                {{ $article->description }}
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="mt-4 bg-white rounded-xl">
            Aucun article.
        </div>
    @endif
</x-backend-layout>
