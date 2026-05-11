<x-layouts.app title="Modifier vente — OptiGest">

    <div style="max-width:60%; margin:0 auto;">

        <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px;">
            <a href="{{ route('ventes.show', $vente) }}"
               style="width:44px; height:44px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f0f7ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; text-decoration:none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 style="font-size:26px; font-weight:800; color:#0f172a; margin:0;">Modifier — {{ $vente->numero_facture }}</h1>
                <p style="font-size:16px; color:#94a3b8; margin:6px 0 0;">Modifier les informations générales de la vente</p>
            </div>
        </div>

        <form method="POST" action="{{ route('ventes.update', $vente) }}">
            @csrf
            @method('PUT')

            <div style="background:#fff; border-radius:18px; border:1px solid #bfdbfe; padding:28px; box-shadow:0 4px 14px rgba(29,78,216,0.07); margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 24px; padding-bottom:16px; border-bottom:1.5px solid #f0f7ff;">Informations générales</h2>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Date de vente <span style="color:#ef4444;">*</span></label>
                        <input type="date" name="date_vente" value="{{ old('date_vente', $vente->date_vente->format('Y-m-d')) }}"
                               style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                    </div>
                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Statut paiement</label>
                        <select name="statut_paiement"
                                style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                            <option value="non_paye" {{ old('statut_paiement', $vente->statut_paiement)=='non_paye'?'selected':'' }}>Non payé</option>
                            <option value="partiel" {{ old('statut_paiement', $vente->statut_paiement)=='partiel'?'selected':'' }}>Partiel</option>
                            <option value="solde" {{ old('statut_paiement', $vente->statut_paiement)=='solde'?'selected':'' }}>Soldé</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Remise globale %</label>
                        <input type="number" name="remise" value="{{ old('remise', $vente->remise) }}" min="0" max="100" step="0.01"
                               style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                    </div>
                    <div>
                        <label style="display:block; font-size:15px; font-weight:600; color:#334155; margin-bottom:10px;">Remarque</label>
                        <input type="text" name="remarque" value="{{ old('remarque', $vente->remarque) }}"
                               style="width:100%; height:50px; border-radius:12px; border:1.5px solid #bfdbfe; background:#f8fbff; padding:0 16px; font-size:16px; color:#0f172a; outline:none; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif;">
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <a href="{{ route('ventes.show', $vente) }}"
                   style="height:52px; padding:0 28px; border-radius:12px; border:1.5px solid #e2e8f0; color:#64748b; font-size:16px; font-weight:600; text-decoration:none; display:flex; align-items:center; background:#f8fafc;">
                    Annuler
                </a>
                <button type="submit"
                        style="height:52px; padding:0 32px; border-radius:12px; background:#1d4ed8; border:none; color:#fff; font-size:16px; font-weight:700; cursor:pointer; box-shadow:0 4px 14px rgba(29,78,216,0.35); font-family:'Plus Jakarta Sans',sans-serif;">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>

</x-layouts.app>
