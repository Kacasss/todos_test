<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-center items-center">
            編集画面
        </h2>
    </x-slot>

    <!-- エラーメッセージ、投稿後メッセージがない場合はmt-8付与-->
    <div class="w-screen flex justify-center items-center mt-8 {{empty($errors->all()) && is_null(session('message')) ? 'mt-8' : ''}} ">
        <div class="w-full max-w-lg">
            <x-input-error :messages="$errors->all()"/>
            <x-message :message="session('message')" />

            <form method="post" action="{{route('todo.update', $todo)}}" enctype="multipart/form-data" class="bg-white shadow-md rounded px-10 pt-6 pb-8 mb-4">
                @csrf
                @method('patch')


                <div class="mb-4">
                    <label for="item_name" class="block text-gray-700 text-sm font-bold mb-2">項目</label>
                    <input type="text" name="item_name" id="item_name" value="{{old('item_name', $todo->item_name)}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-2">
                    <label for="expire_date" class="block text-gray-700 text-sm font-bold mb-2">期限日</label>
                    <input type="date" name="expire_date" id="expire_date" value="{{old('expire_date', $todo->expire_date)}}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                
                <div class="flex items-center mb-4">
                    <input type="checkbox" name="finished_date" id="default-checkbox" value="1" {{ is_null($todo->finished_date) ? '' : 'checked' }}
                     class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer">完了</label>
                </div>

                @if($todo->image)
                    <div>
                        (画像ファイル：{{$todo->image}})
                    </div>
                    <img src="{{ asset('storage/images/'.$todo->image)}}" class="mx-auto" style="height:200px;">
                @endif

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">画像</label>
                    <input type="file" name="image" id="image"
                    class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700
                    transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100
                    file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem]
                    hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none
                    dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary" />
                </div>

                <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700">更新</x-primary-button>
            </form>
            
        </div>
    </div>

</x-app-layout>