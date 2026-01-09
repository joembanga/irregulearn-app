<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AvatarEditor extends Component
{
    public $settings = [];

    // Ton JSON complet converti en Array PHP
    public $options = [
        'avatarStyle' => ['Circle'],
        'topType' => ['NoHair', 'Eyepatch', 'Hat', 'Hijab', 'Turban', 'WinterHat1', 'WinterHat2', 'WinterHat3', 'WinterHat4', 'LongHairBigHair', 'LongHairBob', 'LongHairBun', 'LongHairCurly', 'LongHairCurvy', 'LongHairDreads', 'LongHairFrida', 'LongHairFro', 'LongHairFroBand', 'LongHairNotTooLong', 'LongHairShavedSides', 'LongHairMiaWallace', 'LongHairStraight', 'LongHairStraight2', 'LongHairStraightStrand', 'ShortHairDreads01', 'ShortHairDreads02', 'ShortHairFrizzle', 'ShortHairShaggyMullet', 'ShortHairShortCurly', 'ShortHairShortFlat', 'ShortHairShortRound', 'ShortHairShortWaved', 'ShortHairSides', 'ShortHairTheCaesar', 'ShortHairTheCaesarSidePart'],
        'accessoriesType' => ['Blank', 'Kurt', 'Prescription01', 'Prescription02', 'Round', 'Sunglasses', 'Wayfarers'],
        'hairColor' => ['Auburn', 'Black', 'Blonde', 'BlondeGolden', 'Brown', 'BrownDark', 'PastelPink', 'Blue', 'Platinum', 'Red', 'SilverGray'],
        'facialHairType' => ['Blank', 'BeardMedium', 'BeardLight', 'BeardMajestic', 'MoustacheFancy', 'MoustacheMagnum'],
        'facialHairColor' => ['Auburn', 'Black', 'Blonde', 'BlondeGolden', 'Brown', 'BrownDark', 'Platinum', 'Red'],
        'clotheType' => ['BlazerShirt', 'BlazerSweater', 'CollarSweater', 'GraphicShirt', 'Hoodie', 'Overall', 'ShirtCrewNeck', 'ShirtScoopNeck', 'ShirtVNeck'],
        'clotheColor' => ['Black', 'Blue01', 'Blue02', 'Blue03', 'Gray01', 'Gray02', 'Heather', 'PastelBlue', 'PastelGreen', 'PastelOrange', 'PastelRed', 'PastelYellow', 'Pink', 'Red', 'White'],
        'graphicType' => ['Bat', 'Cumbia', 'Deer', 'Diamond', 'Hola', 'Pizza', 'Resist', 'Selena', 'Bear', 'SkullOutline', 'Skull'],
        'eyeType' => ['Close', 'Cry', 'Default', 'Dizzy', 'EyeRoll', 'Happy', 'Hearts', 'Side', 'Squint', 'Surprised', 'Wink', 'WinkWacky'],
        'eyebrowType' => ['Angry', 'AngryNatural', 'Default', 'DefaultNatural', 'FlatNatural', 'RaisedExcited', 'RaisedExcitedNatural', 'SadConcerned', 'SadConcernedNatural', 'UnibrowNatural', 'UpDown', 'UpDownNatural'],
        'mouthType' => ['Concerned', 'Default', 'Disbelief', 'Eating', 'Grimace', 'Sad', 'ScreamOpen', 'Serious', 'Smile', 'Tongue', 'Twinkle', 'Vomit'],
        'skinColor' => ['Tanned', 'Yellow', 'Pale', 'Light', 'Brown', 'DarkBrown', 'Black'],
        'hatColor' => ['Black', 'Blue01', 'Blue02', 'Blue03', 'Gray01', 'Gray02', 'Heather', 'PastelBlue', 'PastelGreen', 'PastelOrange', 'PastelRed', 'PastelYellow', 'Pink', 'Red', 'White'],
    ];

    // On peut garder quelques exclusivités Premium ici
    public $premiumOptions = [
        'accessoriesType' => ['Sunglasses', 'Wayfarers'],
        'topType' => ['WinterHat4', 'LongHairFrida', 'ShortHairDreads02'],
        'graphicType' => ['Skull', 'Diamond', 'Bear'],
    ];

    public function mount()
    {
        if (Auth::user()->avatar_code) {
            parse_str(Auth::user()->avatar_code, $this->settings);
        } else {
            $this->generateRandom();
            $this->save();
        }
    }

    public function updateProperty($property, $value)
    {
        if (isset($this->premiumOptions[$property]) && in_array($value, $this->premiumOptions[$property])) {
            if (Auth::user()->xp_balance < 500) {
                session()->flash('message', '🔒 500 XP requis !');
                return;
            }
        }
        $this->settings[$property] = $value;
    }

    public function generateRandom()
    {
        foreach ($this->options as $key => $values) {
            $this->settings[$key] = $values[array_rand($values)];
        }
    }

    public function save()
    {
        // dd($this->settings);
        $queryString = http_build_query($this->settings);
        /** @var User $user */
        $user = Auth::user();
        $user->avatar_code = $queryString;
        $user->save();
        session()->flash('message', 'Apparence sauvegardée ! ⚡');
    }

    public function render()
    {
        $currentUrl = "https://avataaars.io/?" . http_build_query($this->settings);
        return view('livewire.avatar-editor', ['currentUrl' => $currentUrl]);
    }
}