@extends('layouts.app2')

@section('title', 'بصمة أمل - الشاشة الكبيرة')

@section('content')
    <style>
        body {
            margin: 0;
            background-color: black;
            overflow: hidden;
            height: 100vh;
        }

        #container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
        }

        .center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 7rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 0 20px #f39c12, 0 0 40px #f39c12;
            z-index: 10;
            white-space: nowrap;
            pointer-events: none;
        }

        .hand {
            position: absolute;
            width: 70px;
            height: auto;
            transform: translate(-50%, -50%);
            animation: pop 0.6s ease;
        }

        @keyframes pop {
            0% { transform: scale(0); opacity: 0; }
            70% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        .fade-out {
            animation: fadeOut 0.5s forwards;
        }

        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0); }
        }
    </style>

    <div id="container">
        <div class="center-text">أمل</div>
    </div>

    {{-- Laravel Echo + Pusher CDN --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>

    <script>
        // إعداد Echo مع Pusher
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: "pusher",
            key: "{{ env('PUSHER_APP_KEY') }}",
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            forceTLS: true
        });

        let hands = [];
        const maxHands = 21;
        const positions = [];

        // القلب لأول 20 كف
        const centerX = window.innerWidth / 2;
        const centerY = window.innerHeight / 2 ;
        const scale = 20;

        for (let i = 0; i < maxHands - 1; i++) {
            const t = Math.PI - (i / (maxHands - 1)) * 2 * Math.PI;
            const x = 16 * Math.pow(Math.sin(t), 3);
            const y = 13 * Math.cos(t) - 5 * Math.cos(2 * t) - 2 * Math.cos(3 * t) - Math.cos(4 * t);

            positions.push({
                x: centerX + x * scale,
                y: centerY - y * scale
            });
        }

        // اليد رقم 21 على يمين القلب
        positions.push({
            x: centerX + 200, // على يمين القلب
            y: centerY + 200       // نفس المستوى الرأسي
        });

        // الاستماع للقناة
        window.Echo.channel("hope-channel")
            .listen(".new-hand", (data) => {
                const container = document.getElementById("container");

                if (hands.length < maxHands) {
                    // أول 21 كف
                    const handEl = document.createElement("img");
                    handEl.src = "{{ asset('storage/hand.png') }}";
                    handEl.className = "hand";
                    handEl.dataset.index = hands.length;

                    const pos = positions[hands.length];
                    handEl.style.left = pos.x + "px";
                    handEl.style.top = pos.y + "px";

                    container.appendChild(handEl);
                    hands.push(handEl);
                } else {
                    // استبدال الكف الأخير فقط (رقم 21)
                    const oldHand = hands.find(h => h.dataset.index == 20);
                    if (oldHand) {
                        oldHand.classList.add("fade-out");
                        setTimeout(() => oldHand.remove(), 500);
                        hands = hands.filter(h => h !== oldHand);
                    }

                    const handEl = document.createElement("img");
                    handEl.src = "{{ asset('storage/hand.png') }}";
                    handEl.className = "hand";
                    handEl.dataset.index = 20;

                    const pos = positions[20];
                    handEl.style.left = pos.x + "px";
                    handEl.style.top = pos.y + "px";

                    container.appendChild(handEl);
                    hands.push(handEl);
                }
            });
    </script>
@endsection
