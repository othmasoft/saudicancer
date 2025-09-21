@extends('layouts.app3')

@section('title', 'بصمة أمل - رسائل الدعم')

@section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100vw;
            background-color: #fcf5f2; /* لون خلفية للفراغات */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        #hand-container {
            position: relative;
            height: 90vh;             /* 80% من ارتفاع الشاشة */
            width: calc(90vh * 1.3);  /* العرض = الارتفاع × النسبة (1.3) */
            max-width: 1300px;
            max-height: 1000px;
            background: url('{{ asset("storage/hand.jpeg") }}') no-repeat center center;
            background-size: contain; /* الصورة كاملة بدون قص */
            background-position: center center;
            margin: auto;
        }


        .box {
            position: absolute;
            width: 12%;
            height: 6%;
            background: rgba(255,255,255,0.8);
            color: #333;
            font-size: 0.9vw;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2px;
            border-radius: 5px;
            overflow: hidden;
        }

        /* مثال لمواضع */
        .box1  { top: 85%; left: 14%;  transform: rotate(-38deg);}
        .box2  { top: 75%; left: 9%;  transform: rotate(-38deg);}
        .box3  { top: 65%; left: 7%;  transform: rotate(-38deg);}
        .box4  { top: 50%; left: 50%; }
        .box5  { top: 60%; left: 50%; }
        .box6  { top: 70%; left: 50%; }
        .box7  { top: 80%; left: 50%; }
        .box8  { top: 90%; left: 50%; }
        .box9 { top: 20%; left: 50%; }
        .box10  { top: 30%; left: 50%; }
        .box11  { top: 40%; left: 50%; }
        .box12  { top: 50%; left: 50%; }
        .box13 { top: 60%; left: 50%; }
        .box14  { top: 70%; left: 50%; }
        .box15  { top: 80%; left: 50%; }
        .box16  { top: 90%; left: 50%; }
        .box17  { top: 40%; left: 50%; }
        .box18  { top: 40%; left: 50%; }
        .box19  { top: 40%; left: 50%; }
        .box20  { top: 40%; left: 50%; }

    </style>

    <div id="hand-container">
        @for($i = 1; $i <= 20; $i++)
            <div class="box box{{ $i }}">
                {{ $i }}    {{ $supports[$i-1]->message ?? '' }}
            </div>
        @endfor
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentIndex = 0;

        function fetchMessages() {
            $.get("{{ route('support.show') }}", (data) => {
                if (data.message) {
                    let message = data.message.trim(); // نشيل أي "" أو مسافات
                    // نحدد أي box هيتملي
                    let boxNumber = data.count;
                    if (boxNumber > 20) {
                        boxNumber = 20; // بعد الـ 20 هنغير بس آخر box
                    }

                    $(`.box${boxNumber}`).html(message.substring(0,40));

                }
            });
        }

        // كل 2 ثانية يجيب الرسالة اللي بعد كده
        setInterval(fetchMessages, 2000);
    </script>




@endsection
