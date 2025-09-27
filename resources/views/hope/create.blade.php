@extends('layouts.app2')

@section('title', 'بصمة أمل')

@section('content')
    <style>
        body {
            background-color: black;
            margin: 0;
            overflow: hidden;
        }

        #touch-area {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            user-select: none;
            touch-action: manipulation;
            cursor: pointer;
            text-align: center;
        }

        .hand {
            font-size: 8rem;
            animation: pop 0.6s ease;
        }

        @keyframes pop {
            0% { transform: scale(0); opacity: 0; }
            70% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        .hint {
            color: #bbb;
            font-size: 1.5rem;
        }
    </style>

    <div id="touch-area">
        <span class="hint">اضغط ببصمتك لإضافة كف</span>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const area = document.getElementById("touch-area");

        area.addEventListener("click", () => {
            showHand();

            // إرسال Ajax للـ Laravel → يولد event عبر Pusher
            $.post("{{ url('/hope/add-hand') }}", {
                _token: "{{ csrf_token() }}",
                hand: "🖐️"
            });
        });

        function showHand() {
            area.innerHTML = `
        <div class="hand">
            <img src="{{ asset('storage/right_hand.png') }}" />
        </div>
    `;
            setTimeout(() => {
                area.innerHTML = `<span class="hint">اضغط ببصمتك لإضافة كف</span>`;
            }, 1000);
        }

    </script>
@endsection
