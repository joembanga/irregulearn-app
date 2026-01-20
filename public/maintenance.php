<?php
// maintenance.php - App Maintenance Page
header('HTTP/1.1 503 Service Temporarily Unavailable');
header('Retry-After: 3600');
?>
<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance en cours - IrreguLearn</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7c3aed',
                        surface: '#ffffff',
                        'app-bg': '#f8fafc',
                        'text-body': '#0f172a',
                        'text-muted': '#64748b',
                    },
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                    borderRadius: {
                        'xl': '0.75rem',
                        '2xl': '1rem',
                    },
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #f8fafc;
            background-image: radial-gradient(at 0% 0%, rgba(124, 58, 237, 0.05) 0px, transparent 50%),
                              radial-gradient(at 100% 0%, rgba(59, 130, 246, 0.05) 0px, transparent 50%);
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .gradient-text {
            background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="font-sans text-text-body min-h-screen flex flex-col items-center py-12 md:py-24 p-6 antialiased">

    <div class="max-w-2xl w-full text-center space-y-12">
        <!-- Logo Section -->
        <div class="flex flex-col items-center justify-center animate-pulse">
            <div class="flex items-center gap-3">
                <div class="bg-primary text-white p-3 rounded-xl font-bold text-2xl shadow-lg shadow-primary/20">
                    IL
                </div>
                <span class="font-bold text-3xl tracking-tight text-text-body">
                    Irregu<span class="text-primary">Learn</span>
                </span>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="glass p-8 md:p-12 rounded-3xl shadow-2xl border border-white/50 relative overflow-hidden">
            <!-- Decorative light patterns -->
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-blue-400/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col items-center">
                <!-- Gears Illustration -->
                <div class="relative w-48 h-48 mb-12 flex items-center justify-center">
                    <!-- Large Gear -->
                    <svg class="w-32 h-32 text-primary animate-[spin_10s_linear_infinite]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"></path>
                        <path d="M12 2v2"></path>
                        <path d="M12 20v2"></path>
                        <path d="M4.93 4.93l1.41 1.41"></path>
                        <path d="M17.66 17.66l1.41 1.41"></path>
                        <path d="M2 12h2"></path>
                        <path d="M20 12h2"></path>
                        <path d="M4.93 19.07l1.41-1.41"></path>
                        <path d="M17.66 6.34l1.41-1.41"></path>
                    </svg>
                    <!-- Small Gear -->
                    <svg class="w-20 h-20 text-blue-500 absolute -bottom-2 -right-2 animate-[spin_8s_linear_infinite_reverse]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"></path>
                        <path d="M12 2v2"></path>
                        <path d="M12 20v2"></path>
                        <path d="M4.93 4.93l1.41 1.41"></path>
                        <path d="M17.66 17.66l1.41 1.41"></path>
                        <path d="M2 12h2"></path>
                        <path d="M20 12h2"></path>
                        <path d="M4.93 19.07l1.41-1.41"></path>
                        <path d="M17.66 6.34l1.41-1.41"></path>
                    </svg>
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold text-text-body mb-4 leading-tight">
                    Nous préparons <span class="gradient-text">quelque chose de génial</span>
                </h1>
                
                <p class="text-lg text-text-muted mb-8 max-w-lg mx-auto leading-relaxed">
                    IrreguLearn est actuellement en maintenance pour une mise à jour importante. Nous serons de retour très bientôt pour vous offrir la meilleure expérience possible !
                </p>

                <!-- Status Badge -->
                <div class="flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full font-semibold text-sm border border-primary/20">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-primary"></span>
                    </span>
                    Travaux en cours...
                </div>
            </div>
        </div>

        <!-- Progress Footer -->
        <div class="w-full max-w-sm mx-auto space-y-3">
            <div class="flex justify-between text-sm font-medium text-text-muted">
                <span>Progression de la mise à jour</span>
                <span>85%</span>
            </div>
            <div class="h-3 w-full bg-white rounded-full overflow-hidden shadow-inner border border-gray-100 p-0.5">
                <div class="h-full bg-linear-to-r from-primary to-blue-500 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: 85%"></div>
            </div>
        </div>

        <!-- Copyright / Contact -->
        <div class="pt-4">
            <p class="text-sm text-text-muted">
                &copy; <?php echo date('Y'); ?> IrreguLearn. Tous droits réservés.
            </p>
        </div>
    </div>

</body>
</html>
