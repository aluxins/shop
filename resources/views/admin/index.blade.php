<x-app-layout>
    <x-admin.navigation />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{ __('Admin panel') }}
                <script type="module">
                    tinymce.init({
                        selector: '#mytextarea'
                    });
                </script>
                <form method="post">
                    <label for="mytextarea"></label>
                    <textarea id="mytextarea">Hello, World!</textarea>
                    <button>Save</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
