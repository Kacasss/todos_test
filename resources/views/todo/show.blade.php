<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-center items-center">
            詳細画面
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">

                    <x-message :message="session('message')" />
                        <!-- エラーメッセージ、投稿後メッセージがない場合はmy-8付与 -->
                        <table class="min-w-full text-xs sm:text-sm font-light text-center {{empty($errors->all()) && is_null(session('message')) ? 'my-8' : ''}}">
                            <thead class="border-b bg-neutral-600 font-medium text-white">
                                <tr>
                                    <th scope="col" class="px-2 py-4">項目名</th>
                                    <th scope="col" class="px-2 py-4">担当者</th>
                                    <th scope="col" class="px-2 py-4">登録日</th>
                                    <th scope="col" class="px-2 py-4">期限日</th>
                                    <th scope="col" class="px-2 py-4">完了日</th>
                                    <th scope="col" class="px-2 py-4">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- 完了日に日付がある場合、取り消し線を引く-->
                                <tr class="border-b bg-neutral-50 dark:border-neutral-500 dark:bg-neutral-700 {{is_null($todo->finished_date) ? '' : 'line-through'}}">
                                    <td class="whitespace-wrap px-6 py-4">{{$todo->item_name}}</td>
                                    <td class="whitespace-wrap px-6 py-4">{{$todo->user->name}}</td>
                                    <td class="whitespace-wrap px-6 py-4">{{$todo->registration_date}}</td>
                                    
                                    <!-- 完了日が未で、期限日が過去日の場合、文字を赤くする -->
                                    <td class="whitespace-wrap px-6 py-4 {{is_null($todo->finished_date) && $todo->expire_date < now()->format('Y-m-d') ? 'text-red-500' : ''}} ">
                                        {{$todo->expire_date}}
                                    </td>
                                    <td class="whitespace-wrap px-6 py-4">
                                        {{is_null($todo->finished_date) ? '未' : $todo->finished_date}}
                                    </td>

                                    <td class="whitespace-wrap px-6 py-4 flex justify-center">
                                        <!-- ユーザーが投稿したTODOリストのみ編集可能 -->
                                        @if(Auth::check() && Auth::user()->id === $todo->user_id)
                                            <a href="">
                                                <x-primary-button class="bg-purple-700 hover:bg-purple-800 focus:bg-purple-800">完了</x-primary-button>
                                            </a>
                                            <a href="{{route('todo.edit', $todo)}}">
                                                <x-primary-button class="bg-sky-700 ml-2 hover:bg-sky-800 focus:bg-sky-800">編集</x-primary-button>
                                            </a>
                                            <form method="post" action="{{route('todo.destroy', $todo)}}">
                                                @csrf
                                                @method('delete')
                                                <x-primary-button class="bg-red-700 ml-2" onClick="return confirm('本当に削除しますか？');">削除</x-primary-button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            </tbody>
                        </table>

                        @if($todo->image)
                            <div class="text-center">
                                (画像ファイル：{{$todo->image}})
                                <img src="{{ asset('storage/images/'.$todo->image)}}" class="mx-auto" style="height:300px;">
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>