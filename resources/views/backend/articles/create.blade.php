<x-backend-layout title="Créer un article" width="max-w-2xl">
    <h1 class="text-2xl font-semibold text-gray-900">
        <form method="post" action="{{ route('console.articles.store') }}">
            @csrf
            <div class="mt-4 max-w-lg">
                <x-input-label for="title">Titre de l'article</x-input-label>
                <x-input name="title" autofocus placeholder="" />
            </div>
            <x-button type="submit" class="mt-4">
                Créer
            </x-button>
        </form>
</x-backend-layout>
