<p align="center">
  <img src="https://via.placeholder.com/150x150?text=IL" alt="IrreguLearn Logo" width="80">
</p>

<h1 align="center">IrreguLearn</h1>

<p align="center">
  <strong>Gamified English Irregular Verbs Learning Platform</strong><br>
  Master irregular verbs through fun, short daily sessions with friends.
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#tech-stack">Tech Stack</a> •
  <a href="#installation">Installation</a> •
  <a href="#usage">Usage</a>
</p>

---

## 🎯 About

**IrreguLearn** is a gamified web application designed to help French-speaking students learn and master English irregular verbs. It transforms the traditionally boring task of memorizing verb conjugations into an engaging, game-like experience with XP points, streaks, leaderboards, and social features.

---

## ✨ Features

### 📚 Learning System
- **Categories** - Verbs organized by difficulty/topic (unlocked progressively with 70% mastery)
- **Daily Verbs** - Personalized daily targets
- **Favorites** - Bookmark verbs for later review
- **Verb of the Day** - Featured verb on the homepage

### 🎮 Exercise Types
| Type | Description |
|------|-------------|
| Quiz | Multiple choice questions |
| Input | Type the correct verb form |
| Complete | Fill in the blank |
| Jumble | Rearrange scrambled letters |
| Odd One Out | Find the verb that doesn't belong |
| Sentence | Context-based verb exercises |

### 🔥 Gamification
- **XP Points** - Earned for correct answers
- **Streaks** - Daily practice tracking with timezone support
- **Leaderboard** - Weekly rankings
- **Badges** - Achievement system
- **Mastery Tracking** - Track which verbs you've mastered

### 👥 Social Features
- **Friendships** - Add friends, send/accept requests
- **Public Profiles** - View other users' progress
- **Point Transfers** - Gift XP points to friends
- **Community Examples** - Submit verb usage examples (with likes)

### 🛠️ Additional Features
- Customizable avatars
- Search functionality
- Notifications system
- Export verbs to PDF
- Admin panel (verb/user management, reports)

---

## 🏗️ Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel (PHP) |
| Frontend | Livewire + Blade |
| Styling | TailwindCSS |
| Build | Vite |
| Database | MySQL/SQLite |
| Auth | Laravel Breeze |

---

## 📦 Installation

```bash
# Clone the repository
git clone https://github.com/your-username/irregulearn-app.git
cd irregulearn-app

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed

# Build assets
npm run build

# Start the server
php artisan serve
```

---

## 🚀 Usage

1. Register an account and verify your email
2. Set your daily learning target
3. Complete daily verb exercises
4. Maintain your streak and earn XP
5. Add friends and compete on the leaderboard

---

## 📊 Data Models

- `User` - Roles, streaks, points, timezone
- `Verb` - Infinitive, past simple, past participle, translation
- `Category` - Verb organization
- `Badge` - Achievements
- `Friendship` - Social connections
- `VerbExample` - Community examples
- `VerbSentence` - Contextual sentences

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
