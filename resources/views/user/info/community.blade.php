@php
    $page_title = 'Community Page';
@endphp

@push('css')
    <style>
        main {
            text-align: center;
            padding: 50px 20px;
        }

        .main-container {
            background: #fff;
            padding: 50px;
            border-radius: 10px;
            margin-top: -95px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-container h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .main-container h1 span {
            color: #007bff;
        }

        .main-container p {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .buttons a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .buttons a:hover {
            background-color: #0056b3;
        }

        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/path/to/background-image.png') no-repeat center center/cover;
            z-index: -1;
        }

        .section-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .video-container,
        .guidelines-container {
            flex: 1;
            margin: 20px;
        }

        .video-container iframe {
            width: 100%;
            height: 315px;
            border: none;
        }

        .guidelines-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }

        .guidelines-title {
            background-color: #0066cc;
            color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            font-size: 18px;
            text-align: center;
            margin-bottom: 10px;
        }

        .guidelines-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .guidelines-list li {
            font-size: 16px;
            color: #333333;
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }

        .guidelines-list li:before {
            content: "•";
            color: #0066cc;
            position: absolute;
            left: 0;
        }
        @media screen and (max-width: 768px) {
            .main-container {
                padding: 20px;
                margin-top: -50px;
            }

            .main-container h1 {
                font-size: 24px;
            }

            .main-container p {
                font-size: 18px;
            }

            .buttons {
                flex-direction: column;
            }

            .buttons a {
                width: 100%;
                max-width: 200px;
                margin:  auto;
            }

            .section-container {
                flex-direction: column;
            }

            .video-container,
            .guidelines-container {
                margin: 10px 0;
            }

            .guidelines-container {
                max-width: 100%;
            }
            
        }
    </style>
@endpush

@extends('user.info.layout')
@section('main_section')
    <main>
        <div class="background-pattern"></div>
        <div class="main-container">
            <h1>Welcome to <span>Alumni Community</span></h1>
            <p>ACHIEVING MILESTONES TOGETHER</p>
            <div class="buttons">
                <a>Compare</a>
                <a>Consult</a>
                <a>Connect</a>
            </div>
        </div>
        <div class="section-container">
            <div class="video-container">
                <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video" allowfullscreen></iframe>
            </div>
            <div class="guidelines-container">
                <div class="guidelines-title">COMMUNITY GUIDELINES</div>
                <ul class="guidelines-list">
                    <li>Be respectful, and considerate.</li>
                    <li>No harmful or explicit content.</li>
                    <li>Protect personal information.</li>
                    <li>Report issues and violations.</li>
                    <li>Avoid miscommunication.</li>
                </ul>
            </div>
        </div>
    </main>
@endsection