<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2>Загрузка файла</h2>
                    <form action="{{ route('file.uploader') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4">
                            <x-text-input id="file" class="block mt-1 w-full"
                                          type="file"
                                          name="file"
                                          required/>

                            @if(!empty($errors->all()))
                                @foreach($errors->all() as $error)
                                    <x-input-error :messages="$error" class="mt-2"/>
                                @endforeach
                            @endif
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3">
                                Загрузить
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
