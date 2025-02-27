@push('css')
    <style>
        #popup {
            position: absolute;
            background: #00000044;
            z-index: 9;
            backdrop-filter: blur(3px);
            overflow: hidden;
            height: 0;
            width: 0;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s;
        }

        #popup.active {
            height: 100%;
            width: 100%;
        }

        .popup {
            width: 450px;
            min-height: 250px;
            background: white;
            box-shadow: 0 0 40px 0 #00000044;
            border-radius: 10px;
            position: relative;
        }

        #close_popup {
            --dim: 36px;
            position: absolute;
            top: 0;
            right: 0;
            font-size: 1.8rem;
            transform: translate(50%, -50%);
            border-radius: 100px;
            background: white;
        }
    </style>
@endpush
<div class="cflex aic jcc" id="popup">
    <div class="popup">
        <div id="popup_wrapper" style="flex-grow: 1;">
            @yield('popup_content')
        </div>
        <i class="icon fa-solid fa-xmark" id="close_popup" onclick="close_popup()"></i>
    </div>
</div>
@push('script')
    <script>
        function close_popup() {
            $("#popup").removeClass("active");
        }

        function show_popup() {
            $("#popup").addClass("active");
        }
    </script>
@endpush
