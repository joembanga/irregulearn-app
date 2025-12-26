# Project: VerbMaster ⚡

**Description :** Application gamifiée d'apprentissage des verbes irréguliers anglais.
**Stack :** Laravel 11, Livewire 3, Tailwind CSS, Filament PHP (Admin), MySQL.

---

## 🏗️ Architecture des Données (Models & Relations)

### 1. Core Learning

* **Verb** : `id, infinitive, past_simple, past_participle, level (enum), created_at...`
* **Category** : `id, name, slug, description, order, cout, created_at...`
* **Pivot `category_verb**` : Relation Many-to-Many entre Verbes et Catégories.

### 2. Gamification & Users

* **User** : `id, username, email, password, xp (default 0), is_admin (bool), avatar (filename), created_at...`
* **Badge** : `id, name, slug, icon (emoji), description, category, threshold, created_at...`
* **Pivot `badge_user**` : Badges débloqués par l'utilisateur.
* **Pivot `verb_user**` : `user_id, verb_id, mastered (bool)`. Suivi de la maîtrise par verbe.

### 3. Economy (Shop)

* **AvatarItem** : `id, filename, name, price (XP), is_premium (bool)`.
* **Pivot `avatar_user**` : Inventaire des avatars achetés par l'utilisateur.

---

## 🚀 Fonctionnalités Clés

### 🧠 Apprentissage (Livewire: `CategoryLearn`)

* **Système de Roadmap** : Progression par catégories verrouillées par le score XP.
* **Types d'exercices dynamiques** :
* `Input` : Saisie manuelle du Past Simple.
* `Quiz` : QCM avec 4 choix (distracteurs générés dynamiquement).
* `Jumble` : Reconstitution du mot en cliquant sur des lettres mélangées.


* **Feedback Immédiat** : Validation temps réel, gain d'XP (+10) et audio via Web Speech API.

### 🏆 Gamification

* **Profil Public** : Affichage des stats (XP, Rang, Trophées) et leaderboard global.
* **Système de Badges** : Déblocage automatique via `GamificationService` lors du gain d'XP.
* **Boutique d'Avatars** : Achat d'avatars exclusifs en dépensant l'XP accumulé.

### 🛠️ Administration (Filament PHP)

* **Panel `/admin**` : Gestion CRUD des verbes et catégories.
* **Import CSV** : Module d'import massif de verbes avec mapping de colonnes.
* **Dashboard Widgets** : Graphiques d'inscription, total XP distribué et flux d'activité.

---

## 📱 Interface & UX

* **Design** : Mobile-first avec une "Tab Bar" basse pour smartphone.
* **Responsive** : Grilles adaptatives (QCM 2 colonnes sur desktop, 1 sur mobile).
* **Thème** : Support Dark Mode via Tailwind.

---

## 🛠️ Instructions pour l'IA

* Utiliser **Livewire 3** pour toute interactivité (pas de JS pur si possible).
* Respecter les classes **Tailwind CSS** utilitaires pour le style.
* Pour les requêtes Eloquent, toujours optimiser les relations (Eager Loading) pour éviter les problèmes N+1 sur les pivots.
* Toute nouvelle fonctionnalité doit s'intégrer dans la logique de gain d'XP existante.