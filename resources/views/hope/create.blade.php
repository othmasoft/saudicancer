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
        }

        .hand {
            font-size: 8rem;
            animation: pop 0.5s ease;
        }

        @keyframes pop {
            0% { transform: scale(0); opacity: 0; }
            70% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); }
        }
    </style>

    <div id="touch-area">
        <span class="text-muted">اضغط ببصمتك لإضافة كف</span>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const area = document.getElementById("touch-area");

        area.addEventListener("click", () => {
            addHand();

            // إرسال Ajax للـ Laravel
            $.post("{{ url('/hope/add-hand') }}", {
                _token: "{{ csrf_token() }}",
                hand: "🖐️"
            });
        });

        function addHand() {
            area.innerHTML = "<div class='hand'>🖐️</div>";
            setTimeout(() => {
                area.innerHTML = "<span class='text-muted'>اضغط ببصمتك لإضافة كف</span>";
            }, 1000);
        }
    </script>
@endsection
