<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-center items-center">
            一覧画面
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">

                        <table class="min-w-full text-xs sm:text-sm font-light text-center my-8">
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
                                @foreach ($todos as $todoIndex => $todo)
                                    <!-- 完了日に日付がある場合、取り消し線を引く-->
                                    @if ($todoIndex % 2 === 0)
                                        <tr class="border-b bg-neutral-50 dark:border-neutral-500 dark:bg-neutral-700 {{is_null($todo->finished_date) ? '' : 'line-through'}}">
                                    @else
                                        <tr class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600 {{is_null($todo->finished_date) ? '' : 'line-through'}}">
                                    @endif
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
                                            <td class="whitespace-wrap px-6 py-4">
                                                <a href="{{route('todo.show', $todo)}}">
                                                    <x-primary-button class="bg-cyan-700 hover:bg-cyan-800 focus:bg-cyan-800">詳細</x-primary-button>
                                                </a>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>