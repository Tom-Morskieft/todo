<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-lg overflow-hidden">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-2/4">{{ __('Task Description') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Priority') }}</th>
                        <th scope="col" class="px-6 py-3">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="/create-task" method="POST">
                        @csrf
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">
                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="task_name" placeholder="Task description" required>
                            </td>
                            <td class="px-6 py-4">
                                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="task_priority" required>
                                    <option value="none">None</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <button name="task_create" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    {{ __('Create Task') }}
                                </button>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
        </div>
    </div>

    @if($tasks->isNotEmpty())
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form action="{{ route('tasks.edit') }}" method="POST">
                    @csrf
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-lg overflow-hidden">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">
                                    <input type="checkbox" name="task-select-all">
                                </th>
                                <th scope="col" class="px-6 py-3 w-2/4">{{ __('Task Description') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Priority') }}</th>
                                <th scope="col" class="px-6 py-3">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="tasks-body">
                            @foreach($tasks as $task)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-4 py-4">
                                        <input type="checkbox" name="task[{{ $task['id'] }}][task-select-all]">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="task[{{ $task['id'] }}][task_name]" placeholder="Task description" value="{{ $task['task_name'] }}" required>
                                    </td>
                                    <td class="px-6 py-4">
                                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="task[{{ $task['id'] }}][task_priority]" required>
                                            <option {{ $task['task_priority'] == 'none' ? 'selected' : '' }} value="none">None</option>
                                            <option {{ $task['task_priority'] == 'low' ? 'selected' : '' }} value="low">Low</option>
                                            <option {{ $task['task_priority'] == 'medium' ? 'selected' : '' }} value="medium">Medium</option>
                                            <option {{ $task['task_priority'] == 'high' ? 'selected' : '' }} value="high">High</option>
                                            <option {{ $task['task_priority'] == 'critical' ? 'selected' : '' }} value="critical">Critical</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" type="submit" name="task[{{ $task['id'] }}][task_complete]">
                                            {{ __('Mark as done') }}
                                        </button>
                                        <button class="delete-task-button focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 ms-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" data-task-id="{{ $task['id'] }}">
                                            {{ __('Delete ticket') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal for creating a new task -->
    <dialog id="createTaskModal" class="rounded-lg">
        <form id="createTaskForm" action="/create-task" method="POST" class="p-6 space-y-6">
            @csrf
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Create New Task') }}</h3>
            </div>
            <div>
                <label for="task_name" class="block text-sm font-medium text-gray-700">Task Description</label>
                <div class="mt-1">
                    <input type="text" name="task_name" id="task_name" class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>
            </div>
            <div class="mt-4">
                <label for="task_priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <div class="mt-1">
                    <select name="task_priority" id="task_priority" class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                        <option value="none">None</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
            </div>
            <div class="mt-5 sm:mt-6">
                <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                    {{ __('Create Task') }}
                </button>
            </div>
            <div class="mt-2">
                <button type="button" id="closeModal" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                    {{ __('Close') }}
                </button>
            </div>
        </form>
    </dialog>
</x-app-layout>
