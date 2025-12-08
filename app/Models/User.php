<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\StatutUser;
use App\Notifications\VerifyEmailCustom;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * Class User
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $sexe
 * @property Carbon $date_naissance
 * @property string $statut
 * @property string|null $photo
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id_role
 * @property int $id_langue
 *
 * @property Langue $langue
 * @property Role $role
 * @property Collection|Commentaire[] $commentaires
 * @property Collection|Contenu[] $contenus
 *
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail
{
	use HasFactory, Notifiable;
	protected $table = 'users';

	protected $casts = [
		'date_naissance' => 'date',
		'email_verified_at' => 'datetime',
		'id_role' => 'int',
		'id_langue' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'sexe',
		'date_naissance',
		'statut',
		'photo',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
		'id_role',
		'id_langue',
		'google2fa_enabled',
		'google2fa_secret'
	];

	protected $attributes = [
		'statut'=>StatutUser::ACTIVE,
		'id_role'=>7
	];



	/**
	 * Send the email verification notification (personnalisé).
	 */
	public function sendEmailVerificationNotification()
	{
		$this->notify(new VerifyEmailCustom());
	}
	public function langue()
	{
		return $this->belongsTo(Langue::class, 'id_langue');
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'id_role');
	}

	public function commentaires()
	{
		return $this->hasMany(Commentaire::class, 'id_user');
	}

	public function contenus()
	{
		return $this->hasMany(Contenu::class, 'id_auteur');
	}
    public function aPaye(Contenu $contenu): bool
    {
        return $this->paiements()
            ->where('contenu_id', $contenu->id)
            ->where('statut', 'success')
            ->exists();
    }

    /**
     * Relation avec les paiements
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

	// app/Models/User.php

	public function isAdmin(): bool
	{
		return (int) $this->id_role === 4;
	}

	public function isManager(): bool
	{
		return (int) $this->id_role === 2;
	}

	public function isAdminOrManager(): bool
	{
		return $this->isAdmin() || $this->isManager();
	}
}
