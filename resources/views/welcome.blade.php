<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Application de gestion de flotte de véhicules">
    <title>Gestion de Véhicules</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #10b981;
            --accent: #f59e0b;
            --dark: #0f172a;
            --light: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            color: var(--light);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .container {
            text-align: center;
            z-index: 2;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--light);
            margin-bottom: 2rem;
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInDown 0.8s ease-out;
        }
        
        h1 {
            font-size: 4.5rem;
            margin: 1rem 0;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient 8s ease infinite;
            line-height: 1.2;
        }
        
        .tagline {
            font-size: 1.5rem;
            color: #cbd5e1;
            margin-bottom: 3rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            display: inline-block;
        }

        .tagline::after {
            content: '';
            position: absolute;
            width: 60%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), transparent);
            bottom: -10px;
            left: 20%;
            border-radius: 3px;
        }
        
        .buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 3rem;
        }
        
        .btn {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: none;
            min-width: 180px;
            text-align: center;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            transition: transform 0.5s ease;
            transform: scaleX(0);
            transform-origin: right;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary), #6366f1);
            color: white;
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
        }
        
        .btn-primary:hover::before {
            background: linear-gradient(45deg, #6366f1, var(--primary));
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            position: relative;
            overflow: hidden;
        }
        
        .btn-outline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary);
            z-index: -1;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s ease;
        }
        
        .btn-outline:hover {
            color: white;
            border-color: transparent;
        }
        
        .btn-outline:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .btn:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.3);
        }
        
        .btn:active {
            transform: translateY(-2px) scale(1.01);
        }

        .floating-vehicles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .vehicle {
            position: absolute;
            font-size: 2rem;
            opacity: 0.1;
            animation: float 15s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 2.8rem;
            }
            
            .tagline {
                font-size: 1.2rem;
            }
            
            .buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    
    <div class="floating-vehicles">
        <div class="vehicle" style="top: 15%; left: 10%;">🚗</div>
        <div class="vehicle" style="top: 25%; right: 15%; animation-delay: -5s;">🚚</div>
        <div class="vehicle" style="bottom: 20%; left: 20%; animation-delay: -10s;">🚛</div>
        <div class="vehicle" style="bottom: 30%; right: 25%; animation-delay: -7s;">🚙</div>
    </div>
    
    <div class="container">
        <h1>Gestion Complète de Votre Flotte</h1>
        <p class="tagline">Optimisez, gérez et suivez votre parc automobile en temps réel</p>
        
        <div class="buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
            <a href="{{ route('register') }}" class="btn btn-outline">S'inscrire</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            particlesJS('particles-js', {
                particles: {
                    number: { value: 80, density: { enable: true, value_area: 800 } },
                    color: { value: '#4f46e5' },
                    shape: { type: 'circle' },
                    opacity: {
                        value: 0.3,
                        random: true,
                        anim: { enable: true, speed: 1, opacity_min: 0.1 }
                    },
                    size: {
                        value: 3,
                        random: true,
                        anim: { enable: true, speed: 2, size_min: 0.3 }
                    },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: '#4f46e5',
                        opacity: 0.2,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 1,
                        direction: 'none',
                        random: true,
                        straight: false,
                        out_mode: 'out',
                        bounce: false
                    }
                },
                interactivity: {
                    detect_on: 'canvas',
                    events: {
                        onhover: { enable: true, mode: 'grab' },
                        onclick: { enable: true, mode: 'push' },
                        resize: true
                    },
                    modes: {
                        grab: { distance: 140, line_linked: { opacity: 0.5 } },
                        push: { particles_nb: 4 }
                    }
                },
                retina_detect: true
            });
        });
    </script>
</body>
</html>
