<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href={{ asset("css/style.css") }} rel="stylesheet" />
    <link href={{ asset("css/web.css") }} rel="stylesheet" />
    <link href={{ asset("css/app.css") }} rel="stylesheet" />
    <link href={{ asset("layouts/footer.blade.php") }} />
    <link href={{ asset("layouts/business.blade.php") }} />
    <link href={{ asset("layouts/services.blade.php") }} />
    <link href={{ asset("layouts/bottom.blade.php") }} />


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        .swal-icon--error {
            border-color: #f27474;
            -webkit-animation: animateErrorIcon .5s;
            animation: animateErrorIcon .5s
        }

        .swal-icon--error__x-mark {
            position: relative;
            display: block;
            -webkit-animation: animateXMark .5s;
            animation: animateXMark .5s
        }

        .swal-icon--error__line {
            position: absolute;
            height: 5px;
            width: 47px;
            background-color: #f27474;
            display: block;
            top: 37px;
            border-radius: 2px
        }

        .swal-icon--error__line--left {
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            left: 17px
        }

        .swal-icon--error__line--right {
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            right: 16px
        }

        @-webkit-keyframes animateErrorIcon {
            0% {
                -webkit-transform: rotateX(100deg);
                transform: rotateX(100deg);
                opacity: 0
            }

            to {
                -webkit-transform: rotateX(0deg);
                transform: rotateX(0deg);
                opacity: 1
            }
        }

        @keyframes animateErrorIcon {
            0% {
                -webkit-transform: rotateX(100deg);
                transform: rotateX(100deg);
                opacity: 0
            }

            to {
                -webkit-transform: rotateX(0deg);
                transform: rotateX(0deg);
                opacity: 1
            }
        }

        @-webkit-keyframes animateXMark {
            0% {
                -webkit-transform: scale(.4);
                transform: scale(.4);
                margin-top: 26px;
                opacity: 0
            }

            50% {
                -webkit-transform: scale(.4);
                transform: scale(.4);
                margin-top: 26px;
                opacity: 0
            }

            80% {
                -webkit-transform: scale(1.15);
                transform: scale(1.15);
                margin-top: -6px
            }

            to {
                -webkit-transform: scale(1);
                transform: scale(1);
                margin-top: 0;
                opacity: 1
            }
        }

        @keyframes animateXMark {
            0% {
                -webkit-transform: scale(.4);
                transform: scale(.4);
                margin-top: 26px;
                opacity: 0
            }

            50% {
                -webkit-transform: scale(.4);
                transform: scale(.4);
                margin-top: 26px;
                opacity: 0
            }

            80% {
                -webkit-transform: scale(1.15);
                transform: scale(1.15);
                margin-top: -6px
            }

            to {
                -webkit-transform: scale(1);
                transform: scale(1);
                margin-top: 0;
                opacity: 1
            }
        }

        .swal-icon--warning {
            border-color: #f8bb86;
            -webkit-animation: pulseWarning .75s infinite alternate;
            animation: pulseWarning .75s infinite alternate
        }

        .swal-icon--warning__body {
            width: 5px;
            height: 47px;
            top: 10px;
            border-radius: 2px;
            margin-left: -2px
        }

        .swal-icon--warning__body,
        .swal-icon--warning__dot {
            position: absolute;
            left: 50%;
            background-color: #f8bb86
        }

        .swal-icon--warning__dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            margin-left: -4px;
            bottom: -11px
        }

        @-webkit-keyframes pulseWarning {
            0% {
                border-color: #f8d486
            }

            to {
                border-color: #f8bb86
            }
        }

        @keyframes pulseWarning {
            0% {
                border-color: #f8d486
            }

            to {
                border-color: #f8bb86
            }
        }

        .swal-icon--success {
            border-color: #a5dc86
        }

        .swal-icon--success:after,
        .swal-icon--success:before {
            content: "";
            border-radius: 50%;
            position: absolute;
            width: 60px;
            height: 120px;
            background: #fff;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg)
        }

        .swal-icon--success:before {
            border-radius: 120px 0 0 120px;
            top: -7px;
            left: -33px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transform-origin: 60px 60px;
            transform-origin: 60px 60px
        }

        .swal-icon--success:after {
            border-radius: 0 120px 120px 0;
            top: -11px;
            left: 30px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-transform-origin: 0 60px;
            transform-origin: 0 60px;
            -webkit-animation: rotatePlaceholder 4.25s ease-in;
            animation: rotatePlaceholder 4.25s ease-in
        }

        .swal-icon--success__ring {
            width: 80px;
            height: 80px;
            border: 4px solid hsla(98, 55%, 69%, .2);
            border-radius: 50%;
            box-sizing: content-box;
            position: absolute;
            left: -4px;
            top: -4px;
            z-index: 2
        }

        .swal-icon--success__hide-corners {
            width: 5px;
            height: 90px;
            background-color: #fff;
            padding: 1px;
            position: absolute;
            left: 28px;
            top: 8px;
            z-index: 1;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg)
        }

        .swal-icon--success__line {
            height: 5px;
            background-color: #a5dc86;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 2
        }

        .swal-icon--success__line--tip {
            width: 25px;
            left: 14px;
            top: 46px;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            -webkit-animation: animateSuccessTip .75s;
            animation: animateSuccessTip .75s
        }

        .swal-icon--success__line--long {
            width: 47px;
            right: 8px;
            top: 38px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            -webkit-animation: animateSuccessLong .75s;
            animation: animateSuccessLong .75s
        }

        @-webkit-keyframes rotatePlaceholder {
            0% {
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg)
            }

            5% {
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg)
            }

            12% {
                -webkit-transform: rotate(-405deg);
                transform: rotate(-405deg)
            }

            to {
                -webkit-transform: rotate(-405deg);
                transform: rotate(-405deg)
            }
        }

        @keyframes rotatePlaceholder {
            0% {
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg)
            }

            5% {
                -webkit-transform: rotate(-45deg);
                transform: rotate(-45deg)
            }

            12% {
                -webkit-transform: rotate(-405deg);
                transform: rotate(-405deg)
            }

            to {
                -webkit-transform: rotate(-405deg);
                transform: rotate(-405deg)
            }
        }

        @-webkit-keyframes animateSuccessTip {
            0% {
                width: 0;
                left: 1px;
                top: 19px
            }

            54% {
                width: 0;
                left: 1px;
                top: 19px
            }

            70% {
                width: 50px;
                left: -8px;
                top: 37px
            }

            84% {
                width: 17px;
                left: 21px;
                top: 48px
            }

            to {
                width: 25px;
                left: 14px;
                top: 45px
            }
        }

        @keyframes animateSuccessTip {
            0% {
                width: 0;
                left: 1px;
                top: 19px
            }

            54% {
                width: 0;
                left: 1px;
                top: 19px
            }

            70% {
                width: 50px;
                left: -8px;
                top: 37px
            }

            84% {
                width: 17px;
                left: 21px;
                top: 48px
            }

            to {
                width: 25px;
                left: 14px;
                top: 45px
            }
        }

        @-webkit-keyframes animateSuccessLong {
            0% {
                width: 0;
                right: 46px;
                top: 54px
            }

            65% {
                width: 0;
                right: 46px;
                top: 54px
            }

            84% {
                width: 55px;
                right: 0;
                top: 35px
            }

            to {
                width: 47px;
                right: 8px;
                top: 38px
            }
        }

        @keyframes animateSuccessLong {
            0% {
                width: 0;
                right: 46px;
                top: 54px
            }

            65% {
                width: 0;
                right: 46px;
                top: 54px
            }

            84% {
                width: 55px;
                right: 0;
                top: 35px
            }

            to {
                width: 47px;
                right: 8px;
                top: 38px
            }
        }

        .swal-icon--info {
            border-color: #c9dae1
        }

        .swal-icon--info:before {
            width: 5px;
            height: 29px;
            bottom: 17px;
            border-radius: 2px;
            margin-left: -2px
        }

        .swal-icon--info:after,
        .swal-icon--info:before {
            content: "";
            position: absolute;
            left: 50%;
            background-color: #c9dae1
        }

        .swal-icon--info:after {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            margin-left: -3px;
            top: 19px
        }

        .swal-icon {
            width: 80px;
            height: 80px;
            border-width: 4px;
            border-style: solid;
            border-radius: 50%;
            padding: 0;
            position: relative;
            box-sizing: content-box;
            margin: 20px auto
        }

        .swal-icon:first-child {
            margin-top: 32px
        }

        .swal-icon--custom {
            width: auto;
            height: auto;
            max-width: 100%;
            border: none;
            border-radius: 0
        }

        .swal-icon img {
            max-width: 100%;
            max-height: 100%
        }

        .swal-title {
            color: rgba(0, 0, 0, .65);
            font-weight: 600;
            text-transform: none;
            position: relative;
            display: block;
            padding: 13px 16px;
            font-size: 27px;
            line-height: normal;
            text-align: center;
            margin-bottom: 0
        }

        .swal-title:first-child {
            margin-top: 26px
        }

        .swal-title:not(:first-child) {
            padding-bottom: 0
        }

        .swal-title:not(:last-child) {
            margin-bottom: 13px
        }

        .swal-text {
            font-size: 16px;
            position: relative;
            float: none;
            line-height: normal;
            vertical-align: top;
            text-align: left;
            display: inline-block;
            margin: 0;
            padding: 0 10px;
            font-weight: 400;
            color: rgba(0, 0, 0, .64);
            max-width: calc(100% - 20px);
            overflow-wrap: break-word;
            box-sizing: border-box
        }

        .swal-text:first-child {
            margin-top: 45px
        }

        .swal-text:last-child {
            margin-bottom: 45px
        }

        .swal-footer {
            text-align: right;
            padding-top: 13px;
            margin-top: 13px;
            padding: 13px 16px;
            border-radius: inherit;
            border-top-left-radius: 0;
            border-top-right-radius: 0
        }

        .swal-button-container {
            margin: 5px;
            display: inline-block;
            position: relative
        }

        .swal-button {
            background-color: #7cd1f9;
            color: #fff;
            border: none;
            box-shadow: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 24px;
            margin: 0;
            cursor: pointer
        }

        .swal-button:not([disabled]):hover {
            background-color: #78cbf2
        }

        .swal-button:active {
            background-color: #70bce0
        }

        .swal-button:focus {
            outline: none;
            box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(43, 114, 165, .29)
        }

        .swal-button[disabled] {
            opacity: .5;
            cursor: default
        }

        .swal-button::-moz-focus-inner {
            border: 0
        }

        .swal-button--cancel {
            color: #555;
            background-color: #efefef
        }

        .swal-button--cancel:not([disabled]):hover {
            background-color: #e8e8e8
        }

        .swal-button--cancel:active {
            background-color: #d7d7d7
        }

        .swal-button--cancel:focus {
            box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(116, 136, 150, .29)
        }

        .swal-button--danger {
            background-color: #e64942
        }

        .swal-button--danger:not([disabled]):hover {
            background-color: #df4740
        }

        .swal-button--danger:active {
            background-color: #cf423b
        }

        .swal-button--danger:focus {
            box-shadow: 0 0 0 1px #fff, 0 0 0 3px rgba(165, 43, 43, .29)
        }

        .swal-content {
            padding: 0 20px;
            margin-top: 20px;
            font-size: medium
        }

        .swal-content:last-child {
            margin-bottom: 20px
        }

        .swal-content__input,
        .swal-content__textarea {
            -webkit-appearance: none;
            background-color: #fff;
            border: none;
            font-size: 14px;
            display: block;
            box-sizing: border-box;
            width: 100%;
            border: 1px solid rgba(0, 0, 0, .14);
            padding: 10px 13px;
            border-radius: 2px;
            transition: border-color .2s
        }

        .swal-content__input:focus,
        .swal-content__textarea:focus {
            outline: none;
            border-color: #6db8ff
        }

        .swal-content__textarea {
            resize: vertical
        }

        .swal-button--loading {
            color: transparent
        }

        .swal-button--loading~.swal-button__loader {
            opacity: 1
        }

        .swal-button__loader {
            position: absolute;
            height: auto;
            width: 43px;
            z-index: 2;
            left: 50%;
            top: 50%;
            -webkit-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
            text-align: center;
            pointer-events: none;
            opacity: 0
        }

        .swal-button__loader div {
            display: inline-block;
            float: none;
            vertical-align: baseline;
            width: 9px;
            height: 9px;
            padding: 0;
            border: none;
            margin: 2px;
            opacity: .4;
            border-radius: 7px;
            background-color: hsla(0, 0%, 100%, .9);
            transition: background .2s;
            -webkit-animation: swal-loading-anim 1s infinite;
            animation: swal-loading-anim 1s infinite
        }

        .swal-button__loader div:nth-child(3n+2) {
            -webkit-animation-delay: .15s;
            animation-delay: .15s
        }

        .swal-button__loader div:nth-child(3n+3) {
            -webkit-animation-delay: .3s;
            animation-delay: .3s
        }

        @-webkit-keyframes swal-loading-anim {
            0% {
                opacity: .4
            }

            20% {
                opacity: .4
            }

            50% {
                opacity: 1
            }

            to {
                opacity: .4
            }
        }

        @keyframes swal-loading-anim {
            0% {
                opacity: .4
            }

            20% {
                opacity: .4
            }

            50% {
                opacity: 1
            }

            to {
                opacity: .4
            }
        }

        .swal-overlay {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0;
            overflow-y: auto;
            background-color: rgba(0, 0, 0, .4);
            z-index: 10000;
            pointer-events: none;
            opacity: 0;
            transition: opacity .3s
        }

        .swal-overlay:before {
            content: " ";
            display: inline-block;
            vertical-align: middle;
            height: 100%
        }

        .swal-overlay--show-modal {
            opacity: 1;
            pointer-events: auto
        }

        .swal-overlay--show-modal .swal-modal {
            opacity: 1;
            pointer-events: auto;
            box-sizing: border-box;
            -webkit-animation: showSweetAlert .3s;
            animation: showSweetAlert .3s;
            will-change: transform
        }

        .swal-modal {
            width: 478px;
            opacity: 0;
            pointer-events: none;
            background-color: #fff;
            text-align: center;
            border-radius: 5px;
            position: static;
            margin: 20px auto;
            display: inline-block;
            vertical-align: middle;
            -webkit-transform: scale(1);
            transform: scale(1);
            -webkit-transform-origin: 50% 50%;
            transform-origin: 50% 50%;
            z-index: 10001;
            transition: opacity .2s, -webkit-transform .3s;
            transition: transform .3s, opacity .2s;
            transition: transform .3s, opacity .2s, -webkit-transform .3s
        }

        @media (max-width:500px) {
            .swal-modal {
                width: calc(100% - 20px)
            }
        }

        @-webkit-keyframes showSweetAlert {
            0% {
                -webkit-transform: scale(1);
                transform: scale(1)
            }

            1% {
                -webkit-transform: scale(.5);
                transform: scale(.5)
            }

            45% {
                -webkit-transform: scale(1.05);
                transform: scale(1.05)
            }

            80% {
                -webkit-transform: scale(.95);
                transform: scale(.95)
            }

            to {
                -webkit-transform: scale(1);
                transform: scale(1)
            }
        }

        @keyframes showSweetAlert {
            0% {
                -webkit-transform: scale(1);
                transform: scale(1)
            }

            1% {
                -webkit-transform: scale(.5);
                transform: scale(.5)
            }

            45% {
                -webkit-transform: scale(1.05);
                transform: scale(1.05)
            }

            80% {
                -webkit-transform: scale(.95);
                transform: scale(.95)
            }

            to {
                -webkit-transform: scale(1);
                transform: scale(1)
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://www.likeme.co.in/frontend/vendor/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"
        integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcyz59WSQwdAkQtiXeCpBLRAkL6otDGAA&amp;libraries=places"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        const autoplaySpeeds = [3000, 5000, 7000, 4000, 6000];

        function initializeSlick() {
            $(document).ready(function () {
                $('.kuchb').each(function (index) {
                    const autoplaySpeed = autoplaySpeeds[index % autoplaySpeeds.length];

                    $(this).slick({
                        lazyLoad: 'ondemand',
                        slidesToShow: 6,
                        slidesToScroll: 1,
                        arrows: true,
                        dots: false,
                        speed: 700,
                        infinite: true,
                        variableWidth: true,
                        autoplaySpeed: autoplaySpeed,
                        autoplay: true,
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    infinite: true,
                                    dots: false
                                }
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    dots: false
                                }
                            }
                        ]
                    });
                });
            });
        }

        $(document).ready(function () {
            initializeSlick();
        });

        function removelocationtxt() {
            document.getElementById("new_location").value = '';
        }
    </script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        .modal-header,
        h4,
        .close {
            color: white;
            text-align: center;
            font-size: 30px;
        }

        .modal-footer {
            background-color: #f9f9f9;
        }

        .bg-primary {
            background-color: var(--orange) !important;
        }

        .btn-primary {
            background-color: var(--orange) !important;
            border-color: var(--orange) !important;
        }

        a.navbar-brand.img-fluid img {
            mix-blend-mode: darken;
        }

        .reset {
            border: 1px solid #afafaf !important;
        }
    </style>

    <style>
        .staticBackdroop212 {
            z-index: 11111 !important;
        }

        #newdiva {
            display: none !important;
        }

        .show_more_btn .bi {
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 100px;
            background-color: var(--bs-orange);
            color: #ffffff;
            margin: 7px;
            margin-inline: auto;
            margin-bottom: 9px;
            display: inline-block;
        }

        .show_more_btn .bi {
            font-size: 16px;
        }

        .popular_list {
            position: absolute;
            left: 0;
            width: 100%;
            background: #ffffff;
            z-index: 1;
            box-shadow: 0px 8px 8px #00000021;
        }

        .border-bottom_color {
            border-color: #0000001c;
            ;
        }

        .row .kuchb {
            width: 100% !important;
            margin-inline: auto;
        }

        .slick-arrow {
            z-index: 0 !important
        }

        header .fixed-top {
            z-index: 1 !important;
        }

        .slick-prev {
            left: -29px !important;
        }

        .slick-next {
            right: -21px !important;
        }

        .selectcity input:focus-visible {
            outline: none !important;
        }

        .selectcity {
            padding: 5px 14px;
            border: 1px solid #dddeee;
            border-radius: 100000px;
            max-width: 100%;
            width: 250px;
        }

        ul#location_ul li {
            padding: 0;
        }

        ul#location_ul {
            max-height: 306px;
            overflow-y: auto;
            margin: 0;
            top: 4px !important;
            border: 1px solid #dddeee;
            box-shadow: none;
            left: -5px;
            width: 480px;
            border-radius: 20px;
        }

        .dropdown input:focus-visible {
            outline: none !important;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            color: #fff !important;
            text-decoration: none;
            background-color: var(--bs-orange);
        }

        ul.dropdown-menu.dropdown-menu-end.dropdown-menu-arrow.profile.show {
            max-width: 250px !important;
            width: 250px !important;
            margin-top: 15px !important;
        }

        .loading {
            position: relative;
        }

        .loading::after {
            display: block;
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            transform: translateX(-100%);
            background: -webkit-gradient(linear, left top, right top, from(transparent), color-stop(rgba(255, 255, 255, 0.2)), to(transparent));
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.651), transparent);
            animation: loading 0.8s infinite;
            top: 0;
        }

        @keyframes loading {
            100% {
                transform: translateX(100%);
            }
        }

        .botton-popuop {
            bottom: 20px;
            right: -100%;
            z-index: 1;
            transform: translateX(100%);
        }

        .botton-popuop_remove {
            right: 10px;
            transition: right 2s ease;
            transform: translateX(-10%) !important;
        }

        .botton-popuop .btn-close {
            opacity: 1 !important;
        }

        .bsdjcsdcdsisd {
            width: 350px !important;
        }

        .microphoneee {
            width: 30px !important;
            height: 30px !important;
            object-fit: cover !important;
        }
    </style>
    <script type="text/javascript" charset="UTF-8"
        src="https://maps.googleapis.com/maps-api-v3/api/js/62/6d/intl/en_gb/common.js"></script>
    <script type="text/javascript" charset="UTF-8"
        src="https://maps.googleapis.com/maps-api-v3/api/js/62/6d/intl/en_gb/util.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" type="text/javascript">
            
        </script>
    <title>Blog App</title>
</head>

<body>
    @include('layouts.navbar')
    <div class="container">
        @yield('content')
    </div>
    @include('layouts/footer')
    @include('layouts/business')
    @include('layouts/services')
    @include('layouts/bottom')

</body>

</html>