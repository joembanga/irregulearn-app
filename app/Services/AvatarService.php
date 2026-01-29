<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AvatarService
{
    /**
     * Download avatar from Avataaars API and save it locally.
     *
     * @param User $user
     * @param string|null $avatarCode Optional custom avatar code, otherwise uses user's current code
     * @return string|false The relative path to the saved avatar or false on failure
     */
    public function downloadAndSave(User $user, ?string $avatarCode = null): string|false
    {
        $code = $avatarCode ?? $user->avatar_code;

        if (empty($code)) {
            return false;
        }

        $url = 'https://avataaars.io/?' . $code;

        try {
            // Download the image
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                $content = $response->body();

                // Generate a unique filename or use user ID to overwrite
                $filename = 'avatars/' . $user->id . '.svg';

                // Ensure directory exists
                if (!Storage::disk('public')->exists('avatars')) {
                    Storage::disk('public')->makeDirectory('avatars');
                }

                // Save to public disk
                Storage::disk('public')->put($filename, $content);

                // Update user model with local path
                $user->avatar_url = $filename;
                $user->save();

                return $filename;
            }
        } catch (\Exception $e) {
            // Log error if needed, but for now just return false
            // Log::error("Failed to download avatar for user {$user->id}: {$e->getMessage()}");
        }

        return false;
    }
}
