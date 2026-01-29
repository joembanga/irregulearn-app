<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserAvatar extends Component
{
    public int $userId;

    public int $size1;

    public ?int $size2 = null;

    public bool $hasAvatar;

    public function mount(int $userId, int $size1, ?int $size2 = null)
    {
        $this->userId = $userId;
        $this->size1 = $size1;
        if ($size2) {
            $this->size2 = $size2;
        }
    }

    public function render()
    {
        $user = User::find($this->userId);
        if (!empty($user->avatar_code)) {
            $this->hasAvatar = true;
        } else {
            $this->hasAvatar = false;
        }
        $url = $user->getAvatarUrl();
        $username = $user->username;
        return view('livewire.user-avatar', compact('url', 'username'));
    }
}
