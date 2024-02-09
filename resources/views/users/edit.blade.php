<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class=" mx-auto sm:px-6 lg:px-1">
            <div>
                <!-- Start block -->
                <div class="bg-slate-100 dark:bg-gray-900 p-3 sm:p-5 antialiased">
                    <div class="mx-auto max-w-screen-xl max-h-full px-4 lg:px-12">
                        <!-- Start coding here -->
                        <div class="bg-white dark:bg-gray-800 relative  shadow-md sm:rounded-lg overflow-hidden">
                            <div class="relative p-4 bg-white rounded-lg shadow  dark:bg-gray-800 sm:p-5">
                                <!--header -->
                                <div
                                    class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Update User</h3>
                                </div>
                                <!-- body -->
                                <form action="{{ route('users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                        <div>
                                            <label for="name"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                            <input type="text" name="name" id="name" value="{{ $user->name }}"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="Name" required="">
                                        </div>

                                        <div>
                                            <label for="email"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                            <input type="email" name="email" id="email" value="{{ $user->email }}"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="Email" required="">
                                        </div>
                                        <div>
                                            <label for="password"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                            <input type="password" name="password" id="password"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="Password" required="">
                                        </div>
                                        <div>
                                            <label for="confirmPassword"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                                                Password</label>
                                            <input type="password" name="confirm-password" id="Confirm-password"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="Confirm Password" required="">
                                        </div>
                                        <div>
                                            <label for="confirmPassword"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                Image</label>
                                            <input id="file_input" type="file" name="image"
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:ring-primary-600 focus:border-primary-600 focus:outline-none dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                                        </div>

                                        <div class="relative">
                                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Permission</label>
                                            <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch"
                                                data-dropdown-placement="bottom"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium w-full  rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                type="button">Add Role <svg class="w-2.5 h-2.5 ms-3"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 10 6">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                                </svg>
                                            </button>
                                            <div id="dropdownSearch"
                                                class="z-10 absolute w-full hidden bg-white rounded-lg shadow dark:bg-gray-700">
                                                <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdownSearchButton">
                                                    <!-- Roles list -->
                                                    @foreach ($roles as $roleName => $roleLabel)
                                                        <li>
                                                            <div class="flex items-center ps-2 px-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                                                <input id="{{ $roleName }}" type="checkbox" name="roles[]" value="{{ $roleName }}"
                                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                                    {{ in_array($roleName, $userRole) ? 'checked' : '' }}>
                                                                <label for="{{ $roleName }}"
                                                                    class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{ $roleLabel }}</label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                    <button type="submit"
                                        class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Edit User
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End block -->
            </div>
        </div>
    </div>
</x-app-layout>

<script></script>
