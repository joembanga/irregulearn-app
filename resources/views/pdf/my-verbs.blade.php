<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 40px;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            color: var(--color-text, #1F2937);
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-content: center;
            border-bottom: 2px solid var(--color-primary, #7C3AED);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--color-primary, #7C3AED);
            text-transform: uppercase;
        }

        .user-info {
            text-align: right;
        }

        .user-info h1 {
            margin: 0;
            font-size: 18px;
        }

        /* Stats */
        .stats-bar {
            background: var(--color-bg, #F3F4F6);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .stats-bar span {
            font-weight: bold;
            color: var(--color-primary, #4F46E5);
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: var(--color-primary, #7C3AED);
            color: var(--color-surface, white);
            padding: 12px 8px;
            text-align: left;
            font-size: 13px;
            text-transform: uppercase;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid var(--color-muted, #E5E7EB);
            font-size: 12px;
        }

        tr:nth-child(even) {
            background-color: var(--color-bg, #F9FAFB);
        }

        thead {
            display: table-header-group;
        }

        .col-index {
            color: var(--color-muted, #9CA3AF);
            font-size: 10px;
            text-align: center;
            font-weight: normal;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: var(--color-muted, #9CA3AF);
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">IrreguLearn</div>
        <div class="user-info">
            <h1>{{ $user->username }}</h1>
            <p>{{ $date }}</p>
        </div>
    </div>

    <div class="stats-bar">
        @php
        $masteredCount = $user->masteredVerbs()?->count();
        $total = $verbs->count();
        $percent = ($total > 0) ? round(($masteredCount / $total) * 100) : 0;
        @endphp
        Progression globale : <span>{{ $masteredCount }} / {{ $total }} verbes maîtrisés ({{ $percent }}%)</span>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-index">N</th>
                <th></th>
                <th>Infinitive</th>
                <th>Past Simple</th>
                <th>Past Participle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($verbs as $verb)
            @php $isMastered = $verb->isMasteredBy($user); @endphp
            <tr>
                <td class="col-index">{{ $loop->iteration }}</td>
                <td style="display: flex; justify-content: center; text-align: center;">
                    @if ($isMastered)
                        <img src="{{ public_path('images/check_circle_24dp_00BD84_FILL0_wght400_GRAD0_opsz24.png') }}" alt="checked icon" style="width: 16px;">
                    @else
                    -
                    @endif
                </td>
                <td style="font-weight: bold;">{{ $verb->infinitive }}</td>
                <td>{{ $verb->past_simple }}</td>
                <td>{{ $verb->past_participle }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Généré par IrreguLearn — Apprenez vos verbes irréguliers sur <a href="http://www.irregulearn.com">www.irregulearn.com</a>
    </div>
</body>

</html>