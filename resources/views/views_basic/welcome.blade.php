<!doctype html>
<html lang="{{ env('APP_LANG_HTML') }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('basic.meta_title') }}</title>
    <meta name="description" content="{{ __('basic.meta_description') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="robots" content="index, follow">

    {!! \App\Services\HomeService::getTagManagerHEAD() !!}


    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <link rel="canonical" href="{{ route('index') }}">
    <meta name="keywords" content="{{ __('basic.meta_keywords') }}">

    <meta property="og:title" content="{{ __('basic.meta_title') }}">
    <meta property="og:description" content="{{ __('basic.meta_description') }}">
    {{--    <meta property="og:image" content="{{ $basic_website_structure_op_image_img_file }}">--}}
    <meta property="og:url" content="{{ route('index') }}">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
{!! \App\Services\HomeService::getTagManagerBODY() !!}


<div>
    <div class="bg-gray-900" x-data="{ open: true }">
        <header class="absolute inset-x-0 top-0 z-50">
            <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="{{ route('index') }}" class="-m-1.5 p-1.5">
                        <div class="logo_oatllo">aisello</div>
                    </a>
                </div>
                <div class="flex lg:hidden">
                    <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400" @click="open = !open">
                        <span class="sr-only">Open menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <a href="{{ route('index') }}" class="text-sm/6 font-semibold text-white">{{ __('basic.home') }}</a>
                    <a href="{{ route('blog') }}" class="text-sm/6 font-semibold text-white">Blog</a>
                </div>
                {{--                <div class="hidden lg:flex lg:flex-1 lg:justify-end">--}}
                {{--                    <a href="#" class="text-sm/6 font-semibold text-white">Log in <span aria-hidden="true">&rarr;</span></a>--}}
                {{--                </div>--}}
            </nav>
            <!-- Mobile menu, show/hide based on menu open state. -->
            <div class="lg:hidden" role="dialog" aria-modal="true" x-show="!open">
                <!-- Background backdrop, show/hide based on slide-over state. -->
                <div class="fixed inset-0 z-50"></div>
                <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-white/10">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('index') }}" class="-m-1.5 p-1.5">
                            <div class="logo_oatllo">aisello</div>
                        </a>
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-400" @click="open = !open">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/25">
                            <div class="space-y-2 py-6">
                                <a href="{{ route('index') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-gray-800">{{ __('basic.home') }}</a>
                                <a href="{{ route('blog') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-gray-800">Blog</a>
                            </div>
                            {{--                            <div class="py-6">--}}
                            {{--                                <a href="#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-gray-800">Log in</a>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="relative isolate pt-14">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            <div class="py-24 sm:py-32 lg:pb-40">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h1 class="text-balance text-5xl font-semibold tracking-tight text-white sm:text-5xl">{{ __('basic.blog_header') }}</h1>
                        <p class="mt-8 text-pretty text-lg font-medium text-gray-400 sm:text-xl/8">{{ __('basic.blog_subheader') }}</p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <a href="#about_me" class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400">{{ __('basic.more') }}</a>
                            <a href="{{ route('blog') }}" class="text-sm/6 font-semibold text-white">Blog <span aria-hidden="true">→</span></a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
                <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
        </div>
    </div>



{{--    <div class="bg-gray-900 pb-16 pt-24 sm:pb-24 sm:pt-32 xl:pb-32" id="about_me">--}}
{{--        <div class="bg-gray-900 pb-20 sm:pb-24 xl:pb-0">--}}
{{--            <div class="mx-auto flex max-w-7xl flex-col items-center gap-x-8 gap-y-10 px-6 sm:gap-y-8 lg:px-8 xl:flex-row xl:items-stretch">--}}
{{--                <div class="-mt-8 w-full max-w-2xl xl:-mb-8 xl:w-96 xl:flex-none">--}}
{{--                    <div class="relative aspect-[2/1] h-full md:-mx-8 xl:mx-0 xl:aspect-auto text-center">--}}
{{--                        <img class="absolute inset-0  rounded-2xl bg-gray-800 object-cover shadow-2xl m-auto" src="{{ asset('/assets/images/owsianka_jakub.png') }}" alt="Owsianka Jakub - programista, pasjonat dobrego kodu, programowanie php">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="w-full max-w-2xl xl:max-w-none xl:flex-auto xl:px-16 xl:py-24">--}}
{{--                    <figure class="relative isolate pt-6 sm:pt-12">--}}
{{--                        <svg viewBox="0 0 162 128" fill="none" aria-hidden="true" class="absolute left-0 top-0 -z-10 h-32 stroke-white/20">--}}
{{--                            <path id="b56e9dab-6ccb-4d32-ad02-6b4bb5d9bbeb" d="M65.5697 118.507L65.8918 118.89C68.9503 116.314 71.367 113.253 73.1386 109.71C74.9162 106.155 75.8027 102.28 75.8027 98.0919C75.8027 94.237 75.16 90.6155 73.8708 87.2314C72.5851 83.8565 70.8137 80.9533 68.553 78.5292C66.4529 76.1079 63.9476 74.2482 61.0407 72.9536C58.2795 71.4949 55.276 70.767 52.0386 70.767C48.9935 70.767 46.4686 71.1668 44.4872 71.9924L44.4799 71.9955L44.4726 71.9988C42.7101 72.7999 41.1035 73.6831 39.6544 74.6492C38.2407 75.5916 36.8279 76.455 35.4159 77.2394L35.4047 77.2457L35.3938 77.2525C34.2318 77.9787 32.6713 78.3634 30.6736 78.3634C29.0405 78.3634 27.5131 77.2868 26.1274 74.8257C24.7483 72.2185 24.0519 69.2166 24.0519 65.8071C24.0519 60.0311 25.3782 54.4081 28.0373 48.9335C30.703 43.4454 34.3114 38.345 38.8667 33.6325C43.5812 28.761 49.0045 24.5159 55.1389 20.8979C60.1667 18.0071 65.4966 15.6179 71.1291 13.7305C73.8626 12.8145 75.8027 10.2968 75.8027 7.38572C75.8027 3.6497 72.6341 0.62247 68.8814 1.1527C61.1635 2.2432 53.7398 4.41426 46.6119 7.66522C37.5369 11.6459 29.5729 17.0612 22.7236 23.9105C16.0322 30.6019 10.618 38.4859 6.47981 47.558L6.47976 47.558L6.47682 47.5647C2.4901 56.6544 0.5 66.6148 0.5 77.4391C0.5 84.2996 1.61702 90.7679 3.85425 96.8404L3.8558 96.8445C6.08991 102.749 9.12394 108.02 12.959 112.654L12.959 112.654L12.9646 112.661C16.8027 117.138 21.2829 120.739 26.4034 123.459L26.4033 123.459L26.4144 123.465C31.5505 126.033 37.0873 127.316 43.0178 127.316C47.5035 127.316 51.6783 126.595 55.5376 125.148L55.5376 125.148L55.5477 125.144C59.5516 123.542 63.0052 121.456 65.9019 118.881L65.5697 118.507Z" />--}}
{{--                            <use href="#b56e9dab-6ccb-4d32-ad02-6b4bb5d9bbeb" x="86" />--}}
{{--                        </svg>--}}
{{--                        <blockquote class="text-xl/8 font-semibold text-white sm:text-2xl/9">--}}
{{--                            <p>{{ __('basic.about_me_content') }}</p>--}}
{{--                        </blockquote>--}}
{{--                        <figcaption class="mt-8 text-base">--}}
{{--                            <div class="font-semibold text-white">Jakub Owsianka</div>--}}
{{--                            <div class="mt-1 text-gray-400">{{ __('basic.about_me_description') }}</div>--}}
{{--                        </figcaption>--}}
{{--                    </figure>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}



    @if($randomArticles->count() > 0)
        <div class="jetbrains_bg_color py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-balance text-4xl font-semibold tracking-tight text-white sm:text-5xl jetbrains_text">{{ __('basic.header_blog') }}</h2>
                    <p class="mt-2 text-lg/8 text-white jetbrains_text">{{ __('basic.header_sub_blog') }}</p>
                </div>
                <div class="mx-auto mt-16 grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach($randomArticles as $article)
                        <article class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-900 px-8 pb-8 pt-80 sm:pt-48 lg:pt-80">
                            <img src="{{ $article->image }}" alt="{{ $article->name }}" class="absolute inset-0 -z-10 h-full w-full object-cover">
                            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                            <div class="absolute inset-0 -z-10 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>

                            <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm/6 text-gray-300 jetbrains_text">
                                <time datetime="{{ $article->created_at->format('Y-m-d') }}" class="mr-8">{{ $article->created_at->format('Y-m-d') }}</time>
                                <div class="-ml-4 flex items-center gap-x-4">
                                    <svg viewBox="0 0 2 2" class="-ml-0.5 h-0.5 w-0.5 flex-none fill-white/50">
                                        <circle cx="1" cy="1" r="1" />
                                    </svg>
                                    <div class="flex gap-x-2.5 jetbrains_text">
                                        <img src="{{ asset('/assets/images/owsianka_jakub.png') }}" alt="" class="h-6 w-6 flex-none rounded-full bg-white/10">
                                        Owsianka Jakub
                                    </div>
                                </div>
                            </div>
                            <h3 class="mt-3 text-lg/6 font-semibold text-white  jetbrains_text">
                                <a href="{{ $article->getRoute() }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $article->name }}
                                </a>
                            </h3>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    @endif





</div>


</body>
</html>
