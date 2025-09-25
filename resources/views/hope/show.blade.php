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

        #container img {
            position: absolute;
            max-width: 15vw; /* متجاوب حسب العرض */
            height: auto;
        }

        .east-img {
            top: 50%;
            right: 5%;
            transform: translateY(-50%);
        }

        .logo-img {
            top: 40%;
            left: 5%;
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
        <div class="center-text">بصمة وعي</div>
        <img src="{{ asset('storage/east.png') }}" class="east-img" />
        <img src="{{ asset('storage/logo.png') }}" class="logo-img" />
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
        const maxHands = 41; // 20 صغير + 20 كبير + اليد 41
        let positions = [];

        function calculatePositions() {
            positions = [];

            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;

            // المقياس الأساسي حسب حجم الشاشة
            const baseScale = Math.min(window.innerWidth, window.innerHeight) / 40;

            // 🔹 القلب الصغير (20 كف)
            const smallScale = baseScale * 1;
            for (let i = 0; i < 20; i++) {
                const t = Math.PI - (i / 20) * 2 * Math.PI;
                const x = 16 * Math.pow(Math.sin(t), 3);
                const y = 13 * Math.cos(t) - 5 * Math.cos(2 * t) - 2 * Math.cos(3 * t) - Math.cos(4 * t);

                positions.push({
                    x: centerX + x * smallScale,
                    y: centerY - y * smallScale
                });
            }

            // 🔹 القلب الكبير — خلي الفرق بسيط
            // خلي القلب الكبير أوسع + نزود فرق مسافة منتظم
            const spacing = baseScale * 4; // 🔹 المسافة بين القلبين
            const bigScale = smallScale * 1.3;
            const offsetBigY = -baseScale * 0.5; // نخليه في نفس المركز العمودي

            //const bigScale = baseScale * 1.3;   // كان 1.5 → صغّرنا
            //const offsetBigY = -baseScale * 1;  // كان -3 → قربنا لتحت
            for (let i = 0; i < 20; i++) {
                const t = Math.PI - (i / 20) * 2 * Math.PI;
                const x = 16 * Math.pow(Math.sin(t), 3);
                const y = 13 * Math.cos(t) - 5 * Math.cos(2 * t) - 2 * Math.cos(3 * t) - Math.cos(4 * t);

                positions.push({
                    x: centerX + x * bigScale,
                    y: centerY - y * bigScale + offsetBigY
                });
            }

            // 🔹 اليد رقم 41 (على يمين القلب الكبير)
            positions.push({
                x: centerX + bigScale * 10,  // يمين القلب الكبير
                y: centerY + bigScale * 4  // Slight down
            });
        }

        // أول حساب
        calculatePositions();

        // إعادة الحساب عند تغيير حجم الشاشة
        window.addEventListener("resize", () => {
            calculatePositions();
            hands.forEach((handEl, index) => {
                const pos = positions[index];
                if (pos) {
                    handEl.style.left = pos.x + "px";
                    handEl.style.top = pos.y + "px";
                }
            });
        });

        // الاستماع للقناة
        window.Echo.channel("hope-channel")
            .listen(".new-hand", (data) => {
                const container = document.getElementById("container");

                if (hands.length < maxHands) {
                    const handEl = document.createElement("img");
                    handEl.src = "{{ asset('storage/hand.png') }}";
                    handEl.className = "hand";
                    handEl.dataset.index = hands.length;

                    const pos = positions[hands.length];
                    handEl.style.position = "absolute";
                    handEl.style.left = pos.x + "px";
                    handEl.style.top = pos.y + "px";

                    container.appendChild(handEl);
                    hands.push(handEl);
                } else {
                    const oldHand = hands.find(h => h.dataset.index == maxHands - 1);
                    if (oldHand) {
                        oldHand.classList.add("fade-out");
                        setTimeout(() => oldHand.remove(), 500);
                        hands = hands.filter(h => h !== oldHand);
                    }

                    const handEl = document.createElement("img");
                    handEl.src = "{{ asset('storage/hand.png') }}";
                    handEl.className = "hand";
                    handEl.dataset.index = maxHands - 1;

                    const pos = positions[maxHands - 1];
                    handEl.style.position = "absolute";
                    handEl.style.left = pos.x + "px";
                    handEl.style.top = pos.y + "px";

                    container.appendChild(handEl);
                    hands.push(handEl);
                }
            });
    </script>






@endsection
