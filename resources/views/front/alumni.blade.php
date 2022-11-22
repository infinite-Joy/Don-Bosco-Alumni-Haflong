<x-front-layout>

    <div class="bg-gradient-to-t from-pink-500 via-red-500 to-blue-500">
        <div class="container py-16 px-3 w-full mx-auto items-center leading-normal tracking-normal">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1  gap-6 mt-6">
                <form action=" " method="POST">
                    @csrf
                    @method('Post')
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" id="default-search"
                            class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search by Batch..." required>
                        <button type="submit"
                            class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                    </div>
                </form>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3  gap-6 mt-6">
                @foreach ($alumni as $alumnus)
                    <a href="{{ route('alumni-detail', $alumnus->id) }}"
                        class="flex flex-col items-center bg-white border rounded-lg shadow-md md:flex-row md:max-w-xl 
                        hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">

                        @if ($alumnus->profile_picture)
                            <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg"
                                src="{{ asset('images/profile/' . $alumnus->profile_picture) }}" alt="">
                        @else
                            <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg"
                                src="{{ asset('images/misc/blank-profile.png') }}" alt="">
                        @endif

                        <div class="flex flex-col justify-between p-4 leading-normal">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $alumnus->first_name }} {{ $alumnus->last_name }}</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 space-x-2"> <i
                                    class="fa-solid fa-graduation-cap"> {{ $alumnus->batch }} </i> <i
                                    class="fa-solid fa-droplet"> {{ $alumnus->blood_group }} </i></p>
                        </div>
                    </a>
                @endforeach

            </div>
            <div class="flex items-center justify-end my-4">
                {{ $alumni->links() }}
            </div>

        </div>
    </div>


</x-front-layout>
