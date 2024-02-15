<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Add Your Skills') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Add your skills for the job, view the company's announcements, and apply.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.addSkills') }}" class="mt-6 space-y-6">
        @csrf
        <div class="relative">
            <x-input-label for="name" :value="__('Skills')" />
            <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch" data-dropdown-placement="bottom"
                class="mt-1 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">
                {{ __('Add Skills') }}
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="dropdownSearch" class="z-10 absolute w-full hidden bg-white rounded-lg shadow dark:bg-gray-700">
                <ul class="max-h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdownSearchButton">

                    @foreach ($skills as $skill)
                        <li>
                            <div class="flex items-center ps-2 px-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input id="checkbox-item-{{ $skill->id }}" type="checkbox" name="skills[]"
                                    value="{{ $skill->id }}"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="checkbox-item-{{ $skill->id }}"
                                    class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">{{ $skill->name }}</label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('skills[]')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
