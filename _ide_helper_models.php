<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string|null $classement_registre
 * @property string $nom
 * @property string $prenom
 * @property string $cin
 * @property string|null $genre
 * @property \Illuminate\Support\Carbon|null $date_naissance
 * @property string $telephone
 * @property string|null $email
 * @property string|null $adresse
 * @property string $type
 * @property bool $is_active
 * @property string|null $observations
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ordonnance|null $derniereOrdonnance
 * @property-read string $initiales
 * @property-read string $nom_complet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ordonnance> $ordonnances
 * @property-read int|null $ordonnances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rappel> $rappels
 * @property-read int|null $rappels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RendezVous> $rendezVous
 * @property-read int|null $rendez_vous_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereClassementRegistre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client whereUpdatedAt($value)
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $client_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $date_ordonnance
 * @property string|null $medecin
 * @property numeric|null $od_sphere
 * @property numeric|null $od_cylindre
 * @property numeric|null $od_axe
 * @property numeric|null $og_sphere
 * @property numeric|null $og_cylindre
 * @property numeric|null $og_axe
 * @property numeric|null $addition
 * @property numeric|null $ecart_pupillaire
 * @property string|null $remarques
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read mixed $date_eligibilite
 * @property-read int $jours_restants
 * @property-read \App\Models\Rappel|null $rappel
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereAddition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereDateOrdonnance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereEcartPupillaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereMedecin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereOdAxe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereOdCylindre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereOdSphere($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereOgAxe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereOgCylindre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereOgSphere($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereRemarques($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ordonnance whereUserId($value)
 */
	class Ordonnance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $vente_id
 * @property int $user_id
 * @property numeric $montant
 * @property string $mode_paiement
 * @property \Illuminate\Support\Carbon $date_paiement
 * @property string|null $reference
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Vente $vente
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereDatePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereModePaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paiement whereVenteId($value)
 */
	class Paiement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $reference
 * @property string $designation
 * @property string $categorie
 * @property string|null $marque
 * @property string|null $modele
 * @property numeric $prix_achat
 * @property numeric $prix_vente
 * @property int $quantite_stock
 * @property int $seuil_alerte
 * @property bool $is_active
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $categorie_label
 * @property-read bool $stock_faible
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockMouvement> $stockMouvements
 * @property-read int|null $stock_mouvements_count
 * @method static \Database\Factories\ProduitFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereCategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereMarque($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereModele($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit wherePrixAchat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit wherePrixVente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereQuantiteStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereSeuilAlerte($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produit whereUpdatedAt($value)
 */
	class Produit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $client_id
 * @property int $ordonnance_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon $date_reference
 * @property \Illuminate\Support\Carbon $date_eligibilite
 * @property \Illuminate\Support\Carbon $date_rappel_prevu
 * @property string $statut
 * @property string|null $note_contact
 * @property int|null $traite_par
 * @property \Illuminate\Support\Carbon|null $traite_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read int $jours_avant_rappel
 * @property-read string $urgence
 * @property-read \App\Models\Ordonnance $ordonnance
 * @property-read \App\Models\User|null $traitePar
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereDateEligibilite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereDateRappelPrevu($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereDateReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereNoteContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereOrdonnanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereTraiteAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereTraitePar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rappel whereUserId($value)
 */
	class Rappel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $client_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $date_heure
 * @property string $motif
 * @property string|null $commentaire
 * @property string $statut
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read string $date
 * @property-read string $heure
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous whereDateHeure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RendezVous whereUserId($value)
 */
	class RendezVous extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $produit_id
 * @property int $user_id
 * @property string $type
 * @property int $quantite
 * @property int $stock_avant
 * @property int $stock_apres
 * @property string|null $motif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Produit $produit
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereProduitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereStockApres($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereStockAvant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMouvement whereUserId($value)
 */
	class StockMouvement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $client_id
 * @property int $user_id
 * @property int|null $ordonnance_id
 * @property string $numero_facture
 * @property \Illuminate\Support\Carbon $date_vente
 * @property numeric $remise
 * @property numeric $total_ht
 * @property numeric $total_ttc
 * @property string $statut_paiement
 * @property string|null $remarque
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read float $montant_paye
 * @property-read float $reste_a_payer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VenteLigne> $lignes
 * @property-read int|null $lignes_count
 * @property-read \App\Models\Ordonnance|null $ordonnance
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Paiement> $paiements
 * @property-read int|null $paiements_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereDateVente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereNumeroFacture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereOrdonnanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereRemarque($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereRemise($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereStatutPaiement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereTotalHt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereTotalTtc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vente whereUserId($value)
 */
	class Vente extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $vente_id
 * @property int|null $produit_id
 * @property string $designation
 * @property int $quantite
 * @property numeric $prix_unitaire
 * @property numeric $remise_ligne
 * @property numeric $sous_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Produit|null $produit
 * @property-read \App\Models\Vente $vente
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne wherePrixUnitaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne whereProduitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne whereQuantite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne whereRemiseLigne($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne whereSousTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VenteLigne whereVenteId($value)
 */
	class VenteLigne extends \Eloquent {}
}

