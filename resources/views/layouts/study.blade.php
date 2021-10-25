<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-base-url" content="{{ url('/') }}" />
    
    <title>{{ config('app.name', 'School') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body> 
    <div data-app="true" class="v-application v-application--is-ltr theme--light" id="app">   
        <div class="v-application--wrap">   
            @if (auth()->user()->prospective > 1)
                <header class="v-sheet v-sheet--tile theme--light v-toolbar v-toolbar--absolute v-toolbar--flat v-app-bar transparent" id="app-bar" style="height: 75px; margin-top: 0px; transform: translateY(0px); left: 260px; right: 0px;" data-booted="true">
                    <div class="v-toolbar__content" style="height: 75px;">
                        <button type="button" class="mr-3 v-btn v-btn--fab v-btn--round theme--light elevation-1 v-size--small"><span class="v-btn__content"><i aria-hidden="true" class="v-icon notranslate mdi mdi-dots-vertical theme--light"></i></span></button>
                        <div class="spacer"> </div>
                        <div class="v-input v-input--hide-details theme--light v-text-field v-text-field--is-booted" style="max-width: 165px;">
                            <div class="v-input__control">
                                <div class="v-input__slot">
                                    <div class="v-text-field__slot"><label for="input-57" class="v-label theme--light" style="left: 0px; right: auto; position: absolute;">Search</label><input id="input-57" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="v-input__append-outer">
                                <button type="button" class="mt-n2 v-btn v-btn--fab v-btn--round theme--light elevation-1 v-size--small"><span class="v-btn__content"><i aria-hidden="true" class="v-icon notranslate mdi mdi-magnify theme--light"></i></span></button>
                            </div>
                        </div>
                    <div class="mx-3"></div>
                   <div class="v-menu"></div>
                </div>
                </header>
                <student-menu></student-menu>
            @endif  
            {{-- {{auth()->user()->prospective > 1}} --}}
            {{-- auth()->user()->prospective > 1 ? 1 : 0 --}}
            <v-content  :class="{'side-menu-cont': {{auth()->user()->prospective > 1  ? 1 : 0  }} }"  data-booted="true">
                <div class="v-content__wrap">
                    <section class="container container--fluid" id="dashboard">
                        {{-- <div class="row"></div> --}}
                        <router-view></router-view>
                        {{-- <vue-progress-bar></vue-progress-bar> --}}
                    </section>
                {{-- <footer class="v-footer v-sheet v-sheet--tile theme--light" id="dashboard-core-footer" data-booted="true">
                    <div class="container">
                        <div class="row no-gutters align-center">
                            <div class="text-center mb-sm-0 mb-5 col col-auto"><a href="#" rel="noopener" target="_blank" class="mr-0 grey--text text--darken-3">About Us</a>
                            </div>
                            <div class="text-center mb-sm-0 mb-5 col col-auto"><a href="#" rel="noopener" target="_blank" class="mr-0 grey--text text--darken-3">Licenses</a>
                            </div>
                            <div class="spacer hidden-sm-and-down"></div>
                            <div class="col-md-auto col-12">
                                <div class="body-1 font-weight-light pt-6 pt-md-0 text-center"> © 2020, made with  for a better web. </div>
                            </div>
                        </div>
                    </div>
                </footer> --}}
                </div>
            </v-content>
        </div>
    </div>
@auth
    <script> 
        window.user = @json(auth()->user()) 
    </script>
@endauth

<script type="application/x-javascript" src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
