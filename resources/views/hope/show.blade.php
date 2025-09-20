@extends('layouts.app2')

@section('title', 'بصمة أمل - الشاشة الكبيرة')

@section('content')
    <style>
        body {
            margin: 0;
            background-color: black;
            overflow: hidden;
        }

        #container {
            position: relative;
            width: 100vw;
            height: 100vh;
        }

        .center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 6rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 0 20px #f39c12, 0 0 40px #f39c12;
            z-index: 10;
        }

        .hand {
            position: absolute;
            font-size: 3.5rem;
            color: #fff;
            animation: pop 0.6s ease;
        }

        @keyframes pop {
            0% { transform: scale(0); opacity: 0; }
            70% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>

    <div id="container">
        <div class="center-text">أمل</div>
    </div>

    {{-- استدعاء Laravel Echo و Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        let hands = [];
        const maxHands = 20;
        const positions = [];

        // حساب أماكن الكفوف حوالين كلمة "أمل"
        const radius = 250;
        const centerX = window.innerWidth / 2;
        const centerY = window.innerHeight / 2;

        for (let i = 0; i < maxHands; i++) {
            const angle = (i / maxHands) * 2 * Math.PI;
            const x = radius * Math.cos(angle) + centerX;
            const y = radius * Math.sin(angle) + centerY;
            positions.push({ x, y });
        }

        // الاستماع للقناة
        window.Echo.channel("hope-channel")
            .listen(".new-hand", (data) => {
                const container = document.getElementById("container");

                if (hands.length < maxHands) {
                    const handEl = document.createElement("div");
                    handEl.className = "hand";
                    handEl.innerText = data.hand;
                    handEl.style.left = positions[hands.length].x + "px";
                    handEl.style.top = positions[hands.length].y + "px";
                    container.appendChild(handEl);
                    hands.push(handEl);
                } else {
                    // استبدل الأقدم
                    const oldHand = hands.shift();
                    oldHand.remove();

                    const handEl = document.createElement("div");
                    handEl.className = "hand";
                    handEl.innerText = data.hand;
                    handEl.style.left = positions[maxHands - 1].x + "px";
                    handEl.style.top = positions[maxHands - 1].y + "px";
                    container.appendChild(handEl);
                    hands.push(handEl);
                }
            });
    </script>
@endsection
