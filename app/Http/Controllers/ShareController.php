<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verb;
use App\Models\WeeklyReport;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ShareController extends Controller
{
    private const COLOR_WHITE = '#ffffff';

    private const COLOR_PRIMARY = '#7c3aed';

    private const COLOR_MUTED = '#94a3b8';

    protected string $fontPath;

    /**
     * Constructor to set up font path.
     */
    public function __construct()
    {
        // Path to font file from vendor (DejaVuSans is included with dompdf)
        $this->fontPath = base_path('vendor/dompdf/dompdf/lib/fonts/DejaVuSans.ttf');
        if (! file_exists($this->fontPath)) {
            // Fallback just in case
            $this->fontPath = 'arial.ttf';
        }
    }

    /**
     * Entry point for social share images.
     */
    public function generate(string $type, string $identifier)
    {
        $imageData = function () use ($type, $identifier) {
            $manager = new ImageManager(new Driver);

            try {
                $image = match ($type) {
                    'profile' => $this->generateProfileImage($manager, User::where('username', $identifier)->firstOrFail()),
                    'verb' => $this->generateVerbImage($manager, Verb::where('slug', $identifier)->firstOrFail()),
                    'daily' => $this->generateDailyVerbsImage($manager, User::where('username', $identifier)->firstOrFail()),
                    'stats' => $this->generateStatsImage($manager, User::where('username', $identifier)->firstOrFail()),
                    'weekly-report' => $this->generateWeeklyReportImage($manager, WeeklyReport::findOrFail($identifier)),
                    default => abort(404),
                };

                return $image->toPng()->toString();
            } catch (\Exception $e) {
                // If anything fails, we might want to log it and return 404
                return null;
            }
        };

        if (! $imageData()) {
            abort(404);
        }

        return response($imageData())->header('Content-Type', 'image/png');
    }

    private function createBaseCanvas(ImageManager $manager)
    {
        // 1200x630 is the standard Open Graph size
        $image = $manager->create(1200, 630);

        // Background color (Slate 900)
        $image->fill('#0f172a');

        // Abstract decoration (Spotify Style)
        $image->drawCircle(1000, 100, function ($draw) {
            $draw->radius(250);
            $draw->background('rgba(124, 58, 237, 0.1)'); // Violet
        });

        $image->drawCircle(100, 500, function ($draw) {
            $draw->radius(350);
            $draw->background('rgba(59, 130, 246, 0.05)'); // Blue
        });

        // App Logo branding
        $image->drawRectangle(60, 60, function ($draw) {
            $draw->size(60, 60);
            $draw->background(self::COLOR_PRIMARY);
        });

        $image->text('IL', 90, 95, function ($font) {
            $font->filename($this->fontPath);
            $font->size(36);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
            $font->valign('middle');
        });

        $image->text('IrreguLearn', 140, 95, function ($font) {
            $font->filename($this->fontPath);
            $font->size(32);
            $font->color(self::COLOR_WHITE);
            $font->align('left');
            $font->valign('middle');
        });

        // Watermark
        $image->text('jouez sur irregulearn.app', 1140, 580, function ($font) {
            $font->filename($this->fontPath);
            $font->size(20);
            $font->color('rgba(255, 255, 255, 0.3)');
            $font->align('right');
        });

        return $image;
    }

    private function generateProfileImage(ImageManager $manager, User $user)
    {
        $image = $this->createBaseCanvas($manager);

        // Profile Avatar Place (Circle)
        $image->drawCircle(220, 315, function ($draw) {
            $draw->radius(120);
            $draw->background('#1e293b');
            $draw->border(self::COLOR_PRIMARY, 4);
        });

        // If user has avatar, we try to overlay it
        $avatarLoaded = false;

        // Optimize: Use local file path if available (avoids HTTP loopback)
        // if (($user->avatar_url !== null) && Storage::disk('public')->exists($user->avatar_url)) {
        //     try {
        //         $avatarPath = Storage::disk('public')->path($user->avatar_url);
        //         $avatar = $manager->read($avatarPath);
        //         $avatar->cover(240, 240);
        //         $image->place($avatar, 'top-left', 100, 195);
        //         $avatarLoaded = true;
        //     } catch (\Exception $e) {
        //         // Fallback to URL or initials
        //     }
        // }

        // $avatarUrl = $user->getAvatarUrl();
        // Fallback to URL if local load failed or didn't exist
        // if (!$avatarLoaded && $avatarUrl) {
        //     try {
        //         $avatarContent = file_get_contents($avatarUrl);
        //         if ($avatarContent) {
        //             $avatar = $manager->read($avatarContent);
        //             $avatar->cover(240, 240);
        //             $image->place($avatar, 'top-left', 100, 195);
        //             $avatarLoaded = true;
        //         }
        //     } catch (\Exception $e) {
        //         dd($e);
        //         // Fallback to initial
        //     }
        // }

        if (! $avatarLoaded) {
            $image->text(substr($user->username, 0, 1), 220, 315, function ($font) {
                $font->filename($this->fontPath);
                $font->size(100);
                $font->color(self::COLOR_PRIMARY);
                $font->align('center');
                $font->valign('middle');
            });
        }

        // Username and Level
        $image->text($user->username, 380, 275, function ($font) {
            $font->filename($this->fontPath);
            $font->size(72);
            $font->color(self::COLOR_WHITE);
            $font->align('left');
        });

        $image->text('Niveau '.($user->level ?? 1).' • '.$user->level_name, 380, 345, function ($font) {
            $font->filename($this->fontPath);
            $font->size(36);
            $font->color(self::COLOR_MUTED);
            $font->align('left');
        });

        // Stats Cards
        $this->drawStatCard($image, 380, 410, 'SÉRIE ACTUELLE', $user->current_streak.' JOURS', "\u{1F525}");
        $this->drawStatCard($image, 720, 410, 'XP TOTAL', number_format($user->xp_total ?? 0).' XP', "\u{2728}");

        return $image;
    }

    private function generateVerbImage(ImageManager $manager, Verb $verb)
    {
        $image = $this->createBaseCanvas($manager);

        $image->text('VERBE DU MOMENT', 600, 180, function ($font) {
            $font->filename($this->fontPath);
            $font->size(30);
            $font->color(self::COLOR_PRIMARY);
            $font->align('center');
        });

        $image->text(ucfirst($verb->infinitive), 600, 300, function ($font) {
            $font->filename($this->fontPath);
            $font->size(130);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
        });

        // Forms list
        $image->text('Past Simple : '.$verb->past_simple, 600, 420, function ($font) {
            $font->filename($this->fontPath);
            $font->size(45);
            $font->color(self::COLOR_MUTED);
            $font->align('center');
        });

        $image->text('Past Participle : '.$verb->past_participle, 600, 490, function ($font) {
            $font->filename($this->fontPath);
            $font->size(45);
            $font->color(self::COLOR_MUTED);
            $font->align('center');
        });

        return $image;
    }

    private function generateDailyVerbsImage(ImageManager $manager, User $user)
    {
        $image = $this->createBaseCanvas($manager);

        $image->text('VERBES DU JOUR', 600, 180, function ($font) {
            $font->filename($this->fontPath);
            $font->size(50);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
        });

        // Mocking/Getting random 5 verbs
        $user->generateDailyVerbs();
        $verbs = $user->dailyVerbs;

        $y = 280;
        foreach ($verbs as $verb) {
            $image->text(
                $verb->infinitive.' → '.$verb->past_simple.', '.$verb->past_participle,
                600,
                $y,
                function ($font) {
                    $font->filename($this->fontPath);
                    $font->size(24);
                    $font->color(self::COLOR_WHITE);
                    $font->align('center');
                }
            );
            $y += 65;
        }

        $image->text('Prêt à relever le défi ?', 600, 560, function ($font) {
            $font->filename($this->fontPath);
            $font->size(28);
            $font->color(self::COLOR_PRIMARY);
            $font->align('center');
        });

        return $image;
    }

    private function generateStatsImage(ImageManager $manager, User $user)
    {
        $image = $this->createBaseCanvas($manager);
        $masteredCount = $user->masteredVerbs()->count();

        $image->text('MAÎTRISE TOTALE', 600, 200, function ($font) {
            $font->filename($this->fontPath);
            $font->size(50);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
        });

        $image->text($masteredCount, 600, 360, function ($font) {
            $font->filename($this->fontPath);
            $font->size(180);
            $font->color(self::COLOR_PRIMARY);
            $font->align('center');
            $font->valign('middle');
        });

        $image->text('VERBES IRRÉGULIERS MAÎTRISÉS', 600, 480, function ($font) {
            $font->filename($this->fontPath);
            $font->size(35);
            $font->color(self::COLOR_MUTED);
            $font->align('center');
        });

        $image->text('Surpasse '.$user->username.' sur IrreguLearn !', 600, 560, function ($font) {
            $font->filename($this->fontPath);
            $font->size(28);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
        });

        return $image;
    }

    private function drawStatCard($image, $x, $y, $label, $value, $emoji)
    {
        $image->drawRectangle($x, $y, function ($draw) {
            $draw->size(320, 140);
            $draw->background('rgba(30, 41, 59, 0.8)'); // Slate 800 with alpha
            $draw->border('#334155', 2);
        });

        $image->text($emoji.' '.$label, $x + 20, $y + 45, function ($font) {
            $font->filename($this->fontPath);
            $font->size(18);
            $font->color('#64748b'); // Slate 500
        });

        $image->text($value, $x + 20, $y + 105, function ($font) {
            $font->filename($this->fontPath);
            $font->size(38);
            $font->color(self::COLOR_WHITE);
        });
    }

    /**
     * Generate a stunning weekly report image for social sharing.
     * Optimized for Instagram Stories, WhatsApp, and Facebook (1080x1920 portrait).
     */
    private function generateWeeklyReportImage(ImageManager $manager, WeeklyReport $report)
    {
        $user = $report->user;

        // Create portrait canvas for Instagram Stories (1080x1920)
        $image = $manager->create(1080, 1920);

        // Background gradient
        $image->fill('#0f172a');

        // Abstract decoration circles
        $image->drawCircle(900, 200, function ($draw) {
            $draw->radius(300);
            $draw->background('rgba(124, 58, 237, 0.15)');
        });

        $image->drawCircle(180, 1600, function ($draw) {
            $draw->radius(400);
            $draw->background('rgba(59, 130, 246, 0.1)');
        });

        // App Logo branding
        $image->drawRectangle(60, 60, function ($draw) {
            $draw->size(80, 80);
            $draw->background(self::COLOR_PRIMARY);
        });

        $image->text('IL', 100, 100, function ($font) {
            $font->filename($this->fontPath);
            $font->size(48);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
            $font->valign('middle');
        });

        $image->text('IrreguLearn', 160, 100, function ($font) {
            $font->filename($this->fontPath);
            $font->size(42);
            $font->color(self::COLOR_WHITE);
            $font->align('left');
            $font->valign('middle');
        });

        // Headline
        $image->text($user->username . "'s Verb Conquest", 540, 280, function ($font) {
            $font->filename($this->fontPath);
            $font->size(56);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
        });

        $image->text('This Week', 540, 360, function ($font) {
            $font->filename($this->fontPath);
            $font->size(48);
            $font->color(self::COLOR_MUTED);
            $font->align('center');
        });

        // Big Number - Verbs Mastered
        $image->text("\u{1F525}", 540, 600, function ($font) {
            $font->filename($this->fontPath);
            $font->size(120);
            $font->align('center');
        });

        // ...

        // Supporting Stats
        $yPos = 1100;
        $spacing = 160;

        // Current Streak
        $image->text("\u{1F525} " . $report->streak_at_end . ' Days Streak', 540, $yPos, function ($font) {
            $font->filename($this->fontPath);
            $font->size(38);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
        });

        // Weekly XP
        $yPos += $spacing;
        $image->text("\u{26A1} " . number_format($report->xp_earned) . ' XP Earned', 540, $yPos, function ($font) {
            $font->filename($this->fontPath);
            $font->size(38);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
        });

        // Rank Change (if available)
        if ($report->rank_change !== null) {
            $yPos += $spacing;
            $rankChange = $report->rank_change;
            $rankText = $rankChange > 0 
                ? "\u{1F4C8} Rank Up +" . $rankChange 
                : ($rankChange < 0 ? "\u{1F4C9} Rank -" . abs($rankChange) : "\u{27A1} Rank Stable");
            
            $image->text($rankText, 540, $yPos, function ($font) {
                $font->filename($this->fontPath);
                $font->size(38);
                $font->color(self::COLOR_WHITE);
                $font->align('center');
            });
        }

        // Call to Action
        $image->text('Build your streak →', 540, 1700, function ($font) {
            $font->filename($this->fontPath);
            $font->size(36);
            $font->color(self::COLOR_PRIMARY);
            $font->align('center');
        });

        $image->text('irregulearn.rf.gd', 540, 1780, function ($font) {
            $font->filename($this->fontPath);
            $font->size(42);
            $font->color(self::COLOR_WHITE);
            $font->align('center');
        });

        return $image;
    }
}
