<p align="center">
  <img src="https://via.placeholder.com/150x150?text=IL" alt="IrreguLearn Logo" width="80">
</p>

<h1 align="center">IrreguLearn</h1>

<p align="center">
  <strong>🎓 Gamified English Irregular Verbs Learning Platform</strong><br>
  Master English irregular verbs through engaging daily sessions with friends and community.
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#architecture">Architecture</a> •
  <a href="#installation">Installation</a> •
  <a href="#usage">Usage</a> •
  <a href="#data-models">Models</a>
</p>

---

## 🎯 About

**IrreguLearn** is a gamified web application designed to help French-speaking students learn and master English irregular verbs. It transforms the traditionally boring task of memorizing verb conjugations into an engaging, interactive experience with XP points, daily streaks, leaderboards, badges, and comprehensive social features.

---

## ✨ Features

### 📚 Learning System

-   **Categories** - Verbs organized by difficulty/topic (unlocked progressively with 70% mastery)
-   **Daily Verbs** - Personalized daily learning targets
-   **Favorites** - Bookmark verbs for later review
-   **Verb of the Day** - Featured verb on the homepage
-   **Multi-language Translations** - Support for multiple languages

### 🎮 Exercise Types

| Type        | Description                       |
| ----------- | --------------------------------- |
| Quiz        | Multiple choice questions         |
| Input       | Type the correct verb form        |
| Complete    | Fill in the blank                 |
| Jumble      | Rearrange scrambled letters       |
| Odd One Out | Find the verb that doesn't belong |
| Sentence    | Context-based verb exercises      |

### 🔥 Gamification System

-   **XP Points** - Earned for correct answers (weekly and total tracking)
-   **Streaks** - Daily practice tracking with timezone support
    -   Freeze streaks feature
    -   Best streak tracking
-   **Leaderboards** - Weekly rankings
-   **Badges** - Achievement system triggered by events
-   **Mastery Tracking** - Monitor progress on each verb

### 👥 Social Features

-   **Friendships** - Add friends and manage friend requests
-   **Public Profiles** - View other users' progress and achievements
-   **Point Transfers** - Gift XP points to friends
-   **Community Examples** - Submit verb usage examples with likes system
-   **Real-time Notifications** - Stay updated with notifications

### 🛠️ Additional Features

-   **Customizable Avatars** - Edit and personalize user avatars
-   **Global Search** - Search users and verbs
-   **Notification System** - Email and in-app notifications
-   **PDF Export** - Generate reports and verb lists
-   **Social Authentication** - Google Sign-In via OAuth
-   **Admin Panel** - Manage verbs, users, reports, and moderation
-   **Premium System** - Support for user subscriptions
-   **Referral Program** - Track user recommendations

---

## 🏗️ Architecture

### Technology Stack

| Layer                | Technology                         |
| -------------------- | ---------------------------------- |
| **Backend**          | Laravel 12 (PHP 8.2+)              |
| **Frontend**         | Livewire 3 + Blade templates       |
| **Styling**          | TailwindCSS 4                      |
| **Build Tool**       | Vite 7                             |
| **Database**         | MySQL / SQLite                     |
| **Authentication**   | Laravel Breeze + Laravel Socialite |
| **PDF Generation**   | DomPDF 3                           |
| **Image Processing** | Intervention Image 3               |
| **Icons**            | Blade Heroicons + Lucide Icons     |
| **Testing**          | PHPUnit 11                         |

### Project Structure

```
app/
├── Models/              # Eloquent models (User, Verb, Badge, etc.)
├── Http/
│   ├── Controllers/     # Controllers (Learn, Leaderboard, Admin, etc.)
│   ├── Middleware/      # Custom middleware
│   └── Requests/        # Form Request validation
├── Livewire/            # Interactive Livewire components
│   ├── LearnSession.php      # Learning session management
│   ├── DailyVerbs.php        # Daily verb management
│   ├── AddToFavsButton.php   # Favorites system
│   ├── GlobalSearch.php      # Global search functionality
│   ├── TransferPoints.php    # Point transfer between friends
│   └── Admin/                # Administration interface
├── Events/              # Events (ExerciseCompleted, StreakUpdated)
├── Listeners/           # Event listeners
├── Jobs/                # Background jobs (PDF export, reports)
├── Mail/                # Email templates
├── Notifications/       # User notifications
└── Services/            # Reusable business logic

resources/
├── views/               # Blade templates
├── css/                 # TailwindCSS styles
└── js/                  # JavaScript / Alpine.js

database/
├── migrations/          # Database schema
└── seeders/             # Database seeders

config/
└── *.php                # Configuration files

tests/
├── Feature/             # Feature tests
└── Unit/                # Unit tests
```

---

## 📦 Installation

### Prerequisites

-   PHP 8.2 or higher
-   Node.js 18+
-   Composer
-   MySQL 8.0 or SQLite

### Setup Steps

```bash
# Clone the repository
git clone https://github.com/your-username/irregulearn-app.git
cd irregulearn-app

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Environment configuration
cp .env.example .env
php artisan key:generate

# Configure database
# Edit .env and set DB_CONNECTION, DB_DATABASE, etc.

# Run migrations and seed database
php artisan migrate --seed

# Build assets
npm run build

# (Optional) Development mode with hot reload
npm run dev

# Start the development server
php artisan serve
```

The application will be available at `http://localhost:8000`

### Recommended Configuration

-   Set timezone in `.env`: `APP_TIMEZONE=Europe/Paris`
-   Enable HTTPS in production
-   Configure email service (Mailgun, SendGrid, etc.)
-   Setup Google OAuth if needed

---

## 🚀 Usage

### For Users

1. Create an account and verify your email
2. Set up your avatar and daily learning target
3. Complete daily verb exercises
4. Maintain your streak and earn XP points
5. Add friends and compete on the leaderboard
6. Unlock badges and categories through mastery

### For Administrators

1. Access the admin panel at `/admin`
2. Manage verbs and categories
3. Moderate community examples
4. Review usage reports and analytics
5. Manage user accounts and roles

---

## 📊 Data Models

### Core Models

-   **User** - User profiles (roles, streaks, XP points, timezone, avatar)
-   **Verb** - Irregular verbs (infinitive, past simple, past participle, descriptions)
-   **Category** - Thematic verb groups (progressively unlockable)
-   **VerbExample** - Community-submitted verb examples (with likes)
-   **VerbSentence** - Contextual sentences for exercises
-   **VerbTranslation** - Multi-language translations
-   **Badge** - Achievements and accomplishments
-   **Friendship** - Social relationships between users
-   **PointTransfer** - XP point transfer history
-   **ExampleLike** - Like system for community examples
-   **Report** - Exercise reports for analytics

### Key Relationships

-   A User can have multiple Friendships (friends)
-   A Verb belongs to multiple Categories
-   A User can earn multiple Badges through events
-   A Verb can have multiple VerbExamples (community)
-   A User can favorite multiple Verbs

---

## 🔄 Event Flow

-   **ExerciseCompleted** - Triggers user statistics update
-   **StreakUpdated** - Notifies streak changes
-   These events activate listeners for:
    -   Badge achievement checking (`CheckBadges`)
    -   User statistics update (`UpdateUserStats`)
    -   Streak milestone handling (`HandleStreakMilestones`)
    -   Initial user data setup (`InitializeUserData`)

---

## 📧 Email Notifications

The application sends emails for:

-   **WelcomeMail** - Welcome after registration
-   **DailyVerbsMail** - Daily reminder with verb of the day
-   **VerbsExportMail** - Verb export in PDF format
-   **WeeklyReportMail** - Weekly progress report

---

## 🛠️ Development

### Available Scripts

```bash
# Development mode with hot reload
npm run dev

# Production build
npm run build

# Run tests
php artisan test

# Code linting and formatting
composer pint
./vendor/bin/phpcs

# Database migration rollback
php artisan migrate:rollback

# Laravel Tinker REPL
php artisan tinker
```

### Database Commands

```bash
# Create a new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Reset to initial state
php artisan migrate:fresh --seed
```

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👥 Contributing

Contributions are welcome! Feel free to open issues and submit pull requests to help improve IrreguLearn.
