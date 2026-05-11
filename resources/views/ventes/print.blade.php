<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture {{ $vente->numero_facture }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #fff; color: #0f172a; font-size: 13px; }
        .page { width: 148mm; min-height: 210mm; margin: 0 auto; padding: 10mm 12mm; }

        /* En-tête */
        .header { display: flex; justify-content: space-between; align-items: flex-start;
                  padding-bottom: 5mm; border-bottom: 2px solid #1d4ed8; margin-bottom: 6mm; }
        .logo    { font-size: 20px; font-weight: 800; color: #1d4ed8; }
        .logo-sub { font-size: 10px; color: #94a3b8; margin-top: 2px; }
        .facture-num  { font-size: 15px; font-weight: 800; color: #1d4ed8; text-align: right; }
        .facture-date { font-size: 11px; color: #64748b; margin-top: 3px; text-align: right; }

        /* Client — centré, épuré */
        .client-section {
            text-align: center;
            margin-bottom: 6mm;
            padding: 7px 0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        .client-name { font-size: 14px; font-weight: 800; color: #0f172a; }
        .client-cin  { font-size: 12px; color: #64748b; margin-top: 3px; }

        /* Tableau simplifié */
        table { width: 100%; border-collapse: collapse; margin-bottom: 5mm; }
        thead tr { background: #1d4ed8; }
        thead th { padding: 8px 12px; font-size: 12px; font-weight: 700; color: #fff; }
        thead th:first-child { text-align: left; }
        thead th:last-child  { text-align: right; }
        tbody tr { border-bottom: 1px solid #e2e8f0; }
        tbody tr:nth-child(even) { background: #f8fbff; }
        tbody td { padding: 8px 12px; font-size: 13px; color: #334155; }
        tbody td:last-child { text-align: right; font-weight: 700; }

        /* Total */
        .total-line {
            display: flex; justify-content: space-between; align-items: center;
            border-top: 2px solid #1d4ed8; padding-top: 5px; margin-top: 2px;
        }
        .total-label { font-size: 14px; font-weight: 700; }
        .total-value { font-size: 18px; font-weight: 800; color: #1d4ed8; }

        /* Statut */
        .statut { display: inline-block; padding: 3px 12px; border-radius: 99px; font-size: 11px; font-weight: 700; margin-top: 5mm; }
        .statut-non_paye { background: #fee2e2; color: #ef4444; }
        .statut-partiel  { background: #fef9c3; color: #ca8a04; }
        .statut-solde    { background: #dcfce7; color: #16a34a; }

        /* Footer */
        .footer { margin-top: 10mm; text-align: center; font-size: 10px; color: #94a3b8;
                  border-top: 1px solid #e2e8f0; padding-top: 4mm; }

        @media print {
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align:center; padding:14px; background:#f0f7ff; border-bottom:1px solid #bfdbfe;">
        <button onclick="window.print()"
                style="padding:10px 28px; border-radius:10px; background:#1d4ed8; border:none; color:#fff;
                       font-size:14px; font-weight:700; cursor:pointer; margin-right:10px; font-family:'Plus Jakarta Sans',sans-serif;">
            Imprimer
        </button>
        <a href="{{ route('ventes.show', $vente) }}"
           style="padding:10px 20px; border-radius:10px; border:1.5px solid #bfdbfe; background:#fff;
                  color:#1d4ed8; font-size:14px; font-weight:600; text-decoration:none;">
            Retour
        </a>
    </div>

    <div class="page">

        {{-- En-tête --}}
        <div class="header">
            <div>
                <div class="logo">OptiGest</div>
                <div class="logo-sub">Gestion Optique</div>
            </div>
            <div>
                <div class="facture-num">{{ $vente->numero_facture }}</div>
                <div class="facture-date">{{ $vente->date_vente->format('d/m/Y') }}</div>
            </div>
        </div>

        {{-- Client --}}
        <div class="client-section">
            <div class="client-name">{{ $vente->client->nom_complet }}</div>
            <div class="client-cin">N° CIN : {{ $vente->client->cin ?? '—' }}</div>
        </div>

        {{-- Tableau : Désignation | Total --}}
        <table>
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th style="text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vente->lignes as $ligne)
                <tr>
                    <td>{{ $ligne->designation }}</td>
                    <td>{{ number_format($ligne->sous_total, 2) }} MAD</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Total TTC --}}
        <div class="total-line">
            <span class="total-label">
                Total TTC
                @if($vente->remise > 0)
                    <span style="font-size:11px; color:#94a3b8; font-weight:500;">(remise {{ $vente->remise }}%)</span>
                @endif
            </span>
            <span class="total-value">{{ number_format($vente->total_ttc, 2) }} MAD</span>
        </div>

        {{-- Statut --}}
        <div>
            <span class="statut statut-{{ $vente->statut_paiement }}">
                @if($vente->statut_paiement === 'non_paye') Non payé
                @elseif($vente->statut_paiement === 'partiel') Paiement partiel — Reste : {{ number_format($vente->reste_a_payer, 2) }} MAD
                @else Soldé
                @endif
            </span>
        </div>

        @if($vente->remarque)
        <div style="margin-top:5mm; font-size:11px; color:#92400e; padding:6px 10px;
                    background:#fefce8; border-radius:5px; border:1px solid #fde68a;">
            {{ $vente->remarque }}
        </div>
        @endif

        <div class="footer">Merci pour votre confiance — OptiGest</div>

    </div>

</body>
</html>
