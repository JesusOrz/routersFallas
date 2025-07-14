<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title', 'Detección de Fallas')</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('images/cart.png') }}">

</head>

<body>

    <div class="wrapper">
        @include('partials.sidebar')

        <div class="main">
            @include('partials.navbar')

            <main class="content px-3 py-2">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>

            @include('partials.footer')
        </div>
    </div>

    <div id="chatbot-container" class="hidden">
        <div id="chat-header">
            <i class="fas fa-robot"></i> Asistente Virtual
            <span onclick="toggleChatbot()" class="close-btn">&times;</span>
        </div>
        <div id="chat-window">
            <em>Sugerencias: "api key", "formato de log", "contacto", "registrar router"</em>
        </div>
        <form id="chat-form">
            <div id="chat-input-area">
                <input type="text" id="user-input" placeholder="Escribe tu pregunta..." />
                <button type="submit">Enviar</button>
            </div>
        </form>
    </div>

    








    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    



    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/register.js') }}"></script>
    <script src="{{ asset('js/logs.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <script src="{{ asset('js/analisis.js') }}"></script>
    <script src="{{ asset('js/upload.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}"></script>

    <script>
    const CSRF_TOKEN = "{{ csrf_token() }}";
    const USER_ID = "{{ Auth::user()->id ?? 'null' }}";
    const IA_JSON_URL = "{{ route('ia.json') }}";
    const KEYS_JSON_URL = "{{ route('keys.json') }}";
    const ROUTERS_JSON_URL = "{{ route('routers.json') }}";
    const KEYS_STORE_URL = "{{ route('keys.create') }}";
    const ROUTERS_STORE_URL = "{{ route('routers.create') }}";
    const ANALYSIS_STORE_URL = "{{ route('analysis.create') }}";
    const ROUTERS_UPDATE_URL = "{{ url('/routers/update') }}";
    const GET_LOG = "{{ route('logs.get') }}"
    const UPLOAD_LOG = "{{ route('logs.upload') }}"
    const ANALYZE_LOG = "{{ route('logs.analizar') }}"
    const ANALYSIS_LIST_URL = "{{ url('/tipo-analisis') }}";
    const CHATBOT_RESPONSE = "{{ url('/chatbot') }}";
    </script>

</body>


</html>